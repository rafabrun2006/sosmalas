<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProcessosController
 *
 * @author Bruno
 */
class Admin_ProcessosController extends Zend_Controller_Action {

    public function init() {
        ;
    }

    public function pesquisarAction() {
        $auth = Zend_Auth::getInstance()->getIdentity();
        $acl = new Zend_Session_Namespace();
        $where = array();
        $post = $this->_request->getPost();
        
        if($this->_request->isPost() and !empty($post['id_processo'])){
            $where['id_processo'] = $post['id_processo'];
        }
        
        if ($auth->tx_tipo_acesso != SOSMalas_Const::TIPO_USUARIO_ADMIN) {
            $where['pessoa_entrada'] = Zend_Auth::getInstance()->getIdentity()->id_pessoa;
        }

        $modelEntrada = new Application_Model_Processo();

        $paginator = $modelEntrada->getProcessosPagination($where);
        $paginator->setItemCountPerPage(20);
        $paginator->setCurrentPageNumber($this->_getParam('page'));
        
        $i = 1;
        $page = array();

        while ($i <= $paginator->count()) {
            $active = $paginator->getCurrentPageNumber() == $i ? 'active' : '';
            $page[] = array('number' => $i, 'active' => $active);
            $i++;
        }

        $this->view->lastPage = ($paginator->getCurrentPageNumber() > 1) ?
                $paginator->getCurrentPageNumber() - 1 : '#';
        $this->view->nextPage = ($paginator->getCurrentPageNumber() < $paginator->count()) ?
                $paginator->getCurrentPageNumber() + 1 : '#';
        $this->view->page = $page;

        $this->view->editar = $acl->registerRoleResource->isAllowed(
                $auth->tx_tipo_acesso, 'admin:processos', 'editar') ? true:false;
        $this->view->delete = $acl->registerRoleResource->isAllowed(
                $auth->tx_tipo_acesso, 'admin:processos', 'delete') ? true:false;
        
        $this->view->current = $paginator->getCurrentPageNumber();
        $this->view->processos = $paginator;
        $this->view->paginacao = $this->view->render('processos/paginacao.phtml');
    }

    public function cadastrarAction() {
        $form = new Admin_Form_Processos();

        if ($this->_request->isPost()) {
            $post = $this->_request->getPost();

            if ($form->isValid($post)) {
                $processo = new Application_Model_Processo();
                if ($processo->insert($post)) {
                    $this->_helper->flashMessenger(array('success' => SOSMalas_Const::MSG01));
                    $this->_redirect('/admin/processos/pesquisar');
                } else {
                    $this->_helper->flashMessenger(array('danger' => SOSMalas_Const::MSG02));
                }
            } else {
                $this->_helper->flashMessenger(array('warning' => SOSMalas_Const::MSG03));
                $this->_redirect('/admin/processos/pesquisar');
            }
            $form->populate($post);
        }

        $this->view->form = $form;
    }

    public function ajaxSearchProcessoAction() {
        $modelc = new Application_Model_Processo();
        $idPessoa = Zend_Auth::getInstance()->getIdentity()->id_pessoa;
        $txTipoAcesso = Zend_Auth::getInstance()->getIdentity()->tx_tipo_acesso;

        $whereAnd = array(
            'pessoa_entrada' => ($txTipoAcesso == 'member') ? $idPessoa : null
        );

        $result = $modelc->searchLikeFields(array(), $this->_getParam('search'), $whereAnd)->toArray();

        $this->_helper->json($result);
    }

    public function editarAction() {
        $form = new Admin_Form_Processos();
        $processosModel = new Application_Model_Processo();
        $data = array();

        if ($this->_getParam('id')) {
            $find = $processosModel->find($this->_getParam('id'))->toArray();
            $find[0]['data_coleta_processo'] = SOSMalas_Date::dateToView($find[0]['data_coleta_processo']);
            $find[0]['data_entrega_processo'] = SOSMalas_Date::dateToView($find[0]['data_entrega_processo']);
            $data = $find[0];
        }

        if ($this->_request->isPost()) {
            $post = $this->_request->getPost();

            if ($form->isValid($post)) {
                if ($processosModel->update($post)) {
                    $this->_helper->flashMessenger(array('success' => SOSMalas_Const::MSG01));
                    $this->_redirect('/admin/processos/pesquisar');
                } else {
                    $this->_helper->flashMessenger(array('danger' => SOSMalas_Const::MSG02));
                }
            } else {
                $this->_helper->flashMessenger(array('alert' => SOSMalas_Const::MSG03));
            }

            $data = $post;
        }

        $form->populate($data);
        $this->view->form = $form;
    }

    public function deleteAction() {

        if ($this->_getParam('id')) {
            $processoModel = new Application_Model_Processo();

            if ($processoModel->delete(array('id_processo' => $this->_getParam('id')))) {
                $this->_helper->flashMessenger(array('success' => SOSMalas_Const::MSG01));
                $this->_redirect('/admin/processos/pesquisar');
            } else {
                $this->_helper->flashMessenger(array('danger' => SOSMalas_Const::MSG02));
            }
        }
    }

}