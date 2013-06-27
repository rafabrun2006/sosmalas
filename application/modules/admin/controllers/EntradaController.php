<?php

class Admin_EntradaController extends Zend_Controller_Action {

    

    public function indexAction() {
        $model = new Application_Model_Coleta();

        $this->view->coleta = $model->fetchAll();
    }

    public function cadastroEntradaAction() {
        $post = $this->_request->getPost();

        $form = new Admin_Form_Entrada();

        if ($this->_request->isPost()) {
            $model = new Application_Model_Entrada();

            if($form->isValid($post)) {
                $id = $model->insert($post);
                /*if ($id) {
                    $this->view->texto = 'Usuario ' . $id . ' inserido com sucesso';
                }*/


                $this->_redirect('/entrada/pesquisar-entrada');
                $this->view->texto = 'Usuario ' . $id . ' inserido com sucesso';
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


    public function editarEntradaAction() {

        $model = new Application_Model_Entrada();
        $result = $model->find($this->_getParam('id'))->toArray();

        $form = new Application_Form_Entrada();

        //echo '<pre>';
        //print_r($result);



        if($this->_request->isPost()) {
            $post=$this->_request->getPost();
            if($form->isValid($post)) {
                $id = $model->edit($post);
            }
        }

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

}