
var app = angular.module('App', [
    'ui.mask',
    'ngRoute',
    'ngResource',
    'ui.router',
    'utils'
]).run(['$rootScope', '$state', '$stateParams',
    function ($rootScope, $state, $stateParams) {
        $rootScope.$state = $state;
        $rootScope.$stateParams = $stateParams;
    }])
        ;

