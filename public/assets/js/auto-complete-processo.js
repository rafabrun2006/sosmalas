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
                    labels.push(
                            value.id_processo + ':' + 
                            value.pessoa_entrada + ' | ' + 
                            value.servico_realizado_processo + ' | ' +
                            value.data_coleta_processo + ' | ' +
                            value.os_processo + ' | ' +
                            value.data_entrega_processo + ' | ' +
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
