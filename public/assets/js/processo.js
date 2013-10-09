/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function() {
    var visible = false;

    $('#id_processo').typeahead({
        source: function(query, process) {

            $.get('/admin/processos/ajax-search-processo',
                    {search: query}, function(data) {
                labels = [];
                mapped = {};

                $.each(data, function(key, value) {
                    mapped[value.id_processo] = value;

                    var data_entrega = dateToView(value.data_entrega_processo);
                    var data_coleta = dateToView(value.data_coleta_processo);

                    labels.push(
                            value.id_processo + ':' +
                            value.pessoa_entrada + ' | ' +
                            value.servico_realizado_processo + ' | ' +
                            data_coleta + ' | ' +
                            value.os_processo + ' | ' +
                            data_entrega + ' | ' +
                            value.qtd_bagagem_processo + ' | ' +
                            value.nome_pax_processo
                            );
                });

                return process(labels);
            });
        },
        items: 20,
        updater: function(item) {
            split = item.split(':');
            return split[0];
        }
    });

    $('#search-advanced').click(function() {
        if (visible == false) {
            $('.hide').show().removeAttr('disabled');
            $('.show').attr('disabled', 'disabled');
            $(this).html('Menos Filtros');
        } else {
            $('.hide').hide().attr('disabled', 'disabled');
            $('.show').removeAttr('disabled');
            $(this).html('Mais Filtros');
        }
        visible = !visible;
    });

    //inicia lista de processos geral
    searchProcessos();

    $('.form-search').submit(function() {
        searchProcessos();
        return false;
    });

    $('.form-paginator').live('click', function() {
        loading();
        $('#page').val(parseInt($(this).attr('id')));
        $(this).submit();
        loaded();
        return false;
    });

    function searchProcessos() {
        $.ajax({
            url: '/admin/processos/ajax-pesquisar',
            data: $('.form-search').serialize(),
            type: 'post',
            dataType: 'html',
            success: function(response) {
                $('.table-processos').html(response);
            },
            error: function() {
                alert('Erro no carregamento dos dados');
            }
        });
    }
});
