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

    Artisan::call('config:clear');

    Artisan::call('config:cache');

    return 'CACHE DEL SISTEMA LIMPIADA CON EXITO';

});

Route::get('/db-update',  'CGlobalsController@update_database');

Route::get('tareas', function () {

    $users = \App\Models\Users\User::all();
    foreach ($users as $user) {
        $data = \App\Models\Calendar::query()->where('user_id', $user->id)
            ->whereDate('start', \Carbon\Carbon::now())->get();
        if (count($data) > 0) {
            $data_email = [
                'user' => $user,
                'events' =>  $data,
                'company' => \App\Models\Company::query()->find(1),
            ];
            \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\AlertCalendarDaily($data_email));
        }
    }
    foreach ($users as $user) {
        $data = \App\Models\Calendar::query()->where('for_user_id', $user->id)
            ->whereDate('start', \Carbon\Carbon::now())->get();
        if (count($data) > 0) {
            $data_email = [
                'user' => $user,
                'events' =>  $data,
                'company' => \App\Models\Company::query()->find(1),
            ];
            \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\AlertCalendarDaily($data_email));
        }
    }
    return 'OK';
});

Route::get('/pruebas', function () {
    return  \App\Models\Users\User::query()->where('position_id', 1)->get();
});


//  Route::get('/', 'HomeController@stop')->name('stop');

Route::get('/infophp', function () {
    phpinfo();
});

Route::get('/at_time', function () {
    return view('layouts.at_time');
})->name('at_time');

Route::middleware(['auth', 'LoginMoment'])->group(function () {

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
        Route::get('/atencion/{status?}/{id?}', 'CGlobalsController@index')->name('cags');

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

        // REPORTES
        Route::get('/informes-cotizaciones', 'ReportsController@quotesIndex')->name('reports.quotes');

});


