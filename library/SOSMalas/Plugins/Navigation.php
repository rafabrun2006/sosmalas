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

        if (Zend_Auth::getInstance()->hasIdentity()) {
            $registerRoleResource = new SOSMalas_Acl_RegisterRoleResource($request);

            $role = Zend_Auth::getInstance()->getIdentity()->tx_tipo_acesso;
            $resource = $request->getModuleName() . ':' . $request->getControllerName();
            $action = $request->getActionName();

            if (!$registerRoleResource->isAllowed($role, $resource, $action)) {
                $request->setControllerName('index');
                $request->setActionName('information');
                $request->setParam('MSG_SIS', array('ERROR', SOSMalas_Const::MSG_SIS01));
            }
        }
    }

}