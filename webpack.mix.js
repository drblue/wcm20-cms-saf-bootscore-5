/**
 * Laravel Mix configuration file
 */

const mix = require('laravel-mix');

mix.js('src/js/theme.js', 'js/');
mix.sass('src/sass/theme.scss', 'css/');
