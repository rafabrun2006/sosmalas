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
    
    public function _initSessionNavigationXml(){
        $session = new Zend_Session_Namespace();
        $session->sessionNavigationXml = new Zend_Config_Xml(APPLICATION_PATH . '/configs/navigation.xml');
    }
    
}
