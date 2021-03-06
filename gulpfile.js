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

elixir(function(mix) {
    mix.less(['app.less','switch-material-design.less'],
        'public/build/css');
});

elixir(function(mix) {
    mix.scripts(['app.js'],
        'public/build/js/all.js');
    mix.scripts(['storage.js'],
        'public/build/js/storage.js');
    mix.scripts(['users.js'],
        'public/build/js/users.js');
});