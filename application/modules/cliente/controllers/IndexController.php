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
    }

    public function osAction() {
        $modelColeta = new Application_Model_Coleta();
        $modelStasus = new Application_Model_StatusColeta();

        if ($this->_getParam('hashcod')) {
            $this->view->params = $this->_getAllParams();
            $this->view->statusColeta = array();

            foreach ($modelStasus->fetchAll()->toArray() as $status) {
                $this->view->statusColeta[$status['id_status_coleta']] = $status['nome_status_coleta'];
            }

            $this->view->coleta = $modelColeta->find(base64_decode($this->_getParam('hashcod')));
        } else {
            $this->view->mensagem = "<div class='alert alert-danger'>Erro ao processar o codigo</div>";
        }

        $this->render('/index');
    }

}