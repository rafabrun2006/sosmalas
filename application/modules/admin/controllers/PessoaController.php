<?php

class Admin_PessoaController extends Zend_Controller_Action {

    public function indexAction() {
        $model = new Application_Model_Pessoa();

        $this->view->pessoa = $model->fetchAll();
    }

    public function cadastroPessoaAction() {
        $post = $this->_request->getPost();

        $form = new Admin_Form_Pessoa();

        if ($this->_request->isPost()) {
            $model = new Application_Model_Pessoa();

            if ($form->isValid($post)) {
                $id = $model->insert($post);
                $this->_redirect('/pessoa/pesquisar-pessoa');
                $this->view->texto = 'Usuario ' . $id . ' inserido com sucesso';
            }
        }

        $this->view->form = $form;
    }

    public function deleteAction() {
        $model = new Application_Model_Pessoa();

        $id = $model->delete('id = ' . $this->_getParam('id'));

        $this->_redirect('/pessoa/pesquisar-pessoa');
        $this->view->texto = 'Usuario ' . $id . ' deletado com sucesso!';
    }

    public function editarPessoaAction() {
        
        $model = new Application_Model_Pessoa();
        $result = $model->find($this->_getParam('id'))->toArray();
        
        $form = new Admin_Form_Pessoa();

        if ($this->_request->isPost()) {
            $post = $this->_request->getPost();
            if ($form->isValid($post)) {
                $id = $model->edit($post);
            }
        }

        $form->populate($result[0]);
        $this->view->form = $form;
    }

    public function pesquisarPessoaAction() {
        $model = new Application_Model_Pessoa();

        $this->view->listPessoa = $model
                ->listPessoa($this->_request->getPost());
    }
    
    public function cadastroAction(){
        $form = new Admin_Form_Pessoa();
        
        $post = $this->_request->getPost();

        if ($this->_request->isPost()) {
            $model = new Application_Model_Pessoa();

            if ($form->isValid($post)) {
                $id = $model->insert($post);
                $this->_redirect('/admin/pessoa/pesquisar-pessoa');
                $this->view->texto = 'Usuario ' . $id . ' inserido com sucesso';
            }
        }
        
        $this->view->form = $form;
    }
    
    public function editarAction(){
        $form = new Admin_Form_Pessoa();
        
        $this->view->form = $form;
    }

}