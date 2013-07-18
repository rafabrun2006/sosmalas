/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function() {

    $('#os_coleta').typeahead({
        
        source: function(query, process) {
            
            $.get('/admin/coleta/ajax-search-coleta', 
                {os_coleta:query}, function(data) {
                labels = [];
                mapped = {};

                $.each(data, function(key, value) {
                    mapped[value.os_coleta] = value;
                    labels.push(
                            value.os_coleta + ':' + 
                            value.tipo_coleta + ' | ' + 
                            value.cliente_email + ' | ' + 
                            value.data_pedido_coleta + ' | ' +
                            value.pcm_coleta + ' | ' +
                            value.previsao_coleta);
                });

                process(labels);
            });
        },
        items: 10,
        updater: function(item) {
            split = item.split(':');
            return split[0];
        }
    });

});
