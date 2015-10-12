/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

app.controller('PessoaController', function($scope, $http) {
    $scope.pessoaCollection = [];
    $scope.user = 'Texto';

    loading();
    $http({
        async: false,
        method: 'GET',
        url: '/pessoa/get'
    }).success(function(response) {
        $scope.pessoaCollection = response;
        loaded();
    });

    $scope.submitForm = function() {
        $('#form-edit-person').submit();
    };
});