import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './app/Filament/**/*.php',
        './resources/views/filament/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                display: ['Outfit', 'Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                brand: {
                    50: '#eef8ff',
                    100: '#d8eeff',
                    200: '#b9e2ff',
                    300: '#89d1ff',
                    400: '#52b5ff',
                    500: '#2a91ff',
                    600: '#1a73f5',
                    700: '#1259d9',
                    800: '#154aaf',
                    900: '#17408a',
                    950: '#122954',
                },
                accent: {
                    purple: '#a855f7',
                    pink: '#ec4899',
                    cyan: '#22d3ee',
                    orange: '#f97316',
                    green: '#22c55e',
                },
                dark: {
                    400: '#94a3b8',
                    500: '#64748b',
                    600: '#475569',
                    700: '#334155',
                    800: '#1e293b',
                    900: '#0f172a',
                    950: '#020617',
                },
                // New refined color palette - less harsh, more depth
                primary: '#0a0a12', // Rich deep dark (less harsh than pure black)
                secondary: '#0f0f1a', // Elevated surface
                tertiary: '#151522', // Card background
                surface: '#1a1a2e', // Lighter cards/panels
                muted: '#252538', // Subtle backgrounds
                border: 'rgba(255, 255, 255, 0.08)', // Consistent border color
            },
            backgroundImage: {
                'hero-gradient': 'linear-gradient(to bottom, #050511, #020617)',
                'glow': 'conic-gradient(from 180deg at 50% 50%, #2a8af6 0deg, #a853ba 180deg, #e92a67 360deg)',
            },
            animation: {
                'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                'float': 'float 6s ease-in-out infinite',
                'spin-slow': 'spin 20s linear infinite',
            },
            keyframes: {
                float: {
                    '0%, 100%': { transform: 'translateY(0)' },
                    '50%': { transform: 'translateY(-10px)' },
                }
            }
        },
    },

    plugins: [forms, typography],
};
