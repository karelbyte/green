<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();


Route::get('/publicar', function () {

    Artisan::call('storage:link');

    return 'PUBLICACION DE DB EXITOSA';

});

Route::get('/migrar', function () {

    Artisan::call('migrate');

    return 'MIGRACION DE DB EXITOSA';

});

Route::get('/generar', function () {

    Artisan::call('db:seed --class=AppSeeder');

    return 'GENERACION DE DATOS EXITOSA';

});


Route::get('/limpiar_cache', function () {


    Artisan::call('view:clear');

    Artisan::call('route:clear');

    Artisan::call('cache:clear');

    Artisan::call('config:cache');

    return 'CACHE DEL SISTEMA LIMPIADA CON EXITO';

});

Route::middleware('auth')->group(function () {

    Route::get('/', 'HomeController@index')->name('inicio');

    Route::get('/panel', 'HomeController@index')->name('panel');

    Route::get('/roles', 'RolsController@index')->name('roles');


    // USUARIOS
    Route::get('/usuarios/listado', 'UsersController@index')->name('users');
    Route::get('/usuarios/nuevo', 'UsersController@newview')->name('users.new');

    // MARCAS
    Route::get('/brands', 'BrandsController@index')->name('brands');
    Route::get('/brands/new', 'BrandsController@newview')->name('brands.new');

    // MODELOS
    Route::get('/models', 'ModelsController@index')->name('models');
    Route::get('/models/new', 'ModelsController@newview')->name('models.new');

    // SUCURSALES
    Route::get('/divisions', 'DivisionsController@index')->name('divisions');
    Route::get('/models/new', 'DivisionsController@newview')->name('divisions.new');


    //Familias
    Route::get('/familys', 'FamilysController@index')->name('familys');
    Route::get('/familys/new', 'FamilysController@newview')->name('familys.new');

    //Diseños
    Route::get('/desings', 'DesingsController@index')->name('desings');
    Route::get('/desings/new', 'DesingsController@newview')->name('desings.new');


    //Pedidos
    Route::get('/orders', 'OrdersController@index')->name('orders');
    Route::get('/orders/new', 'OrdersController@newview')->name('orders.new');

    //Tablas
    Route::get('/tables', 'TablesController@index')->name('tables');
    Route::get('/tables/new', 'TablesController@newview')->name('tables.new');

});
