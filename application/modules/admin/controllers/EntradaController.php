<?php

class Admin_EntradaController extends Zend_Controller_Action {

    public function indexAction() {
        $model = new Application_Model_Coleta();

        $this->view->coleta = $model->fetchAll();
    }

    public function cadastroAction() {
        $post = $this->_request->getPost();

        $form = new Admin_Form_Entrada();

        if ($this->_request->isPost()) {
            $model = new Application_Model_Entrada();

            if ($form->isValid($post)) {
                if ($model->insert($post)) {
                    $this->_helper->flashMessenger(array('success' => SOSMalas_Const::MSG01));
                    $this->_redirect('/entrada/pesquisar-entrada');
                }
            } else {
                $this->_helper->flashMessenger(array('success' => SOSMalas_Const::MSG01));
            }
        }

        $this->view->form = $form;
    }

    public function deleteAction() {
        $model = new Application_Model_Entrada();

        $id = $model->delete('id = ' . $this->_getParam('id'));

        $this->_redirect('/entrada/pesquisar-entrada');
        //$this->view->texto = 'Usuario ' . $id . ' deletado com sucesso!';
    }

    public function editarAction() {

        $model = new Application_Model_Entrada();
        $result = $model->find($this->_getParam('id'))->toArray();

        $form = new Admin_Form_Entrada();

        if ($this->_request->isPost()) {
            $post = $this->_request->getPost();
            if ($form->isValid($post)) {
                if ($model->update($post)) {
                    $this->_helper->flashMessenger(array('success' => SOSMalas_Const::MSG01));
                    $this->_redirect('/admin/entrada/pesquisar-entrada');
                }
            } else {
                $this->_helper->flashMessenger(array('danger' => SOSMalas_Const::MSG02));
            }
        }
        
        $result[0]['data_entrada'] = SOSMalas_Date::dateToView($result[0]['data_entrada']);
        $result[0]['data_conclusao_entrada'] = SOSMalas_Date::dateToView($result[0]['data_conclusao_entrada']);
        $result[0]['data_entrega_entrada'] = SOSMalas_Date::dateToView($result[0]['data_entrega_entrada']);
        $result[0]['data_previsao_entrada'] = SOSMalas_Date::dateToView($result[0]['data_previsao_entrada']);
        
        $form->populate($result[0]);
        $this->view->form = $form;
    }

    public function pesquisarEntradaAction() {
        $modelc = new Application_Model_Entrada();

        $this->view->listEntrada = $modelc
                ->listEntrada($this->_request->getPost());
    }

    public function consultarStatusAction() {
        $modelc = new Application_Model_Entrada();

        $this->view->listColeta = $modelc
                ->listEntrada($this->_request->getPost());
    }

    public function ajaxSearchEntradaAction(){
        $modelc = new Application_Model_Entrada();

        $result = $modelc->searchLikeFields(array(), $this->_getParam('search'))->toArray();
        
        $this->_helper->json($result);
    }
    
}