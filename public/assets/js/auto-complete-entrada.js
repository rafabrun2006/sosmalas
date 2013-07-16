/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function() {

    $('#id_entrada').typeahead({
        
        source: function(query, process) {
            
            $.get('/admin/entrada/ajax-search-entrada', 
                {id_entrada:query}, function(data) {
                labels = [];
                mapped = {};

                $.each(data, function(key, value) {
                    mapped[value.id_entrada] = value;
                    labels.push(value.id_entrada + '-Empresa: (' + value.empresa_entrada + ') Dano: (' + value.dano_entrada + ')');
                });

                process(labels);
            });
        },
        items: 10,
        updater: function(item) {
            split = item.split('-');
            return split[0];
        }
    });

});
