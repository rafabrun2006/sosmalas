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

        $method = $auth->tx_tipo_acesso . '-pesquisar';

        $this->getResponse()->setRedirect($method);
    }

    public function memberPesquisarAction() {
        $modelEntrada = new Application_Model_Processo();

        $where = array(
            'pessoa_entrada' => Zend_Auth::getInstance()->getIdentity()->id_pessoa
        );

        $this->view->processos = $modelEntrada->getProcessos($where);
        $this->render('pesquisar');
    }

    public function adminPesquisarAction() {
        $modelEntrada = new Application_Model_Processo();

        $this->view->processos = $modelEntrada->getProcessos(array());

        $this->render('pesquisar');
    }

    public function cadastrarAction() {
        $form = new Admin_Form_Processos();

        if ($this->_request->isPost()) {
            $post = $this->_request->getPost();

            if ($form->isValid($post)) {
                $processo = new Application_Model_Processo();
                if($processo->insert($post)){
                    $this->_helper->flashMessenger(array('success' => SOSMalas_Const::MSG01));
                    $this->_redirect('/admin/processos/pesquisar');
                }else{
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
    
    public function ajaxSearchProcessoAction(){
        $modelc = new Application_Model_Processo();
        $idPessoa = Zend_Auth::getInstance()->getIdentity()->id_pessoa;
        $txTipoAcesso = Zend_Auth::getInstance()->getIdentity()->tx_tipo_acesso;
        
        $whereAnd = array(
          'pessoa_entrada' => ($txTipoAcesso == 'member') ? $idPessoa : null
        );
        
        $result = $modelc->searchLikeFields(array(), $this->_getParam('search'), $whereAnd)->toArray();
        
        $this->_helper->json($result);
    }

}