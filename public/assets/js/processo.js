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
    
    $('.form-search').submit(function(){
        
        $.ajax({
            url:'/admin/processos/ajax-pesquisar',
            data:$('.form-search').serialize(),
            type:'post',
            dataType:'html',
            success: function(response){
                $('section').html(response);
            },
            error: function(){
                alert('Erro no carregamento dos dados');
            }
        });
        
        return false;
    });
    
    $('.form-paginator').click(function(){
        $('#page').val(parseInt($(this).html()));
        $(this).submit();
        return false;
    });
});
