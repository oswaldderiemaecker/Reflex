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

Route::get('home', 'HomeController@index');
Route::get('perfil', 'HomeController@profile');
Route::get('sub_unidades', 'HomeController@sub_business_unit');
Route::get('category_report', 'HomeController@category_report');
Route::get('place_report', 'HomeController@place_report');
Route::get('client_type_report', 'HomeController@client_type_report');
Route::get('client_specialty', 'HomeController@client_specialty');


Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::get('/inicio_de_ciclo', function(){

    Queue::push(new \Reflex\Commands\OpenCycle('open'));
    return Redirect::to('home');
});

Route::group(array('prefix' => 'api'), function(){
    Route::resource('countries', 'CountryController');
    Route::resource('companies', 'CompanyController');
    Route::resource('business_units', 'BusinessUnitController');
    Route::resource('sub_business_units', 'SubBusinessUnitController');
    Route::resource('zones', 'ZoneController');
    Route::resource('users', 'UserController');
    Route::resource('regions', 'RegionController');
    Route::resource('locations', 'LocationController');
});