/** @type {import('tailwindcss').Config} */
export default {
    content: ["./resources/**/*.blade.php"],
    theme: {
        extend: {
            colors: {
                Primary: "#006B60",
                Secondary: "#649B92",
                SecondaryH:"#527c75",
                PrimaryD: "#014942",
                Third: "#C3FCF2",
                Danger: "#FF0001",
            },
        },
        plugins: [],
    },
}
