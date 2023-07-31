/** @type {import('tailwindcss').Config} */
module.exports = {
    content: ["./resources/**/*.blade.php"],
    theme: {
        extend: {
            //background image
            backgroundImage: (theme) => ({
                "business-pattern": "url('/images/utility/biznis_showcase.png')",
                "authentication": "url('/images/utility/login_back.png')",
                'user-profile': "url('/images/utility/user_profile.png')",
            }),
        },
    },
    plugins: [require("@tailwindcss/line-clamp")],
};
