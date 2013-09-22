/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function() {

    $('#id_processo').typeahead({
        
        source: function(query, process) {

            $.get('/admin/processos/ajax-search-processo',
                {search:query}, function(data) {
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

});
