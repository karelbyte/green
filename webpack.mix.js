const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js/app')
    .js('resources/js/core.js', 'public/js/app')
    .js('resources/js/users.js', 'public/js/app')
    .js('resources/js/users_new.js', 'public/js/app')
    .js('resources/js/roles.js', 'public/js/app')
    .js('resources/js/measures.js', 'public/js/app')
    .js('resources/js/materials.js', 'public/js/app')
    .js('resources/js/crmtools.js', 'public/js/app')
    .js('resources/js/receptions.js', 'public/js/app')
    .js('resources/js/inventoris.js', 'public/js/app')
    .js('resources/js/products_offereds.js', 'public/js/app')
    .js('resources/js/services_offereds.js', 'public/js/app')
    .js('resources/js/providers.js', 'public/js/app')
    .js('resources/js/providers_new.js', 'public/js/app')
    .js('resources/js/clients_new.js', 'public/js/app')
    .js('resources/js/clients.js', 'public/js/app')
    .js('resources/js/quotes.js', 'public/js/app')
    .js('resources/js/sales.js', 'public/js/app')
    .js('resources/js/cags.js', 'public/js/app')
    .js('resources/js/company.js', 'public/js/app')
    .js('resources/js/notifications.js', 'public/js/app')
    .js('resources/js/maintenances.js', 'public/js/app')
     .extract(['vue']);

mix.sass('resources/sass/app.scss', 'public/css');
