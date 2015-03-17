<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');
Route::get('sub_unidades', 'HomeController@sub_business_unit');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

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