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
    mix.sass('video.scss', 'public/css/video.css');
    mix.sass('survey.scss', 'public/css/survey.css');
    mix.sass('mailing_list.scss', 'public/css/mailing_list.css');
    mix.sass('ads.scss', 'public/css/ads.css');
    mix.sass('demo.scss', 'public/css/demo.css');
    mix.sass('interaction-common.scss', 'public/css/interaction-common.css');
    mix.sass('like.scss', 'public/css/like.css');
    mix.sass('bannerLink.scss', 'public/css/bannerLink.css');

    //materialize import to public
    mix.copy(
        'node_modules/materialize-css/dist/css/materialize.min.css',
        'public/css/materialize.css'
    );
    mix.copy(
        'node_modules/materialize-css/dist/js/materialize.min.js',
        'public/js/materialize.js'
    );

    mix.copy(
        'node_modules/materialize-css/dist/fonts',
        'public/fonts'
    );
});