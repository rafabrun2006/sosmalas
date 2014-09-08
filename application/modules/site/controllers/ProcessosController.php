<?php

/**
 * Description of ProcessosController
 *
 * @author Bruno
 */
class Site_ProcessosController extends Zend_Controller_Action {

    public function indexAction() {
        ;
    }

    public function consultaAction() {
        $this->view->idProcesso = $this->getRequest()->getPost('nu_processo');
        
        if ($this->getRequest()->getPost('nu_processo')) {
            $post = $this->getRequest();

            $revBase = strrev($post->getPost('nu_processo'));
            
            $model = new Application_Model_VwProcessos();
            $result = $model->find(base64_decode($revBase));

            if ($result->count()) {
                $this->view->processo = $result[0];
            } else {
                $this->_helper->flashMessenger(array('danger' => 'Processo não encontrado'));
            }
        } else {
            $this->_helper->flashMessenger(array('danger' => 'Processo não encontrado'));
        }
    }

}
