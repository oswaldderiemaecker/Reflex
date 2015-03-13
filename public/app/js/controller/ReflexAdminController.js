/**
 * Created by David on 10/03/15.
 */

app.controller('CountryController', function($scope, $http) {

    $scope.countries = [];
    $scope.newCountry = {};

    $http.get('/api/countries').
        success(function(data, status, headers, config) {
            $scope.countries = data;
        });

    $scope.removeCountry = function(country) {
        $http.delete('/api/countries/' + country.id).
            success(function(data, status, headers, config) {
                for (index = 0; index < $scope.countries.length; ++index) {
                    if ($scope.countries[index].id == country.id) {
                        $scope.countries.splice(index, 1);
                    }
                }
            });
    }

    $scope.addCountry = function() {
        $http.post('/api/countries', $scope.newCountry).
            success(function(data, status, headers, config) {
                $scope.countries.push(data);
                    $scope.newCountry = {};
            });
    }
});

app.controller('CompanyController', function($scope, $http) {

    $scope.companies  = [];
    $scope.newCompany = {};

    $scope.countries = []

    $http.get('/api/countries').
        success(function(data, status, headers, config) {
            $scope.countries = data;
        });

    $http.get('/api/companies').
        success(function(data, status, headers, config) {
            $scope.companies = data;
        });

    $scope.removeCompany = function(company) {
        $http.delete('/api/companies/' + company.id).
            success(function(data, status, headers, config) {
                for (var index = 0; index < $scope.companies.length; ++index) {
                    if ($scope.companies[index].id == company.id) {
                        $scope.companies.splice(index, 1);
                    }
                }
            });
    };

    $scope.addCompany = function() {
        $http.post('/api/companies', $scope.newCompany).
            success(function(data, status, headers, config) {

                $scope.companies.push(data);
                $scope.newCompany = {};
            });
    }
});

app.controller('BusinessUnitController', function($scope, $http) {

    $scope.businessUnits  = [];
    $scope.newBusinessUnit = {};

    $scope.companies = [];

    $http.get('/api/companies').
        success(function(data, status, headers, config) {
            $scope.companies = data;
        });

    $http.get('/api/business_units').
        success(function(data, status, headers, config) {
            $scope.businessUnits = data;
        });

    $scope.removeBusinessUnit = function(businessUnit) {
        $http.delete('/api/business_units/' + businessUnit.id).
            success(function(data, status, headers, config) {
                for (var index = 0; index < $scope.businessUnits.length; ++index) {
                    if ($scope.businessUnits[index].id == businessUnit.id) {
                        $scope.businessUnits.splice(index, 1);
                    }
                }
            });
    };

    $scope.addBusinessUnit = function() {
        $http.post('/api/business_units', $scope.newBusinessUnit).
            success(function(data, status, headers, config) {

                $scope.businessUnits.push(data);
                $scope.newBusinessUnit = {};
            });
    }
});

app.controller('SubBusinessUnitController', function($scope, $http) {

    $scope.subBusinessUnits  = [];
    $scope.newSubBusinessUnit = {};

    $scope.businessUnits = [];

    $http.get('/api/business_units').
        success(function(data, status, headers, config) {
            $scope.businessUnits = data;
        });

    $http.get('/api/sub_business_units').
        success(function(data, status, headers, config) {
            $scope.subBusinessUnits = data;
        });

    $scope.removeSubBusinessUnit = function(subBusinessUnit) {
        $http.delete('/api/sub_business_units/' + subBusinessUnit.id).
            success(function(data, status, headers, config) {
                for (var index = 0; index < $scope.subBusinessUnits.length; ++index) {
                    if ($scope.subBusinessUnits[index].id == subBusinessUnit.id) {
                        $scope.subBusinessUnits.splice(index, 1);
                    }
                }
            });
    };

    $scope.addSubBusinessUnit = function() {
        $http.post('/api/sub_business_units', $scope.newSubBusinessUnit).
            success(function(data, status, headers, config) {

                $scope.subBusinessUnits.push(data);
                $scope.newSubBusinessUnit = {};
            });
    }
});


app.controller('ZoneController', function($scope, $http) {

    $scope.zones   = [];
    $scope.newZone = {};

    $scope.businessUnits = [];
    $scope.companies = [];
    $scope.regions = [];

    $http.get('/api/business_units').
        success(function(data, status, headers, config) {
            $scope.businessUnits = data;
        });

    $http.get('/api/companies').
        success(function(data, status, headers, config) {
            $scope.companies = data;
        });

    $http.get('/api/regions').
        success(function(data, status, headers, config) {
            $scope.regions = data;
        });

    $http.get('/api/zones').
        success(function(data, status, headers, config) {
            $scope.zones = data;
        });

    $scope.removeZone = function(zone) {
        $http.delete('/api/zones/' + zone.id).
            success(function(data, status, headers, config) {
                for (var index = 0; index < $scope.zones.length; ++index) {
                    if ($scope.zones[index].id == zone.id) {
                        $scope.zones.splice(index, 1);
                    }
                }
            });
    };

    $scope.addZone = function() {
        $http.post('/api/zones', $scope.newZone).
            success(function(data, status, headers, config) {

                $scope.zones.push(data);
                $scope.newZone = {};
            });
    }
});