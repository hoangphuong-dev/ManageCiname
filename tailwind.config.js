const defaultTheme = require("tailwindcss/defaultTheme");

module.exports = {
    mode: "jit",
    purge: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./vendor/laravel/jetstream/**/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.vue",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Nunito", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                bluePrimary: "#1fa8F5",
                redPrimary: "#ff0011",
                "blackPrimary-500": "#1f1f1f",
                "blackPrimary-400": "#3d3d3d",
                "blackPrimary-300": "#5b5b5b",
                "blackPrimary-200": "#979797",
                "blackPrimary-100": "#cccccc",
                greenPrimary: "#1cce4e",
                lightGreen: "#a5c242",
                yellowPrimary: "#fca442",
                grayPrimary: "#f5f5f5",
                grayBorder: "#d8d8d8",
            },
            borderRadius: {
                100: "100px",
            },
            height: {
                max: "max-content",
            },
            minWidth: {
                "1/2": "50%",
                132: "132px",
                124: "124px",
            },
            minHeight: {
                64: "64px",
            },
            lineHeight: {
                3.5: "14px",
            },
            width: {
                "9/10": "90%",
                "8/10": "80%",
                "7/10": "70%",
                "6/10": "60%",
                "5.5/10": "55%",
                "5/10": "50%",
                "4.5/10": "45%",
                "4/10": "40%",
                "3/10": "30%",
                "2/10": "20%",
                "1/10": "10%",
                "9.5/10": "95%",
            },

            display: ["group-hover"],
        },
    },

    plugins: [
        require("@tailwindcss/forms"),
        require("@tailwindcss/typography"),
    ],
};
