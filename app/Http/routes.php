<?php

/*
|--------------------------------------------------------------------------
| Reflex Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@index');

//Auth Controller
Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

//Api Controller
Route::group(array('prefix' => 'api'), function(){
    Route::resource('countries', 'Backend\CountryController');
    Route::resource('companies', 'Backend\CompanyController');
    Route::resource('business_units', 'Backend\BusinessUnitController');
    Route::resource('sub_business_units', 'Backend\SubBusinessUnitController');
    Route::resource('zones', 'Backend\ZoneController');
    Route::resource('users', 'Backend\UserController');
    Route::resource('regions', 'Backend\RegionController');
    Route::resource('locations', 'Backend\LocationController');
    Route::resource('targets', 'Backend\TargetController');
    Route::resource('clients', 'Backend\ClientController');
    Route::resource('notes', 'Backend\NoteController');
    Route::resource('schedules', 'Frontend\ScheduleController');
    Route::resource('routes', 'Frontend\RouteController');
    Route::resource('visits', 'Frontend\VisitController');
    Route::resource('categories', 'Backend\CategoryController');
    Route::resource('places', 'Backend\PlaceController');
    Route::resource('campaigns', 'Backend\CampaignController');
    Route::resource('assignments', 'Backend\AssignmentController');
    Route::resource('reasons', 'Backend\ReasonController');
    Route::resource('visit_statuses', 'Backend\VisitStatusController');
    Route::resource('visit_types', 'Backend\VisitTypeController');
    Route::resource('specialties', 'Backend\SpecialtyController');

    Route::get('social/{company_id}', 'Frontend\VisitController@social');

    Route::get('image/client/{cmp}', 'WelcomeController@image_client');
    Route::get('rutas/calendar', array('uses' => 'Frontend\RouteController@calendar'));
    Route::get('rutas/data', array('uses' => 'Frontend\RouteController@data'));

    Route::post('users/upload/{id}', array('uses' => 'Backend\UserController@upload'));
});

//Backend Controller
Route::group(array('prefix' => 'backend', 'middleware' => 'auth.basic'), function() {

    Route::get('home', 'Backend\HomeController@index');
    Route::get('perfil', 'Backend\HomeController@profile');
    Route::get('sub_unidades', 'Backend\HomeController@sub_business_unit');
    Route::get('category_report', 'Backend\HomeController@category_report');
    Route::get('place_report', 'Backend\HomeController@place_report');
    Route::get('client_type_report', 'Backend\HomeController@client_type_report');
    Route::get('client_specialty', 'Backend\HomeController@client_specialty');

    Route::controller('paises', 'Backend\CountryController');
    Route::controller('empresas', 'Backend\CompanyController');
    Route::controller('unidad_de_negocios', 'Backend\BusinessUnitController');
    Route::controller('sub_unidad_de_negocios', 'Backend\SubBusinessUnitController');
    Route::controller('zonas', 'Backend\ZoneController');
    Route::controller('clientes', 'Backend\ClientController');
    Route::controller('ciclos', 'Backend\CampaignController');
    Route::controller('usuarios', 'Backend\UserController');
    Route::controller('targets', 'Backend\TargetController');
    Route::controller('farmacias', 'Backend\PharmacyController');
    Route::controller('instituciones', 'Backend\InstitutionController');
    Route::controller('categorias', 'Backend\CategoryController');
    Route::controller('tareas', 'Backend\PlaceController');
    Route::controller('asignaciones', 'Backend\AssignmentController');
});

//Frontend Controller
Route::group(array('prefix' => 'frontend', 'middleware' => 'auth.basic'), function () {  //

    Route::get('home', 'Frontend\HomeController@index');

    Route::get('target'      ,array('uses' => 'Frontend\TargetController@main'));
    Route::get('visitas'     ,array('uses' => 'Frontend\VisitController@main'));
    Route::get('visitar'     ,array('uses' => 'Frontend\VisitController@visit_new'));
    Route::get('ausencia'    ,array('uses' => 'Frontend\VisitController@absence_new'));
    Route::get('visita/{id}' ,array('uses' => 'Frontend\VisitController@visit_preview'));
    Route::get('rutas'       ,array('uses' => 'Frontend\RouteController@main'));
    Route::get('reportes'    ,array('uses' => 'Frontend\ReportController@main'));
    Route::get('notas'       ,array('uses' => 'Frontend\NoteController@main'));
    Route::get('mapa'        ,array('uses' => 'Frontend\HomeController@map'));

    Route::get('target/{id}'           , array('uses' => 'Frontend\TargetController@preview'));
    Route::get('schedule/calendar/{id}', array('uses' => 'Frontend\ScheduleController@calendar'));
    Route::get('rutas/calendar'        , array('uses' => 'Frontend\RouteController@calendar'));
    Route::get('rutas/exportar'        , array('uses' => 'Frontend\RouteController@export'));
    Route::get('visitas/exportar'      , array('uses' => 'Frontend\VisitController@export'));
    Route::get('ausencias/exportar'    , array('uses' => 'Frontend\VisitController@absence_export'));
    Route::get('cobertura/exportar'    , array('uses' => 'Frontend\HomeController@coverage_export'));
    Route::get('targets/exportar/{zone_id}/{campaign_id}/{user_id}'      , array('uses' => 'Frontend\TargetController@target_export'));

    Route::get('visit_status'      , 'Frontend\HomeController@visit_status');
    Route::get('category_report'   , 'Frontend\HomeController@category_report');
    Route::get('place_report'      , 'Frontend\HomeController@place_report');
    Route::get('client_type_report', 'Frontend\HomeController@client_type_report');
    Route::get('client_specialty'  , 'Frontend\HomeController@client_specialty');
    Route::get('image/client/{cmp}'  , 'Frontend\HomeController@image_client');

    Route::controller('usuarios', 'Frontend\UserController');

});

//Process Controller
Route::group(array('prefix' => 'process', 'middleware' => 'auth.basic'), function () {
    Route::get('inicio_de_ciclo/{company_id}', array('uses' => 'ProcessController@open_cycle'));
});
