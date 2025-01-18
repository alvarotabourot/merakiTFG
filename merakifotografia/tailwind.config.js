import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            boxShadow: {
                'sides': '-4px 0px 10px rgba(215, 189, 226, 0.94), 4px 0px 10px rgba(195, 155, 211, 0.94)',
                'sides2': '-4px 0px 10px rgba(155, 89, 182, 0.94), 4px 0px 10px rgba(136, 78, 160, 0.94)',
            },
            colors: {
                amethyst: {
                    1: '#F5EEF8', 
                    2: '#EBDEF0',
                    3: '#D7BDE2',
                    4: '#C39BD3',
                    5: '#AF7AC5',
                    6: '#9B59B6',
                    7: '#884EA0',
                    8: '#76448A'
                },
            },
        },   plugins: [forms],
    },
};
