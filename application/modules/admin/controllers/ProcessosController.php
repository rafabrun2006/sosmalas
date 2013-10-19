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
        ;
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
            'id_empresa' => ($txTipoAcesso == 'member') ? $idPessoa : null
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
            $find[0]['dt_coleta'] = SOSMalas_Date::dateToView($find[0]['dt_coleta']);
            $find[0]['dt_entrega'] = SOSMalas_Date::dateToView($find[0]['dt_entrega']);
            $data = $find[0];
        }

        if ($this->_request->isPost()) {
            $post = $this->_request->getPost();

            if ($form->isValid($post)) {
                if ($processosModel->update($post)) {
                    
                    $this->sendMail($post);

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

    public function ajaxPesquisarAction() {
        $this->getHelper('layout')->disableLayout();

        $auth = Zend_Auth::getInstance()->getIdentity();
        $acl = new Zend_Session_Namespace();
        $whereLike = array();
        $where = array();
        $post = $this->_request->getPost();
        unset($post['page']);

        if ($this->_request->isPost()) {
            $post['dt_coleta'] = array_key_exists('dt_coleta', $post) ?
                    SOSMalas_Date::dateToBanco($post['dt_coleta']) : null;
            $post['dt_entrega'] = array_key_exists('dt_entrega', $post) ?
                    SOSMalas_Date::dateToBanco($post['dt_entrega']) : null;

            $post['id_empresa'] = $post['nome_cliente'];
            $post['cod_processo'] = $post['nome_cliente'];

            $whereLike = $post;
        }

        if ($auth->tx_tipo_acesso != SOSMalas_Const::TIPO_USUARIO_ADMIN) {
            $where['id_empresa'] = Zend_Auth::getInstance()->getIdentity()->id_pessoa;
        }

        $modelEntrada = new Application_Model_Processo();

        $paginator = $modelEntrada->getProcessosPagination($where, $whereLike);
        $paginator->setItemCountPerPage(20);
        $paginator->setCurrentPageNumber($this->_getParam('page'));

        $this->view->lastPage = ($paginator->getCurrentPageNumber() > 1) ?
                $paginator->getCurrentPageNumber() - 1 : '#';
        $this->view->nextPage = ($paginator->getCurrentPageNumber() < $paginator->count()) ?
                $paginator->getCurrentPageNumber() + 1 : '#';

        $this->view->editar = $acl->registerRoleResource->isAllowed(
                        $auth->tx_tipo_acesso, 'admin:processos', 'editar') ? true : false;
        $this->view->delete = $acl->registerRoleResource->isAllowed(
                        $auth->tx_tipo_acesso, 'admin:processos', 'delete') ? true : false;

        $this->view->current = $paginator->getCurrentPageNumber();
        $this->view->processos = $paginator;
        $this->view->count = $paginator->count();
        $this->view->paginacao = $this->view->render('processos/paginacao.phtml');
    }

    public function sendMail($post) {
        
        $pessoa = new Application_Model_Pessoa();        
        $find = $pessoa->find($post['id_empresa']);
        $statusProcesso = SOSMalas_Const::getStatusProcesso();
        
        $htmlEmail = '<h3>Registro de Mala</h3>';
        $htmlEmail .= '<br><b>Processo:</b> '.$post['cod_processo'];
        $htmlEmail .= '<br><b>Data Coleta:</b> '.$post['dt_coleta'];
        $htmlEmail .= '<br><b>Data Entrega:</b> '.$post['dt_entrega'];
        $htmlEmail .= '<br><b>Cliente:</b> '.$post['nome_cliente'];
        $htmlEmail .= '<br><b>Status:</b> '.$statusProcesso[$post['status_id']];
        $htmlEmail .= '<br><b>Quantidade:</b> '.$post['quantidade'];
        $htmlEmail .= '<br><b>Prod/Mod/Cor/Marca:</b> '.$post['descricao_produto'];

        $mail = new SOSMalas_Mail('UTF8');
        $mail->setBodyHtml($htmlEmail);
        $mail->setFrom('naoresponda@sosmalas.com.br', 'Sistema SOS Malas');
        $mail->addTo($find[0]->email_pessoa, 'Registro');
        $mail->setSubject('Registro de Mala - SOS Malas');
        $mail->sendEmail();
    }

}
