/* 
 * Contem funcoes gerais utilizadas por todo o sistema
 */

$(document).ready(function() {

});

function loading() {
    $('#overlay').fadeIn(10000);
    $('#overlay').fadeTo('slow', 0.8);
    $('#overlay').addClass('loading');
}

function loaded() {
    $('#overlay').fadeOut('fast');
    $('#overlay').removeClass('loading');
}