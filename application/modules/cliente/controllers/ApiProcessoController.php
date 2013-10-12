<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProcessoController
 *
 * @author Bruno
 */
class Cliente_ApiProcessoController extends Zend_Rest_Controller {

    public function init() {
        parent::init();
        
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
    }

    public function indexAction() {
        echo 'index';
    }

    public function deleteAction() {
        
    }

    public function getAction() {
        
    }

    public function postAction() {
        echo 'post';
    }

    public function putAction() {
        
    }

}
