app.config(function ($stateProvider, $urlRouterProvider) {
    // For any unmatched url, redirect to /state1
    $urlRouterProvider.otherwise("/index");
    //
    // Now set up the states
    $stateProvider
            .state('index', {
                url: "/index",
                templateUrl: "/admin/index/dashboard"
            })
            .state('pessoa', {
                url: "/pessoa",
                templateUrl: "/admin/pessoa/index",
                controller: 'PessoaController'
            })
            .state('processos', {
                url: "/processos",
                templateUrl: "/admin/processos/index",
                controller: "ProcessosController"
            })
            .state('processosaddedit', {
                url: '/processos/edit-add/:id',
                templateUrl: '/admin/processos/add-edit',
                controller: "ProcessosAddEditController"
            });
});