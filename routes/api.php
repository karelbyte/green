<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::get('/notifications/today', 'NotificationsController@today');

// RUTAS DEL CICLO DE ATENCION GLOBAL
Route::prefix('cags')->group(function () {

    Route::post('list', 'CGlobalsController@getList');

    Route::get('/get/id', 'CGlobalsController@sendID');

});
Route::resource('/cags', 'CGlobalsController');


// RUTAS DEL CALENDARIO
Route::prefix('calendars')->group(function () {

    Route::post('list', 'CalendarsController@getList');

    Route::get('/get/id', 'CalendarsController@sendID');

});
Route::resource('/calendars', 'CalendarsController');



// RUTAS NOTAS DE VENTA
Route::prefix('sales')->group(function () {

    Route::post('list', 'SalesNoteController@getList');

    Route::get('/aplic/{id}', 'SalesNoteController@NoteAplic');

    Route::post('/confirm', 'SalesNoteController@NoteConfirm');

    // DETALLES

    Route::post('/details', 'SalesNoteController@SaveDetails');

    Route::get('pdf/{id}', 'SalesNoteController@pdf');

});
Route::resource('/sales', 'SalesNoteController');


// RUTAS COTIZACIONES
Route::prefix('quotes')->group(function () {

    Route::post('list', 'QuotesController@getList');

    Route::get('/get/id', 'QuotesController@sendID');

    Route::post('/sendinfo', 'QuotesController@sendInfo');

    Route::post('/checkinfo', 'QuotesController@checkInfo');

    Route::post('/saveinfo', 'QuotesController@saveInfo');

    // DETALLES

    Route::post('/details', 'QuotesController@SaveDetails');

    Route::get('pdf/{id}', 'QuotesController@pdf');

    // NOTAS

    Route::post('/note/save', 'QuotesController@SaveNote');

    Route::get('/note/delete/{id}', 'QuotesController@deleteQuoteNote');

    Route::get('/notes/{id}', 'QuotesController@getQuoteNotes');

    // FICHEROS

    Route::post('/file/save', 'QuotesController@SaveFile');

    Route::get('/file/delete/{id}', 'QuotesController@deleteQuoteFile');

    Route::get('/files/{id}', 'QuotesController@getQuoteFiles');

});
Route::resource('/quotes', 'QuotesController');



// RUTAS DEL MANTENIMIENTOS
Route::prefix('maintenances')->group(function () {

    Route::post('list', 'MaintenancesController@getList');

    Route::get('/get/id', 'MaintenancesController@sendID');

});
Route::resource('/maintenances', 'MaintenancesController');



// RUTAS DE AJUSTE DE DATOS DE LA EMPRESA
Route::get('/ajustes/company/data', 'CompanyController@getdata');
Route::resource('/ajustes/company', 'CompanyController');


// RUTAS DE SERVICIOS
Route::prefix('servicesoffereds')->group(function () {

    Route::post('list', 'ServicesOfferedsController@getList');

    Route::get('services', 'ServicesOfferedsController@getServices');

});
Route::resource('/servicesoffereds', 'ServicesOfferedsController');


// RUTAS DE PRODUCTOS
Route::prefix('productsoffereds')->group(function () {

    Route::post('list', 'ProductsOfferedsController@getList');

    Route::get('products', 'ProductsOfferedsController@getProduct');

});
Route::resource('/productsoffereds', 'ProductsOfferedsController');


// RUTAS DE ROLES SISTEMA
Route::prefix('roles')->group(function () {

    Route::get('/permission/{id}', 'RolsController@getPermission');

    Route::post('list', 'RolsController@getList');

    Route::get('get', 'RolsController@getRoles');

});
Route::resource('/roles', 'RolsController');


// RUTAS DE USUER SISTEMA
Route::prefix('users')->group(function () {

    Route::post('list', 'UsersController@getList');

    Route::get('positions', 'UsersController@getUserPositions');
});
Route::resource('/users', 'UsersController');


// RUTAS DE UNIDADES DE MEDIDA
Route::prefix('measures')->group(function () {

    Route::post('list', 'MeasuresController@getList');
});
Route::resource('/measures', 'MeasuresController');


// RUTAS DE PRODUCTOS Y HERRAMIENTAS
Route::prefix('materials')->group(function () {

    Route::post('list', 'MaterialsController@getList');

    Route::get('get', 'MaterialsController@getMaterials');

    Route::get('products', 'MaterialsController@getProducts');
});
Route::resource('/materials', 'MaterialsController');


// RUTAS DE HERRAMIENTAS
Route::prefix('tools')->group(function () {

    Route::post('list', 'ToolsController@getList');

    Route::get('get', 'ToolsController@getTools');
});
Route::resource('/tools', 'ToolsController');


// RUTAS DE RECEPCIONES
Route::prefix('receptions')->group(function () {

    Route::post('list', 'ReceptionsController@getList');

    Route::post('aplic', 'ReceptionsController@aplic');

    Route::get('pdf/{id}', 'ReceptionsController@pdf');
});
Route::resource('/receptions', 'ReceptionsController');


// RUTAS DE INVENTARIOS
Route::prefix('inventoris')->group(function () {

    Route::post('list', 'InventorisController@getList');

    Route::get('products', 'InventorisController@getProducts');

    Route::get('pdf/{type}', 'InventorisController@pdf');

});
Route::resource('/inventoris', 'InventorisController');


// RUTAS DE PROVEEDORES
Route::prefix('providers')->group(function () {

    Route::post('list', 'ProvidersController@getList');

});
Route::resource('/providers', 'ProvidersController');



// RUTAS DE CLIENTES
Route::prefix('clients')->group(function () {

    Route::post('list', 'ClientsController@getList');

    Route::get('/get/id', 'ClientsController@sendID');

});
Route::resource('/clients', 'ClientsController');

