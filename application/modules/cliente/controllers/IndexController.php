<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of IndexController
 *
 * @author Bruno
 */
class Cliente_IndexController extends Zend_Controller_Action {

    public function indexAction() {
        $this->view->params = $this->_getAllParams();
        $this->view->js = $this->view->render('index/backbone.js');
    }

    public function osAction() {
        $modelColeta = new Application_Model_Processo();

        if ($this->_getParam('hashcod')) {
            $this->view->hashcod = $this->getRequest()->getParam('hashcod');
            
            $where = 'id_processo = ' . $this->_getParam('hashcod');
            
            $this->view->coleta = $modelColeta->fetchAll($where);
        } else {
            $this->view->mensagem = "<div class='alert alert-danger'>Erro ao processar o codigo</div>";
        }

        $this->render('/index');
    }

}
