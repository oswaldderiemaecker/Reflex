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


Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::get('/inicio_de_ciclo', function(){

    Queue::push(new \Reflex\Commands\OpenCycle('open'));
    return Redirect::to('/backend/home');
});

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
});


Route::group(array('prefix' => 'backend'), function() {

    Route::get('home', 'Backend\HomeController@index');
    Route::get('perfil', 'Backend\HomeController@profile');
    Route::get('sub_unidades', 'Backend\HomeController@sub_business_unit');
    Route::get('category_report', 'Backend\HomeController@category_report');
    Route::get('place_report', 'Backend\HomeController@place_report');
    Route::get('client_type_report', 'Backend\HomeController@client_type_report');
    Route::get('client_specialty', 'Backend\HomeController@client_specialty');

    Route::controller('paises', '\Reflex\Http\Controllers\Backend\CountryController');
    Route::controller('empresas', '\Reflex\Http\Controllers\Backend\CompanyController');
    Route::controller('unidad_de_negocios', '\Reflex\Http\Controllers\Backend\BusinessUnitController');
    Route::controller('sub_unidad_de_negocios', '\Reflex\Http\Controllers\Backend\SubBusinessUnitController');
    Route::controller('zonas', '\Reflex\Http\Controllers\Backend\ZoneController');
    Route::controller('clientes', '\Reflex\Http\Controllers\Backend\ClientController');
    Route::controller('ciclos', '\Reflex\Http\Controllers\Backend\CampaignController');
    Route::controller('usuarios', '\Reflex\Http\Controllers\Backend\UserController');
    Route::controller('targets', '\Reflex\Http\Controllers\Backend\TargetController');
    Route::controller('farmacias', '\Reflex\Http\Controllers\Backend\PharmacyController');
    Route::controller('instituciones', '\Reflex\Http\Controllers\Backend\InstitutionController');


});


Route::group(array('prefix' => 'frontend'), function() {

    Route::get('home', 'Frontend\HomeController@index');

    Route::get('target'  ,array('uses' => 'Frontend\TargetController@main'));
    Route::get('visitas' ,array('uses' => 'Frontend\VisitController@main'));
    Route::get('rutas'   ,array('uses' => 'Frontend\RouteController@main'));
    Route::get('reportes',array('uses' => 'Frontend\ReportController@main'));
    Route::get('notas'   ,array('uses' => 'Frontend\NoteController@main'));

    Route::get('target/{id}',array('uses' => 'Frontend\TargetController@preview'));
    Route::get('schedule/calendar/{id}',array('uses' => 'Frontend\ScheduleController@calendar'));
    Route::get('rutas/calendar/{zone_id}/{cycle_id}',array('uses' => 'Frontend\RouteController@calendar'));
    Route::get('rutas/exportar/{zone_id}/{cycle_id}',array('uses' => 'Frontend\RouteController@export'));

});
