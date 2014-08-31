/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//collection = {
//    init: function(col) {
//        if (!this.length()) {
//            var arrayObj = [];
//            var i = 0;
//            $.each(col, function(index, val) {
//                val.cid = i++;
//                arrayObj[val.cid] = val;
//            });
//            this.collection = arrayObj;
//            return this.collection;
//        } else {
//            return this.collection;
//        }
//    },
//    collection: [],
//    length: function() {
//        return this.collection.length;
//    },
//    get: function(id) {
//        return this.collection[id];
//    },
//    getAll: function() {
//        return this.collection;
//    },
//    find: function(params) {
//
//    },
//    add: function(model) {
//        model.cid = this.length();
//        this.collection.push(model);
//    },
//    set: function(id, model) {
//        model.cid = id;
//        this.collection[id] = model;
//    },
//    remove: function(id) {
//        this.collection.splice(id, 1);
//    }
//};

app = angular.module('App', ['ui.mask', 'ngRoute', 'ngResource', 'utils']);

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
                params: {id_processo: '@id_processo'}
            }
        });
    }]);

app.factory('ModelHistoricoFactory', ['$resource', function($resource) {
        return $resource('/admin/processos/save-historico-processo/:id', {id_historico_processo: '@id_historico_processo'}, {
            save: {
                method: 'POST',
                params: {id_historico_processo: '@id_historico_processo'}
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
        templateUrl: 'cadastrar.html'
    });
    $routeProvider.otherwise({
        redirectTo: '/'
    });
});

app.controller('ProcessosController', function($scope, $http, $filter, $log, ModelFactory, ModelHistoricoFactory, $window) {

    $scope.dtEntrega = null;
    $scope.dtColeta = null;
    $scope.model = [];
    $scope.collection = [];
    $scope.count = 0;
    $scope.limitData = 10;

    $http.get('/admin/processos/ajax-processos', loading()).success(function(response) {
        $scope.collection = response;
        $scope.count = $scope.collection.length;
        loaded();
    });

    $scope.updateModel = function(model, $event) {
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

    $scope.$watch("cmb_empresa", function(query) {
        $scope.search = query;
        $scope.count = $filter('filter')($scope.collection, query).length;
    });

    $scope.historico = function(model) {
        $('.modal').modal('show');
        $scope.message = {text: 'Aguarde carregando...', type: 'success'};

        $scope.historicoCollection = [];
        $scope.historicoProcessoId = model.cod_processo;

        $http.get('/admin/processos/find-historico-processo/id/' + model.id_processo).success(function(response) {
            $scope.historicoCollection = response;

            if (!$scope.historicoCollection.length) {
                $scope.message.text = 'Nenhum historico encontrado';
                $scope.message.type = 'error';
            }
        });
        return false;
    };

    $scope.imprimirHistorico = function(id) {
        if (id) {
            $window.open('/admin/processos/detalhes/id/' + id);
        }
    };

    $scope.deleteModel = function(model) {
        if (model && confirm('Deseja realmente executar esta operação?')) {
            $scope.model = model;
            ModelFactory.remove({id_processo: $scope.model.id_processo}, $scope.model);
            $scope.collection.splice($scope.model, 1);
            $scope.count = $scope.collection.length;
        }
    };

    $scope.addHistorico = function() {

        $scope.historicoModel = {
            texto_historico: $scope.texto_historico,
            processo_id: $scope.model.id_processo
        };

        var model = ModelHistoricoFactory.save(null, $scope.historicoModel);

        $scope.historicoCollection.push(model);
    };

});

app.controller('ProcessosEditController', function($scope, $log, $routeParams, $location, ModelFactory, $window, $http) {

    $http.get('/admin/processos/ajax-get-processo-by-id/id/' + $routeParams.id).success(function(response) {
        loading();

        $scope.model = response;
        $scope.model.dt_coleta = $scope.model.dt_coleta_br;
        $scope.model.dt_entrega = $scope.model.dt_entrega_br;
        $scope.model.status_id = $scope.model.id_status;

        loaded();
    });

    $('.add-popover').popover({show: 500, hide: 100});

    $scope.save = function(saveNew) {
        $scope.model = ModelFactory.save({id_processo: $scope.model.id_processo}, $scope.model);

        new PNotify({
            type: 'success',
            text: 'Processo alterado com sucesso, um email foi enviado para o parceiro caso esteja habilitado para recebimento',
            title: 'Sucesso'});

        if (saveNew) {
            $scope.model = {};
            $location.path('/cadastrar');
        } else {
            $location.path('/');
        }

    };

    $scope.back = function() {
        $window.history.back();
    };

    $scope.inputNumberUp = function() {
        $scope.model.quantidade++;
    };

    $scope.inputNumberDown = function() {
        if ($scope.model.quantidade > 0) {
            $scope.model.quantidade--;
        }
    };

    $scope.checkFormaFaturamento = function(idFormaFaturamento) {
        $scope.model.forma_faturamento_id = idFormaFaturamento;
    };

    $scope.clear = function(el, val) {
        $scope.model[el] = val;
    };

});

app.controller('ProcessosAddController', function($scope, $log, $location, ModelFactory, $window) {

    $scope.model = {quantidade: 1, forma_faturamento_id: 3};

    $('#div-quantidade').popover({show: 500, hide: 100});

    $scope.save = function(saveNew) {
        $scope.model = ModelFactory.save(null, $scope.model);

        new PNotify({
            type: 'success',
            text: 'Novo processo cadastrado com sucesso, um email foi enviado para o parceiro caso esteja habilitado para recebimento',
            title: 'Sucesso'});

        if (saveNew) {
            $scope.model = {};
            $location.path('/cadastrar');
        } else {
            $location.path('/');
        }
    };

    $scope.back = function() {
        $window.history.back();
    };

    $scope.inputNumberUp = function() {
        $scope.model.quantidade++;
    };

    $scope.inputNumberDown = function() {
        if ($scope.model.quantidade > 0) {
            $scope.model.quantidade--;
        }
    };

    $scope.checkFormaFaturamento = function(idFormaFaturamento) {
        $scope.model.forma_faturamento_id = idFormaFaturamento;
    };

    $scope.clear = function(el) {
        $scope.model[el] = null;
    };

});