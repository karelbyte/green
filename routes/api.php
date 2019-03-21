<?php

use Illuminate\Http\Request;

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



// RUTAS DE SERVICIOS
Route::prefix('services')->group(function () {

    Route::post('list', 'ServicesController@getList');

});

Route::resource('/services', 'ServicesController');

// RUTAS DE PRODUCTOS
Route::prefix('products')->group(function () {

    Route::post('list', 'ProductsController@getList');

});
Route::resource('/products', 'ProductsController');


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
});
Route::resource('/users', 'UsersController');


// RUTAS DE UNIDADES DE MEDIDA
Route::prefix('measures')->group(function () {

    Route::post('list', 'MeasuresController@getList');
});
Route::resource('/measures', 'MeasuresController');


// RUTAS DE MATERIALES
Route::prefix('materials')->group(function () {

    Route::post('list', 'MaterialsController@getList');

    Route::get('get', 'MaterialsController@getMaterials');
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
});
Route::resource('/receptions', 'ReceptionsController');


// RUTAS DE INVENTARIOS
Route::prefix('inventoris')->group(function () {

    Route::post('list', 'InventorisController@getList');

});
Route::resource('/inventoris', 'InventorisController');



