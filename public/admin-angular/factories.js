
app.factory('ModelFactory', ['$resource', function ($resource) {
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

app.factory('ModelHistoricoFactory', ['$resource', function ($resource) {
        return $resource('/admin/processos/save-historico-processo/:id', {id_historico_processo: '@id_historico_processo'}, {
            save: {
                method: 'POST',
                params: {id_historico_processo: '@id_historico_processo'}
            }
        });
    }]);

