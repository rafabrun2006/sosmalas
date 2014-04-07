/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
collection = {
    init: function(col) {
        if (!this.length()) {
            var arrayObj = [];
            $.each(col, function(index, val) {
                val.cid = index;
                arrayObj[val.cid] = val;
            });
            this.collection = arrayObj;
            return this.collection;
        }else{
            return this.collection;
        }
    },
    collection: [],
    length: function() {
        return this.collection.length;
    },
    get: function(id) {
        return this.collection[id];
    },
    getAll: function() {
        return this.collection;
    },
    find: function(params) {

    },
    add: function(model) {
        this.collection.push(model);
    },
    set: function(id, model) {
        model.cid = id;
        this.collection[id] = model;
    },
    remove: function(id){
        this.collection.splice(id, 1);
    }
};

app = angular.module('App', ['ui.mask', 'ngRoute', 'ngResource']);

app.factory('ModelFactory', ['$resource', function($resource) {
        return $resource('/admin/processos/get/:id', {id_processo: '@id_processo'}, {
            save: {
                url: '/admin/processos/save/:id',
                method: 'POST',
                params: {id_processo: '@id_processo'}
            },
            get: {
                method: 'GET',
                params: {id_processo: '@id_processo'}
            },
            remove: {
                url: '/admin/processos/delete/:id',
                method: 'DELETE',
                params: {id_processo:'@id_processo'}
            }
        });
    }]);

app.config(function($routeProvider) {
    $routeProvider.when('/', {
        controller: 'ProcessosController',
        templateUrl: 'index.html'
    });
    $routeProvider.when('/editar/:id', {
        controller: 'ProcessosEditController',
        templateUrl: 'editar.html'
    });
    $routeProvider.when('/cadastrar', {
       controller: 'ProcessosAddController',
       templateUrl: 'editar.html'
    });
    $routeProvider.otherwise({
        redirectTo: '/'
    });
});

app.controller('ProcessosController', function($scope, $http, $filter, $log, ModelFactory) {

    $scope.dtEntrega = null;
    $scope.dtColeta = null;
    $scope.model = [];

    $scope.collection = collection.init(processos);
    $scope.count = collection.length();
    $scope.limitData = 10;
    
    $scope.updateModel = function(model, $event) {
        $log.info('Atualizando model');

        $($event.target).parents('tbody').find('tr').removeClass('success');
        $($event.target).parent('tr').addClass('success');
        $scope.model = model;
    };

    //Fazer filtro em capo data invertendo formato
    $scope.filterDateInverse = function() {
        if ($scope.dtColeta !== null) {
            var split = $scope.dtColeta.split('-');
            return (split[2] ? split[2] + '-' : '') + (split[1] ? split[1] + '-' : '') + (split[0] ? split[0] : '');
        }
    };

    //Transformar formato data de americano para brasileiro
    function dateToEua(date) {
        var split = date.replace('-', '').split('');
        var data = {date: split[0] + split[1], month: split[2] + split[3], year: split[4] + split[5] + split[6] + split[7]};
        return (data.year ? data.year + '-' : '') + (data.month ? data.month + '-' : '') + (data.date ? data.date : '');
    }
    ;

    //Fitro por data de coleta
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

    //Fitro por data de entrega
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

    //Metodo para resetar dados do formulario de pesquisa
    $scope.resetForm = function() {
        $scope.dtColeta = null;
        $scope.dtEntrada = null;
        $scope.search = null;
    };

    $scope.$watch("search", function(query) {
        $scope.count = $filter('filter')($scope.collection, query).length;
    });

    $scope.historico = function(model) {
        $('.modal').modal('show');
        $('.modal #modal-alert').html('<span>Aguarde carregando...</span>').removeClass('alert-error').show();

        $scope.historicoCollection = [];
        $scope.historicoProcessoId = model.cod_processo;

        $http.get('/admin/processos/find-historico-processo/id/' + model.id_processo).success(function(response) {
            $scope.historicoCollection = response;

            if ($scope.historicoCollection.length) {
                $('.modal #modal-alert').hide();
            } else {
                $('.modal #modal-alert').html('<span>Nenhum histórico encontrado</span>').addClass('alert-error');
            }
        });
        return false;
    };

    $scope.imprimirHistorico = function(id) {
        if (id) {
            window.open('/admin/processos/detalhes/id/' + id);
        }
    };
    
    $scope.deleteModel = function(id){
        
        if(id && confirm('Deseja realmente executar esta operação?')){
            $scope.model = collection.get(id);
            ModelFactory.remove({id_processo: $scope.model.id_processo}, $scope.model);
            collection.remove($scope.model.cid);
            $scope.count = collection.length() - 1;
        }
    };

});

app.controller('ProcessosEditController', function($scope, $log, $filter, $routeParams, $location, ModelFactory) {
    $scope.model = $filter('filter')(collection.getAll(), {id_processo: $routeParams.id}, true)[0];
    $scope.model.dt_coleta = $scope.model.dt_coleta_br;
    $scope.model.dt_entrega = $scope.model.dt_entrega_br;
    $scope.model.status_id = $scope.model.id_status;

    $scope.save = function() {
        $scope.model = ModelFactory.save({id_processo: $scope.model.id_processo}, $scope.model);
        collection.set($scope.model.cid, $scope.model);
        $location.path('/');
    };

    $scope.back = function() {
        $location.path('/');
    };

});

app.controller('ProcessosAddController', function($scope, $log, $location, ModelFactory){
    
    $scope.back = function() {
        $location.path('/');
    };
    
});