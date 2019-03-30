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

Route::get('/pruebas', function () {

     return view('pruebas');
});



Route::middleware('auth')->group(function () {

    Route::get('/', 'HomeController@index')->name('inicio');

    Route::get('/panel', 'HomeController@index')->name('panel');

    Route::get('/ajustes/empresa', 'CompanyController@index')->name('company');

    Route::get('/roles', 'RolsController@index')->name('roles');

    // PROVEEDORES
    Route::get('/clientes/listado', 'ClientsController@index')->name('clients');
    Route::get('/clientes/nuevo', 'ClientsController@newview')->name('clients.new');

    // PROVEEDORES
    Route::get('/proveedores/listado', 'ProvidersController@index')->name('providers');
    Route::get('/proveedores/nuevo', 'ProvidersController@newview')->name('providers.new');

    // USUARIOS
    Route::get('/usuarios/listado', 'UsersController@index')->name('users');
    Route::get('/usuarios/nuevo', 'UsersController@newview')->name('users.new');

    // MEDIDAS
    Route::get('/measures', 'MeasuresController@index')->name('measures');

    // MATERIALES
    Route::get('/materiales', 'MaterialsController@index')->name('materials');

    // MATERIALES
    Route::get('/herramientas', 'ToolsController@index')->name('tools');

    // RECEPCIONES
    Route::get('/recepciones', 'ReceptionsController@index')->name('receptions');

    // INVENTARIOS
    Route::get('/inventarios', 'InventorisController@index')->name('inventoris');

    // PRODUCTOS
    Route::get('/productos', 'ProductsController@index')->name('products');

    // SERVICIOS
    Route::get('/servicios', 'ServicesController@index')->name('services');


    // CICLO DE ATENCION GLOBAL
    Route::get('/atencion', 'CGlobalsController@index')->name('cags');


    // CALENDARIO
    Route::get('/calendario', 'CalendarsController@index')->name('calendars');


});


