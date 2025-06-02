<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PragmaRX\Google2FALaravel\Google2FA;
use App\Models\Usuario;
use Illuminate\Support\Facades\Crypt;

class TwoFactorController extends Controller
{
    public function enable2FA(Request $request)
    {
        $user = auth()->user();

        // Generar clave secreta
        $google2fa = app('pragmarx.google2fa');
        $secret = $google2fa->generateSecretKey();

        // Guardarla en la base de datos del usuario
        $user->google2fa_secret = $secret;
        /** @var \App\Models\Usuario $user */
        $user->save();

        // Redireccionar a vista para mostrar QR
        return view('auth.2fa.qr', [
            'secret' => $secret,
            'QR_Image' => $google2fa->getQRCodeInline(
                'Sistema Contable Cayetano',
                $user->email,
                $secret
            ),
        ]);
    }

    public function showValidateForm()
    {
        return view('auth.2fa.verify');
    }

    public function verifyCode(Request $request)
    {
        $user = auth()->user();
        $request->validate(['code' => 'required|digits:6']);

        $google2fa = app('pragmarx.google2fa');

        if ($google2fa->verifyKey($user->google2fa_secret, $request->input('code'))) {
            session(['2fa_passed' => true]);
            return redirect()->intended('/dashboard');
        } else {
            return back()->withErrors(['code' => 'Código incorrecto.']);
        }
    }

    public function activarDesdeAdmin($id)
    {
        $usuario = Usuario::findOrFail($id);

        // Si ya tiene 2FA, redirigir
        if ($usuario->google2fa_secret) {
            return redirect()->route('usuarios.index')->with('info', 'El usuario ya tiene 2FA activado.');
        }

        $google2fa = app('pragmarx.google2fa');
        $secret = $google2fa->generateSecretKey();

        $usuario->google2fa_secret = $secret;
        $usuario->save();

        return view('auth.2fa.qr', [
            'secret' => $secret,
            'QR_Image' => $google2fa->getQRCodeInline(
                'Sistema Contable Cayetano',
                $usuario->email,
                $secret
            )
        ]);
    }

    public function desactivarDesdeAdmin($id)
    {
        $usuario = \App\Models\Usuario::findOrFail($id);

        if (!$usuario->google2fa_secret) {
            return redirect()->route('usuarios.index')->with('info', 'El usuario ya tiene 2FA desactivado.');
        }

        $usuario->google2fa_secret = null;
        $usuario->save();

        return redirect()->route('usuarios.index')->with('success', '2FA desactivado correctamente.');
    }


}

