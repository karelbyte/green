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
