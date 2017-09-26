/**
 * Created by JohnNate on 9/26/17.
 */
var elixir = require('laravel-elixir');

elixir(function(mix) {
    mix.sass('styleadmin.scss');
    mix.sass('style404.scss');
    mix.sass('style.scss');
    mix.sass('userstyle.scss');

    mix.scripts([
        'main.js'
    ]);
});