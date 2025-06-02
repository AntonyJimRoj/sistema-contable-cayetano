const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                cayetano: {
                    dark: '#2E0C73',      // Morado oscuro
                    blue: '#1E429F',      // Azul intermedio
                    light: '#0891FF',     // Celeste brillante
                    text: '#1E293B',      // Texto oscuro
                    blanco: '#FFFFFF',    // Blanco
                },
            },
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
