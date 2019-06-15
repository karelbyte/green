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

Route::get('tareas', function () {

    $quote_confirm = \App\Models\Quotes\Quote::with(['globals' => function($q) {
        $q->with('client');
    }])->leftJoin('cglobals', 'cglobals.id',   'quotes.cglobal_id')
        ->whereRaw('DATEDIFF(now(), quotes.check_date ) > 1')
        ->where('quotes.status_id', 3)->get();
    return  $quote_confirm ;
});

Route::get('/pruebas', function () {

    $pdf = \App::make('snappy.pdf.wrapper');

    $datos = \App\Models\CGlobal\CGlobal::query()->with(['MotiveServices', 'MotiveProducts', 'documents', 'compromise','contact',
        'attended', 'client', 'status', 'info' => function($q) {
            $q->with('info', 'info_det');
        }, 'landscaper' => function ($l) {
            $l->with('user');
        }])->where('id', 1)->first();

    $sale =  \App\Models\SalesNotes\SalesNote::with([ 'status', 'details' => function($d) {
        $d->with('measure');
    }])->where('global_id', 1)->first();

    $data = [

        'data' =>  $datos,

        'sale' => $sale

    ];

    $footer = \View::make('pdf.footer', ['company' => \App\Models\Company::query()->find(1)])->render();

    $header = \View::make('pdf.header', ['company' => \App\Models\Company::query()->find(1)])->render();

    $html = \View::make('pages.cags.pdf', $data)->render();

    $pdf->loadHTML($html)->setOption('header-html', $header)->setOption('footer-html', $footer);

    $pdfBase64 = base64_encode($pdf->inline());

    return $pdf->inline();
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

    // REPORTES
    Route::get('/informes-cotizaciones', 'ReportsController@quotesIndex')->name('reports.quotes');

});


