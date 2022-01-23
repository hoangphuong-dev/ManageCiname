const mix = require("laravel-mix");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix
    .disableNotifications()
    .js("resources/js/app.js", "public/js")
    .sourceMaps(process.env.APP_ENV == 'local', 'source-map')
    .vue({ version: 3 })
    .postCss("resources/css/app.css", "public/css", [
        require("postcss-import"),
        require("tailwindcss"),
    ])
    .webpackConfig(require("./webpack.config"));

mix.webpackConfig({
    module: {
        rules: [
            {
                test: /\.mjs$/,
                resolve: { fullySpecified: false },
                include: /node_modules/,
                type: "javascript/auto",
            },
        ],
    },
});

if (mix.inProduction()) {
    mix.version();
}
