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
use Illuminate\Support\Facades\Route;
use \Illuminate\Support\Facades\Auth;

Route::get('pdf/{id}', 'CGlobalsController@pdf');

Auth::routes();

Route::get('/publicar', function () {

    Artisan::call('storage:link');

    return 'PUBLICACION DE ARCHIVOS EXITOSA';

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


     $data = [
         'client' =>    $data = \App\Models\Client::query()->find(2)->name,
         'company' => \App\Models\Company::query()->find(1)
     ];
     return view('pages.clients.mail_client', ['data' => $data]);
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

    // PRODUCTOS ALMACEN
    Route::get('/productos', 'MaterialsController@index')->name('products');

    // MATERIALES ALMACEN
    Route::get('/herramientas', 'ToolsController@index')->name('tools');

    // RECEPCIONES
    Route::get('/recepciones', 'ReceptionsController@index')->name('receptions');

    // INVENTARIOS
    Route::get('/inventarios', 'InventorisController@index')->name('inventoris');

    // PRODUCTOS
    Route::get('/catalogo-productos', 'ProductsOfferedsController@index')->name('productsoffereds');

    // SERVICIOS
    Route::get('/catalogo-servicios', 'ServicesOfferedsController@index')->name('servicesoffereds');

    // CICLO DE ATENCION GLOBAL
    Route::get('/atencion', 'CGlobalsController@index')->name('cags');

    // MANTENIMIENTOS
    Route::get('/mantenimientos', 'MaintenancesController@index')->name('maintenance');

    // COTIZACIONES
    Route::get('/cotizaciones/{id?}', 'QuotesController@index')->name('quotes');

    // NOTA DE VENTA
    Route::get('/notas-de-ventas/{id?}', 'SalesNoteController@index')->name('sales');

    // CALENDARIO
    Route::get('/notificasiones', 'NotificationsController@index')->name('notifications');

    // CALENDARIO
    Route::get('/calendario', 'CalendarsController@index')->name('calendars');

    // CALENDARIO
    Route::get('/info', 'CalendarsController@index')->name('info');

    // CALIDAD
    Route::get('/calidad/{id?}', 'QualityController@index')->name('quality');

});


