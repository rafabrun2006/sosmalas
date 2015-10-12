app.controller('ProcessosController', function ($scope, $http, $filter, $log, ModelFactory, ModelHistoricoFactory, $window) {

    $scope.dtEntrega = null;
    $scope.dtColeta = null;
    $scope.model = [];
    $scope.collection = [];
    $scope.count = 0;
    $scope.limitData = 10;
    $scope.statusProcesso = [];

    $scope.search = {};
    $scope.filterLabels = '';

    $scope.filterGrid = function (object) {

        var res1 = true, res2 = true, res3 = true;

        var arr = [];
        var labels = [];

        if ($scope.search.nome_empresa) {
            if ($scope.search.nome_empresa !== object.nome_empresa) {
                res1 = false;
            }
            labels.push($scope.search.nome_empresa);
        }

        if ($scope.search.id_status) {
            if ($scope.search.id_status.id_status !== parseInt(object.id_status)) {
                res2 = false;
            }
            labels.push($scope.search.id_status.tx_status);
        }

        if ($scope.search.input) {
            angular.forEach(object, function (val) {
                arr.push(val);
            });

            res3 = $filter('filter')(arr, $scope.search.input).length;

            labels.push($scope.search.input);
        }

        $scope.filterLabels = labels.join(' / ');

        if (!res1) {
            return false;
        }

        if (!res2) {
            return false;
        }

        if (!res3) {
            return false;
        }

        return true;

    };

    $http.get('/admin/processos/ajax-status-processo').success(function (response) {
        $scope.statusProcesso = response;
    });

    $http.get('/admin/processos/ajax-processos', loading()).success(function (response) {
        $scope.collection = response;
        $scope.count = $scope.collection.length;
        loaded();
    });

    $scope.updateModel = function (model, $event) {
        $($event.target).parents('tbody').find('tr').removeClass('success');
        $($event.target).parent('tr').addClass('success');
        $scope.model = model;
    };

    //Fazer filtro em capo data invertendo formato
    $scope.filterDateInverse = function () {
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
    $scope.filterDataColeta = function (data) {

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
    $scope.filterDataEntrega = function (data) {
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
    $scope.resetForm = function () {
        $scope.dtColeta = null;
        $scope.dtEntrada = null;
        $scope.search = {};
    };

    $scope.historico = function (model) {
        $('.modal').modal('show');
        $scope.message = {text: 'Aguarde carregando...', type: 'success'};

        $scope.historicoCollection = [];
        $scope.historicoProcessoId = model.cod_processo;

        $http.get('/admin/processos/find-historico-processo/id/' + model.id_processo).success(function (response) {
            $scope.historicoCollection = response;

            if (!$scope.historicoCollection.length) {
                $scope.message.text = 'Nenhum historico encontrado';
                $scope.message.type = 'error';
            }
        });
        return false;
    };

    $scope.imprimirHistorico = function (id) {
        if (id) {
            $window.open('/admin/processos/detalhes/id/' + id);
        }
    };

    $scope.deleteModel = function (model) {
        if (model && confirm('Deseja realmente executar esta operação?')) {
            $scope.model = model;
            ModelFactory.remove({id_processo: $scope.model.id_processo}, $scope.model);
            $scope.collection.splice($scope.model, 1);
            $scope.count = $scope.collection.length;
        }
    };

    $scope.addHistorico = function () {

        $scope.historicoModel = {
            texto_historico: $scope.texto_historico,
            processo_id: $scope.model.id_processo
        };

        var model = ModelHistoricoFactory.save(null, $scope.historicoModel);

        $scope.historicoCollection.push(model);
    };

});

app.controller('ProcessosAddEditController', function ($scope, $log, $location, ModelFactory, $window, $http, $filter, $state) {

    $scope.prc = {quantidade: 1};
    $scope.checkedProduto = {tamanhos: [], cores: [], marcas: []};
    $scope.produto = {tamanhos: [], cores: [], marcas: []};
    $scope.marcas = [];
    $scope.itens = [];
    $scope.statusProcesso = [];
    $scope.localEntregaColeta = [];
    $scope.parceiros = [];
    $scope.message = null;
    $scope.cliente = {};
    $scope.edit = false;
    $scope.saveAction = 1;

    $('#div-quantidade').popover({show: 500, hide: 100});

    $http.get('/admin/marca').success(function (response) {
        $scope.marcas = response;
    });

    $http.get('/admin/processos/ajax-status-processo').success(function (response) {
        $scope.statusProcesso = response;
    });

    $http.get('/admin/processos/ajax-local-entrega-coleta').success(function (response) {
        $scope.localEntregaColeta = response;
    });

    $http.get('/admin/pessoa/ajax-get-parceiros').success(function (response) {
        $scope.parceiros = response;
    });

    if ($state.params.id) {
        
        $scope.edit = true;

        $http.get('/admin/processos/ajax-get-processo-by-id/id/' + $state.params.id).success(function (response) {
            loading();

            $http.get('/admin/pessoa/ajax-get-client/id_pessoa/' + response.pessoa_cliente_id)
                    .success(function (response) {
                        $scope.cliente = response;
                    });

            $scope.prc = response;
            $scope.prc.dt_coleta = response.dt_coleta_br;
            $scope.prc.dt_entrega = response.dt_entrega_br;
            $scope.prc.status_id = response.id_status;

            angular.forEach(response.tx_produto_marcas.split('|'), function (val) {
                $scope.produto.marcas[val] = true;
                $scope.checkMarcas(val);
            });

            angular.forEach(response.tx_produto_cores.split('|'), function (val) {
                $scope.produto.cores[val] = true;
                $scope.checkCores(val);
            });

            angular.forEach(response.tx_produto_tamanhos.split('|'), function (val) {
                $scope.produto.tamanhos[val] = true;
                $scope.checkTamanhos(val);
            });

            loaded();
        });
    }

    $scope.save = function () {

        var processo = angular.copy($scope.prc);
        
        processo.tx_produto_marcas = $scope.checkedProduto.marcas.join('|');
        processo.tx_produto_cores = $scope.checkedProduto.cores.join('|');
        processo.tx_produto_tamanhos = $scope.checkedProduto.tamanhos.join('|');

        angular.extend(processo, $scope.cliente);

        ModelFactory.save(null, processo, function (response) {
            $scope.prc = response.model;
            $scope.prc.dt_coleta = response.model.dt_coleta_br;
            $scope.prc.dt_entrega = response.model.dt_entrega_br;
            $scope.prc.status_id = response.model.id_status;
        });

        new PNotify({
            type: 'success',
            text: 'Novo processo cadastrado com sucesso, um email foi enviado para o parceiro caso esteja habilitado para recebimento',
            title: 'Sucesso'});

            $scope.saveActions($scope.saveAction);
    };

    $scope.checkTamanhos = function (val) {
        if ($scope.produto.tamanhos[val]) {
            $scope.checkedProduto.tamanhos.push(val);
        } else {
            var index = $scope.checkedProduto.tamanhos.indexOf(val);
            $scope.checkedProduto.tamanhos.splice(index, 1);
        }
    };

    $scope.checkCores = function (val) {
        if ($scope.produto.cores[val]) {
            $scope.checkedProduto.cores.push(val);
        } else {
            var index = $scope.checkedProduto.cores.indexOf(val);
            $scope.checkedProduto.cores.splice(index, 1);
        }
    };

    $scope.checkMarcas = function (val) {
        if ($scope.produto.marcas[val]) {
            $scope.checkedProduto.marcas.push(val);
        } else {
            var index = $scope.checkedProduto.marcas.indexOf(val);
            $scope.checkedProduto.marcas.splice(index, 1);
        }
    };

    $scope.back = function () {
        $window.history.back();
    };

    $scope.addMarca = function () {

        var item = {tx_marca: $scope.marca};

        $http.post('/admin/marca/post', item).success(function (item) {
            if (item.id_marca) {
                $scope.marcas.push(item);
                $scope.marca = '';
            }
        });
    };
    
    $scope.saveActions = function(action){
        switch(action){
            case 1:
                //salvar e concluir
                $state.go('processos');
                break;
            case 2:
                //salvar e novo
                $state.go('processosaddedit', {id:null});
                break;
            default:
                //salvar e permanecer
                break;
        }
    };

});