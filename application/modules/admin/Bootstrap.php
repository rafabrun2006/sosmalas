<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Bootstrap
 *
 * @author bruno
 */
class Admin_Bootstrap extends Zend_Application_Module_Bootstrap {

    public function _initConfig(){
        //Registrando ambiente
        Zend_Registry::set('environment', $this->getEnvironment());
    }
    
    public function _initSessionNavigationXml() {
//        $session = new Zend_Session_Namespace();
//        
//        $navigationMenu = new SOSMalas_NavigationMenu();
//        $navigationMenu->setModule($this->getModuleName());
//        $navigationMenu->mountMenu();
//        
//        die;
//        Zend_Registry::set('menu', $session->menuAdmin);
    }

}