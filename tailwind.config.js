/** @type {import('tailwindcss').Config} */
module.exports = {
    content: ["./resources/**/*.blade.php"],
    theme: {
        extend: {
            //background image
            backgroundImage: (theme) => ({
                "business-pattern": "url('/images/biznis_showcase.png')",
                "authentication": "url('/images/utility/login_back.png')",
            }),
        },
    },
    plugins: [require("@tailwindcss/line-clamp")],
};
