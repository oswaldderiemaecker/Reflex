/**
 * Created by David on 10/03/15.
 */

var app =  angular.module('reflexApp',['ngRoute']);

app.config(['$routeProvider',
    function($routeProvider) {
    $routeProvider.
    when('/admin/country', {
        templateUrl: 'js/view/country.html',
        controller: 'CountryController'
    }).
    when('/admin/company', {
        templateUrl: 'js/view/company.html',
        controller: 'CompanyController'
    }).
    when('/admin/business_unit', {
        templateUrl: 'js/view/business_unit.html',
        controller: 'BusinessUnitController'
    }).
    when('/admin/sub_business_unit', {
        templateUrl: 'js/view/sub_business_unit.html',
        controller: 'SubBusinessUnitController'
    }).when('/admin/zone', {
            templateUrl: 'js/view/zone.html',
            controller: 'ZoneController'
        }).otherwise({
            redirectTo: '/admin/country'
        });
    }]);