const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js', [
        require('chart.js'),
    ])
    .postCss('resources/css/app.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss'),
        require('autoprefixer'),
    ]);

if (mix.inProduction()) {
    mix.version();
}
