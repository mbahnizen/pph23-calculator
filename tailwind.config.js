/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './views/**/*.php',
        './public/**/*.php',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', 'sans-serif'],
                display: ['Outfit', 'sans-serif'],
            },
            colors: {
                brand: {
                    primary: '#8b5cf6',
                    secondary: '#ec4899',
                    emerald: '#10b981',
                    dark: '#0f172a',
                },
            },
        },
    },
    plugins: [],
};
