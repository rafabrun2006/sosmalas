/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//setInterval(function(){
//    window.location.reload();
//}, 4000);

app = angular.module('App', ['ngGrid', 'ui.mask']);

app.controller('UserController', function($scope, $http, $q) {

    $scope.columns = [
        {field: 'id_pessoa', displayName: 'ID'},
        {field: 'nome_empresa', displayName: 'Empresa/Funcionario'},
        {field: 'nome_contato', displayName: 'Contato'},
        {field: 'fone_empresa', displayName: 'Telefone'},
        {field: 'email', displayName: 'E-mail'},
        {field: 'tipo_acesso_id', displayName: 'Tipo de Acesso'},
    ];

    $scope.filterOptions = {
        filterText: "",
        useExternalFilter: true
    };
    $scope.totalServerItems = 0;
    $scope.pagingOptions = {
        pageSizes: [250, 500, 1000],
        pageSize: 25,
        currentPage: 1
    };
    $scope.setPagingData = function(data, page, pageSize) {
        var pagedData = data.slice((page - 1) * pageSize, page * pageSize);
        $scope.myData = pagedData;
        $scope.totalServerItems = data.length;
        if (!$scope.$$phase) {
            $scope.$apply();
        }
    };
    $scope.getPagedDataAsync = function(pageSize, page, searchText) {
        setTimeout(function() {
            var data;
            if (searchText) {
                var ft = searchText.toLowerCase();

                data = $scope.myData.filter(function(item){
                    return JSON.stringify(item).toLowerCase().indexOf(ft) != -1;
                });
                $scope.setPagingData(data, page, pageSize);

            } else {
                loading();
                $http({url: '/pessoa/data-js', method: 'GET'}).success(function(response) {
                    $scope.setPagingData(response, page, pageSize);
                    loaded();
                });
            }
        }, 100);
    };

    $scope.getPagedDataAsync($scope.pagingOptions.pageSize, $scope.pagingOptions.currentPage);

    $scope.$watch('pagingOptions', function(newVal, oldVal) {
        if (newVal !== oldVal && newVal.currentPage !== oldVal.currentPage) {
            $scope.getPagedDataAsync($scope.pagingOptions.pageSize, $scope.pagingOptions.currentPage, $scope.filterOptions.filterText);
        }
    }, true);
    $scope.$watch('filterOptions', function(newVal, oldVal) {
        if (newVal !== oldVal) {
            $scope.getPagedDataAsync($scope.pagingOptions.pageSize, $scope.pagingOptions.currentPage, $scope.filterOptions.filterText);
        }
    }, true);

    $scope.gridOptions = {
        data: 'myData',
        jqueryUITheme: true,
        enablePaging: true,
        showFooter: true,
        pagingOptions: $scope.pagingOptions,
        filterOptions: $scope.filterOptions,
        totalServerItems: 'totalServerItems',
        showColumnMenu: true,
        showFilter: true,
        multiSelect: false,
        enableColumnResize: true,
        columnDefs: $scope.columns
    };
});
