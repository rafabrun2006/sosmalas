/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function() {

    $('.date').datepicker({
        format: 'dd-mm-yyyy',
        monthsShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
        daysShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab']
    });
    
    $('.date').mask('99-99-9999');
    
    $('.fone').mask('(99)9999-9999');
    
    $('.btn-danger').click(function(){
       if(!confirm('Tem certeza que deseja continuar esta operação?')){
           return false;
       }
    });

    $('#search-pessoa').typeahead({
        source: function(query, process) {
            $.get('/admin/pessoa/ajax-search-person/nome_pessoa', {query: {nome_pessoa: "like " + "'%" + query + "%'"}}, function(data) {
                labels = [];
                mapped = {};

                $.each(data, function(key, value) {
                    mapped[value.nome_pessoa] = value.id_pessoa;
                    labels.push(value.nome_pessoa);
                });

                process(labels);
            });
        },
        items: 10,
        updater: function(item) {
            $('#cliente_id').val(mapped[item]);
            return item;
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

