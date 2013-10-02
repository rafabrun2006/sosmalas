/* 
 * Script com responsabilidade de definir configurações gerais do sistema
 * assim como é definido para o PHP
 */

var APPLICATION_ENV = window.location;

var APPLICATION_PATH = window.location.pathname;

var application = APPLICATION_PATH.split('/');

getModuleName = function() {
    return application[1];
}
getControllerName = function() {
    return application[2];
}
getActionName = function() {
    return application[3];
}

