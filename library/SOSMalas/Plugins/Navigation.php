<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Navigation
 *
 * @author Bruno
 */
class SOSMalas_Plugins_Navigation extends Zend_Controller_Plugin_Abstract {

    public function dispatchLoopStartup(\Zend_Controller_Request_Abstract $request) {
        $session = new Zend_Session_Namespace();
        
        if (Zend_Auth::getInstance()->hasIdentity()) {

            if (!$session->registerRoleResource) {
                $session->registerRoleResource = new SOSMalas_Acl_RegisterRoleResource($request);
                $session->privileges = $session->registerRoleResource->getPrivileges();
            }
            
            Zend_Registry::set('acl', $session->registerRoleResource);
            
            $role = Zend_Auth::getInstance()->getIdentity()->tipo_acesso_id;
            $resource = $request->getModuleName() . ':' . $request->getControllerName();
            $action = $request->getActionName();

            if (!$session->registerRoleResource->isAllowed($role, $resource, $action)) {
                $request->setControllerName('index');
                $request->setActionName('information');
                $request->setParam('MSG_SIS', array('ERROR', SOSMalas_Const::MSG_SIS01));
            }

        }
    }

}