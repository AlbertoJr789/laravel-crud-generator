import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/views/**/*.vue',
        './resources/css/**',
        "./node_modules/flowbite/**/*.js"
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: '#E7E6E6',
                secondary: '#0A0909',
                danger: '#ff3700'
            },
            animation: {
                'dt-table1': 'datatables-loader-1 .6s infinite',
                'dt-table2': 'datatables-loader-2 .6s infinite',
                'dt-table3': 'datatables-loader-3 .6s infinite',
            },
            keyframes: {
                'datatables-loader-1': {
                    '0%': { transform: 'scale(0)' },
                    '100%': { transform: 'scale(1)' }
                },
                'datatables-loader-2': {
                    '0%': { transform: 'translate(0,0)' },
                    '100%': { transform: 'translate(24px,0)' }
                },
                'datatables-loader-3': {
                    '0%': { transform: 'scale(1)' },
                    '100%': { transform: 'scale(0)' }
                },
            }
        },
    },

    plugins: [forms, typography, require('flowbite/plugin')],
};

