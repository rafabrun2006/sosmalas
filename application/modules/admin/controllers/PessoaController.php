<?php

class Admin_PessoaController extends Zend_Controller_Action {

    public function indexAction() {
        $model = new Application_Model_Pessoa();

        $this->view->listPessoa = $model
                ->listPessoa($this->_request->getPost());
    }

    public function cadastroPessoaAction() {
        $post = $this->_request->getPost();

        $form = new Admin_Form_Pessoa();

        if ($this->_request->isPost()) {
            $model = new Application_Model_Pessoa();

            if ($form->isValid($post)) {
                $model->insert($post);
                $this->_helper->flashMessenger(array('sucess' => SOSMalas_Const::MSG02));
                $this->_redirect('/pessoa/pesquisar-pessoa');
            } else {
                $this->_helper->flashMessenger(array('sucess' => SOSMalas_Const::MSG03));
            }
        }

        $this->view->form = $form;
    }

    public function deleteAction() {
        $model = new Application_Model_Pessoa();

        if ($model->delete(array('id_pessoa' => $this->_getParam('id_pessoa')))) {
            $this->_helper->flashMessenger(array('success' => SOSMalas_Const::MSG01));
            $this->_redirect('/admin/pessoa');
        } else {
            $this->_helper->flashMessenger(array('success' => SOSMalas_Const::MSG02));
        }
    }

    public function editarAction() {

        $model = new Application_Model_Pessoa();
        $result = $model->find($this->_getParam('id_pessoa'))->toArray();

        $form = new Admin_Form_Pessoa();

        if ($this->_request->isPost()) {
            $post = $this->_request->getPost();
            if ($form->isValid($post)) {
                $model->update($post);
                $this->_helper->flashMessenger(array('success' => SOSMalas_Const::MSG01));
                $this->_redirect('/admin/pessoa');
            } else {
                $this->_helper->flashMessenger(array('danger' => SOSMalas_Const::MSG03));
            }

            $form->populate($post);
        } else {
            $form->populate($result[0]);
        }

        $this->view->form = $form;
    }

    public function cadastroAction() {
        $form = new Admin_Form_Pessoa();

        $post = $this->_request->getPost();

        if ($this->_request->isPost()) {
            $model = new Application_Model_Pessoa();

            if ($form->isValid($post)) {
                $id = $model->insert($post);
                $this->_redirect('/admin/pessoa');
                $this->_helper->flashMessenger(array('success' => SOSMalas_Const::MSG01));
            }
        }

        $this->view->form = $form;
    }

    public function ajaxSearchPersonAction() {
        $model = new Application_Model_Pessoa();

        return $this->_helper->json($model->searchPerson($this->_request->getPost()));
    }

    public function jsAction() {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        echo $this->view->render('pessoa/pessoa.js');
    }

    public function getAction() {
        $model = new Application_Model_Pessoa();

        $result = $model->listPessoa($this->_request->getPost());

        $this->_helper->json($result->toArray());
    }

    public function datagridAction() {
        ;
    }

    public function dataJsAction() {
        $model = new Application_Model_Pessoa();
        $post = array();

        if ($this->getRequest()->isPost()) {
            $request = $this->getRequest()->getRawBody();
            $post = Zend_Json_Decoder::decode($request);
        }
        
        $array = $model->listPessoa($post)->toArray();
        $this->_helper->json($array);
    }

    public function datagridjsAction() {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        echo $this->view->render('/pessoa/datagrid.js');
    }

}
