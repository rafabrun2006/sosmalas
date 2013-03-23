/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function(){
    
    $(".conteudoMenu").hide();
    $(".itemMenu").click(function(){
        $(".conteudoMenu").slideUp("slow");
        $(this).next(".conteudoMenu").slideDown("slow");
    });
    
//    $(document).ready(function(){
//        $(".conteudoMenu").hide();
//        $(".itemMenu").click(function(){
//            $(this).next(".conteudoMenu").slideToggle(300);
//        });
//    });
    
    $(".conteudoMenu:not(:first)").hide();
});