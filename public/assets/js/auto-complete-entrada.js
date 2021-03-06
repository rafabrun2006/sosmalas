/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function() {

    $('#id_entrada').typeahead({
        
        source: function(query, process) {
            
            $.get('/admin/entrada/ajax-search-entrada', 
                {search:query}, function(data) {
                labels = [];
                mapped = {};

                $.each(data, function(key, value) {
                    mapped[value.id_entrada] = value;
                    labels.push(
                            value.id_entrada + ':' + 
                            value.empresa_entrada + ' | ' + 
                            value.dano_entrada + ' | ' +
                            value.data_entrada + ' | ' +
                            value.marca_entrada + ' | ' +
                            value.preco_entrada + ' | ' +
                            value.data_conclusao_entrada + ' | ' +
                            value.data_entrega_entrada
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
