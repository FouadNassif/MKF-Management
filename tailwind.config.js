/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/views/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./resources/views/barber/*.blade.php",
    ],
    theme: {
        extend: {
            colors: {
                'Primary': '#006B60',
                'Secondary': "#649B92",
                'PrimaryD': '#014942',
            }
        },
    },
    plugins: [],
};
