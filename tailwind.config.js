/** @type {import('tailwindcss').Config} */
module.exports = {
    content: ["./resources/**/*.blade.php"],
    theme: {
        extend: {
            //background image
            backgroundImage: (theme) => ({
                "business-pattern": "url('/images/biznis_showcase.png')",
            }),
        },
    },
    plugins: [],
};
