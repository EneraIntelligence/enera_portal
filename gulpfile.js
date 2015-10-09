process.env.DISABLE_NOTIFIER = true;
var elixir = require('laravel-elixir');
/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function (mix) {
    mix.sass('main.scss', 'public/css/main.css');
    mix.sass('app.scss', 'public/css/app.css');
    mix.sass('welcome.scss', 'public/css/welcome.css');
    mix.sass('captcha.scss', 'public/css/captcha.css');
    mix.sass('banner.scss', 'public/css/banner.css');
});
