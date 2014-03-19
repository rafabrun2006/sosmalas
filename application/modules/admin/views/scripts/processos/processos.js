/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
app = angular.module('App', ['ui.mask', 'ui.bootstrap.pagination']);

app.controller('ProcessosController', function($scope, $http, $filter) {
    $scope.collection = [];
    $scope.dtEntrega = null;
    $scope.dtColeta = null;
    
    loading();
//    $http.post('/admin/processos/find-vw-processos')
//            .success(function(result) {
                $scope.collection = processos;
                $scope.count = processos.length;
                $scope.limitData = 30;
                loaded();
//            })
//            .error(function() {
//                console.log('Error');
//            });

    $scope.filterDateInverse = function() {
        if ($scope.dtColeta !== null) {
            var split = $scope.dtColeta.split('-');
            return (split[2] ? split[2] + '-' : '') + (split[1] ? split[1] + '-' : '') + (split[0] ? split[0] : '');
        }
    };

    function dateToEua(date) {
        var split = date.replace('-', '').split('');
        var data = {date: split[0] + split[1], month: split[2] + split[3], year: split[4] + split[5] + split[6] + split[7]};
        return (data.year ? data.year + '-' : '') + (data.month ? data.month + '-' : '') + (data.date ? data.date : '');
    }

    $scope.filterDataColeta = function(data) {

        if ($scope.dtColeta != null) {
            var dtColeta = dateToEua($scope.dtColeta);
            if (data >= dtColeta) {
                return true;
            } else {
                return false;
            }
        } else if ($scope.dtColeta == null) {
            return true;
        }
    };

    $scope.filterDataEntrega = function(data) {
        if ($scope.dtEntrega != null) {
            var dtEntrega = dateToEua($scope.dtEntrega);
            if (data <= dtEntrega) {
                return true;
            } else {
                return false;
            }
        } else if ($scope.dtEntrega == null) {
            return true;
        }
    };
    
    $scope.dateToBrView = function(dateString){
        var data = dateString.split('-');
        return data[2] + '-' + data[1] + '-' + data[0];
    };

    $scope.resetForm = function() {
        $scope.dtColeta = null;
        $scope.dtEntrada = null;
        $scope.search = null;
    };
    
    $scope.$watch("search", function(query){
        $scope.count = $filter('filter')($scope.collection, query).length;
    });

});


