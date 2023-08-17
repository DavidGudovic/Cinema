/** @type {import('tailwindcss').Config} */
module.exports = {
    content: ["./resources/**/*.blade.php"],
    theme: {
        extend: {
            //background image
            backgroundImage: (theme) => ({
                "business-pattern": "url('/images/utility/biznis_showcase.webp')",
                "authentication": "url('/images/utility/login_back.webp')",
                'user-profile': "url('/images/utility/user_profile.webp')",
                'error': "url('/images/errors/error_md.png')",
                'error-phone': "url('/images/errors/error_sm.png')",
            }),
            keyframes: {
                slideInFromLeft: {
                    '0% '  :{transform: 'translateX(-100%) '},
                    '100% ':{transform: 'translateX(0)' },
                },
                slideInFromTop: {
                    '0% '  :{transform: 'translateY(-100%) '},
                    '100% ':{transform: 'translateY(0)' },
                },
            },
            animation: {
                'apear-from-left': 'slideInFromLeft 1.5s',
                'apear-from-top': 'slideInFromTop 1.5s',
            },
        },
    },
};
