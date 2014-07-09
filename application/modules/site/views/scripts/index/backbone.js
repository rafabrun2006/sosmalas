/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function() {
    var HelloView = Backbone.View.extend({
        el: $('section'),
        tpl: 1,
        initialize: function() {
            this.render();
        },
        render: function() {
            if (this.tpl ===1)
            {
                
            }
            if(this.tpl ===2){
                $(this.el).html('<h1>Hello World 2</h1>');
            }
            
            $(this.el).append("<a class='btn btn-danger' id='button' href='#'>index</a>");
        }
    });

    //var hello = new HelloView();

    var Router = Backbone.Router.extend({
        initialize: function() {

        },
        routes: {
            'index': "index",
        },
        index: function() {
            //hello.tpl = 2;
            //hello.render();
        }
    });

    routes = new Router();
    Backbone.history.start(true);

    $('#button').click(function() {
        routes.navigate('index', {trigger: true, replace: true});
    });
});

