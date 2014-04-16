/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function() {

    /*Usado pela função de busca auto-complete de pessoa*/
    var nomePessoa = null;
    var idPessoa = null;
    var mapped;

    $('.dropdown-toggle').dropdown();

    $('.date').datepicker({
        format: 'dd-mm-yyyy',
        language: 'pt-BR',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true
    });

    $('.date').mask('99-99-9999');

    $('.fone').mask('(99)9999-9999');

    $('.money').maskMoney({symbol: 'R$ ', decimal: ".", thousands: "."});

    $('.btn-danger').live('click', function() {
        if (!confirm('Tem certeza que deseja continuar esta operação?')) {
            return false;
        }
    });

    $('#search-pessoa').typeahead({
        source: function(query, process) {
            $.get('/admin/pessoa/ajax-search-person/nome_pessoa', {query: {nome_contato: "like " + "'%" + query + "%'"}}, function(data) {
                labels = [];
                mapped = {};

                $.each(data, function(key, value) {
                    mapped[value.id_pessoa] = value;
                    labels.push(value.id_pessoa + '.' + value.nome_contato);
                });

                process(labels);
            });
        },
        items: 10,
        updater: function(item) {
            retiraPonto = item.split('.');
            nome = retiraPonto[1].split('-');

            nomePessoa = nome[0];
            idPessoa = retiraPonto[0];

            $('#cliente_id').val(retiraPonto[0]);
            return nomePessoa;
        }
    });

    function getPessoaByName(param) {
        result = {};
        $.ajax({
            async: false,
            url: '/admin/pessoa/ajax-search-person',
            dataType: 'json',
            type: 'POST',
            data: {'nome_pessoa': "like '%" + param + "%'"},
            success: function(data) {
                var array = new Array();

                $.each(data, function(index, value) {
                    array.push(value.id_pessoa, value.nome_pessoa);
                });

                result = array;
            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log(thrownError);
            }
        });

        return result;
    }
});

function dateToView(dateString) {
    var data = dateString.split('-');
    return data[2] + '-' + data[1] + '-' + data[0];
}

angular.module('utils', [])
        .controller('MaskMoney', function($log, $scope) {
            $('.money').maskMoney({symbol: 'R$ ', decimal: ".", thousands: "."});
            $log.info('Aplicando mascara valor');
        })
        .controller('DatePicker', function($log, $scope) {
            $('.date').datepicker({
                format: 'dd-mm-yyyy',
                language: 'pt-BR',
                autoclose: true,
                todayHighlight: true,
                clearBtn: true
            }).mask('99-99-9999');
            $log.info('Aplicando mascara e date');
        });
        
