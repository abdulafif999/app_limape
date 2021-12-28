const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    important: true,
    mode: 'jit',
    darkmode: 'class',
    i18n: {
        locales: ["en-US"],
        defaultLocale: "en-US",
    },
    purge: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
                backgroundImage: (theme) => ({
                    check: "url('/icons/check.svg')",
                    landscape: "url('/images/landscape/2.jpg')",
                }),                
            },
        },
    },
    variants: {
        extend: {
          backgroundColor: ["checked"],
          borderColor: ["checked"],
          inset: ["checked"],
          zIndex: ["hover", "active"],
        },
    },    

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
    future: {
        purgeLayersByDefault: true,
    },
};
