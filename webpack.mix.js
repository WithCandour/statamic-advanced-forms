const mix = require('laravel-mix');

mix.js('resources/js/advanced-forms.js', 'public/js').vue({ version: 2 });
mix.less('resources/less/advanced-forms.less', 'public/css');
