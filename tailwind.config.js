import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Plus Jakarta Sans', ...defaultTheme.fontFamily.sans],
                display: ['Plus Jakarta Sans', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                brand: {
                    50:  '#eef2ff',
                    100: '#e0e7ff',
                    200: '#c7d2fe',
                    300: '#a5b4fc',
                    400: '#818cf8',
                    500: '#6366f1',
                    600: '#4f46e5',
                    700: '#4338ca',
                    800: '#3730a3',
                    900: '#312e81',
                    950: '#1e1b4b',
                },
                accent: {
                    400: '#38bdf8',
                    500: '#0ea5e9',
                    600: '#0284c7',
                },
                surface: {
                    50:  '#f8fafc',
                    100: '#f1f5f9',
                    200: '#e2e8f0',
                    300: '#cbd5e1',
                },
            },
            borderRadius: {
                '2xl':  '1rem',       /* 16px */
                '3xl':  '1.5rem',     /* 24px */
                '4xl':  '2rem',       /* 32px */
                '5xl':  '2.5rem',     /* 40px */
            },
            spacing: {
                '4.5': '1.125rem',    /* 18px – between 4 and 5 */
                '13':  '3.25rem',
                '18':  '4.5rem',
            },
            boxShadow: {
                'card':   '0 2px 16px -4px rgba(15,23,42,0.06), 0 1px 4px -2px rgba(15,23,42,0.04)',
                'card-hover': '0 20px 40px -12px rgba(15,23,42,0.10), 0 4px 12px -4px rgba(15,23,42,0.06)',
                'panel':  '0 12px 40px -12px rgba(15,23,42,0.07)',
                'nav':    '0 1px 0 0 rgba(15,23,42,0.06)',
                'btn':    '0 4px 14px -2px rgba(79,70,229,0.28)',
                'btn-hover': '0 8px 20px -4px rgba(79,70,229,0.38)',
                'modal':  '0 24px 80px -16px rgba(15,23,42,0.30)',
                'input-focus': '0 0 0 4px rgba(79,70,229,0.10)',
            },
            backgroundImage: {
                'brand-gradient':   'linear-gradient(135deg, #4f46e5 0%, #0ea5e9 100%)',
                'brand-gradient-r': 'linear-gradient(to right, #4f46e5, #0ea5e9)',
                'page-bg':          'radial-gradient(circle at 0% 0%, rgba(99,102,241,0.05) 0%, transparent 50%), radial-gradient(circle at 100% 0%, rgba(14,165,233,0.05) 0%, transparent 50%), linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%)',
                'merchant-gradient':'linear-gradient(135deg, #7c3aed 0%, #4f46e5 100%)',
                'admin-gradient':   'linear-gradient(135deg, #e11d48 0%, #dc2626 100%)',
            },
            transitionTimingFunction: {
                'spring': 'cubic-bezier(0.16, 1, 0.3, 1)',
            },
            transitionDuration: {
                '250': '250ms',
                '350': '350ms',
            },
            keyframes: {
                shimmer: {
                    '0%':   { backgroundPosition: '-200% 0' },
                    '100%': { backgroundPosition: '200% 0' },
                },
                fadeIn: {
                    '0%':   { opacity: '0', transform: 'translateY(8px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                scaleIn: {
                    '0%':   { opacity: '0', transform: 'scale(0.95)' },
                    '100%': { opacity: '1', transform: 'scale(1)' },
                },
                slideDown: {
                    '0%':   { opacity: '0', transform: 'translateY(-8px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
            },
            animation: {
                shimmer:    'shimmer 1.5s infinite linear',
                'fade-in':  'fadeIn 0.35s cubic-bezier(0.16, 1, 0.3, 1) forwards',
                'scale-in': 'scaleIn 0.25s cubic-bezier(0.16, 1, 0.3, 1) forwards',
                'slide-down': 'slideDown 0.25s cubic-bezier(0.16, 1, 0.3, 1) forwards',
            },
        },
    },
    plugins: [],
};
