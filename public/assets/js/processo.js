/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function() {
    
    $('#auto-complete').keyup(function() {

        clearTimeout();
        setTimeout(function() {

            $('#auto-complete').typeahead({
                source: function(query, process) {

                    $.ajax({
                        url: '/admin/processos/ajax-search-processo',
                        search: query,
                        success: function(data) {

                            labels = [];
                            mapped = {};
                            $.each(data, function(key, value) {
                                mapped[value.id_processo] = value;
                                var data_entrega = dateToView(value.dt_entrega);
                                var data_coleta = dateToView(value.dt_coleta);
                                labels.push(
                                        value.cod_processo + ':' +
                                        value.id_empresa + ' | ' +
                                        value.conserto + ' | ' +
                                        data_coleta + ' | ' +
                                        value.nu_processo + ' | ' +
                                        data_entrega + ' | ' +
                                        value.quantidade + ' | ' +
                                        value.nome_cliente
                                        );
                            });
                            return process(labels);
                        }
                    });
                },
                items: 20,
                updater: function(item) {
                    split = item.split(':');
                    return split[0];
                }
            });
        }, 800);
    });
    //inicia lista de processos geral
    searchProcessos();
    $('.form-search').submit(function() {
        searchProcessos();
        return false;
    });
    $('.form-paginator').live('click', function(event) {
        event.preventDefault();
        paginationProcessos($(this).attr('id'));
        return false;
    });
    $('.form-paginator-select').live('change', function(event) {
        event.preventDefault();
        paginationProcessos($(this).val());
        return false;
    });
    function paginationProcessos(page) {
        $('#page').val(parseInt(page));
        searchProcessos();
    }

    function searchProcessos() {
        loading();
        $.ajax({
            url: '/admin/processos/ajax-pesquisar',
            data: $('.form-search').serialize(),
            type: 'post',
            dataType: 'html',
            success: function(response) {
                $('.table-processos').html(response);
                loaded();
            },
            error: function() {
                alert('Erro no carregamento dos dados');
                loaded();
            }
        });
    }
});
