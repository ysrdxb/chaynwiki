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
                // Ocean Depth Theme - Premium Music Encyclopedia
                brand: {
                    50: '#f0f9ff',
                    100: '#e0f2fe',
                    200: '#bae6fd',
                    300: '#7dd3fc',
                    400: '#38bdf8',
                    500: '#0ea5e9',
                    600: '#0284c7',
                    700: '#0369a1',
                    800: '#075985',
                    900: '#0c4a6e',
                    950: '#082f49',
                },
                accent: {
                    primary: '#38bdf8',    // Ocean blue
                    secondary: '#2dd4bf',  // Seafoam teal
                    tertiary: '#f472b6',   // Coral pink
                    purple: '#a78bfa',     // Soft purple
                    orange: '#fb923c',     // Warm orange
                    green: '#22c55e',      // Fresh green
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
                // Core background palette
                primary: '#0a0e14',    // Deep ocean - main bg
                secondary: '#0f1419',  // Dark teal - sections
                tertiary: '#151c24',   // Night blue - cards
                surface: '#1c2630',    // Slate - elevated
                elevated: '#232d3a',   // Lighter panels
                muted: '#2a3544',      // Subtle backgrounds
            },
            backgroundImage: {
                'hero-gradient': 'linear-gradient(to bottom, #0a0e14, #0f1419)',
                'glow': 'conic-gradient(from 180deg at 50% 50%, #38bdf8 0deg, #a78bfa 180deg, #f472b6 360deg)',
                'card-gradient': 'linear-gradient(145deg, rgba(21,28,36,0.9) 0%, rgba(28,38,48,0.8) 100%)',
                'accent-gradient': 'linear-gradient(135deg, #38bdf8 0%, #2dd4bf 100%)',
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
