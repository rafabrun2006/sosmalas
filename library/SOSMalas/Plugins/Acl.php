<?php

class SOSMalas_Plugins_Acl extends Zend_Controller_Plugin_Abstract {

    public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request) {

        /*
         *  Atentar para alguns detalhes como os de configuração de PHP.INI
         *  referente ao SESSION.COOKIE_DOMAIN, configurado no arquivo INDEX.PHP
         */
        
        /*
         * Chamada do metodo de autenticacao caso o modulo seja admin e o usuario
         * caso o usuario nao esteja autenticado na pagina
         * 
         * FLUXO: Plugin_Acl -> Auth_Controller -> Formulario
         */
        
        //if($request->getModuleName() == 'admin' and !Zend_Auth::getInstance()->hasIdentity()){
        if(!Zend_Auth::getInstance()->hasIdentity()){
            //$request->setModuleName('admin');
            $request->setControllerName('/auth');
            $request->setActionName('/login');
        }
    }

}