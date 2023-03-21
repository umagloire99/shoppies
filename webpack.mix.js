const mix = require('laravel-mix');
const path = require("path")

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

mix.js('resources/js/app.js', 'public/js')
    .vue()
    .sass("resources/assets/scss/app.scss", "public/css")
    .autoload({
        "cash-dom": ["cash"]
    })
    .webpackConfig({
        resolve: {
            alias: {
                "@": path.resolve('resources/js'),
                "~": path.resolve('resources/js'),
                "@components": path.resolve('resources/app'),
            },
            extensions: ["*", ".js", ".vue", ".json"],
        },
        output: {
            chunkFilename: 'js/[name].js?id=[chunkhash]',
        },
    })
    .browserSync({
        proxy: "shoppies.test",
        files: ["resources/**/*.*"]
    }).version();
