const config = require('./webpack.config');
const mix = require('laravel-mix');
require('laravel-mix-eslint');

// mix.webpackConfig(config);


mix
    .js('resources/js/app.js', 'public/dist/js')
    .extract([
        'vue',
        'axios',
        // 'jquery',
        // 'lodash'
    ])
    .options({
        processCssUrls: false,
        postCss: [
            require('autoprefixer'),
        ],
    })
    .sass('resources/css/app.scss','public/dist/css', {
        implementation: require('node-sass'),
    })
;


if (mix.inProduction()) {
    // mix.version();
} else {
    if (process.env.LAMINAS_USE_ESLINT === 'true') {
        // mix.eslint();
    }
    // Development settings
    mix
        .sourceMaps()
        .webpackConfig({
            devtool: 'cheap-eval-source-map', // Fastest for development
        });
}