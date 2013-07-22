<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Acl
 *
 * @author Bruno
 */
class SOSMalas_Acl_RegisterRoleResource extends Zend_Acl {

    public $roles = array();
    public $admin = array();
    public $request;

    public function __construct(Zend_Controller_Request_Abstract $request) {

        $xmlNav = new Zend_Config_Xml(APPLICATION_PATH . '/configs/navigation.xml');
        $arrayNav = $xmlNav->toArray();

        $this->roles = $arrayNav['roles'];
        $this->admin = $arrayNav['admin'];
        $this->request = $request;

        $this->initRegisterRoles();
        $this->initRegisterResources();
        
        $this->allow('member', 'admin:index');
        $this->allow('member', 'admin:coleta', array('pesquisar-coleta'));
        $this->allow('member', 'admin:entrada', array('pesquisar-entrada'));
        $this->allow('member', 'admin:auth', array('login', 'logout'));
        $this->allow('member', 'admin:processos', array('pesquisar', 'member-pesquisar'));
        
        $this->allow('admin');
        
        return $this;
    }

    public function initRegisterRoles() {
        foreach ($this->roles as $role => $value) {
            //adicionando as regras
            $this->addRole(new Zend_Acl_Role($role), $value['parent'] ? $value['parent'] : null);
        }
    }

    public function initRegisterResources() {

        foreach ($this->admin as $params) {
            $controller = $params['controller'];
            $module = $params['module'];

            $resource = $module . ':' . $controller;
            $this->add(new Zend_Acl_Resource($resource));
        }
    }

}