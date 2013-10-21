<?php

/**
 * Description of ProcessosController
 *
 * @author Rafael Bruno <rafaelbruno.ti@gmail.com>
 */
class Admin_ProcessosController extends Zend_Controller_Action {

    public function init() {
        ;
    }

    public function pesquisarAction() {
        //Conteudo correspondente em HTML e Ajax
    }

    public function cadastrarAction() {
        $form = new Admin_Form_Processos();

        if ($this->_request->isPost()) {
            $post = $this->_request->getPost();

            if ($form->isValid($post)) {
                $processo = new Application_Model_Processo();
                $insert = $processo->insert($post);
                if ($insert) {
                    //Chamando o processo de envio de email
                    $post['id_processo'] = $insert;
                    $this->enviarEmailProcessoAction($post, true);

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
                $update = $processosModel->update($post);
                if ($update) {
                    //Chamando o processo de envio de email
                    $this->enviarEmailProcessoAction($post);

                    $this->_helper->flashMessenger(array('success' => SOSMalas_Const::MSG01));
                    $this->_redirect('/admin/processos/pesquisar');
                } else {
                    print_r($update);
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

    public function enviarEmailProcessoAction($post = array(), $insertId = false) {
        if ($post) {
            $pessoa = new Application_Model_Pessoa();
            $modelHistProc = new Application_Model_HistoricoProcesso();
            
            $find = $pessoa->find($post['id_empresa']);
            $statusProcesso = SOSMalas_Const::getStatusProcesso();
            $historico = $modelHistProc->findByProcesso($post['id_processo']);

            $this->view->apresentacao = $insertId ?
                    SOSMalas_Const::APRESENTACAO_EMAIL_ATUALIZA :
                    SOSMalas_Const::APRESENTACAO_EMAIL_NOVO;

            $this->view->cod_processo = $post['cod_processo'];
            $this->view->dt_coleta = $post['dt_coleta'];
            $this->view->dt_entrega = $post['dt_entrega'];
            $this->view->nome_cliente = $post['nome_cliente'];
            $this->view->status = $statusProcesso[$post['status_id']];
            $this->view->quantidade = $post['quantidade'];
            $this->view->descricao_produto = $post['descricao_produto'];
            $this->view->nome_contato = $find[0]->nome_contato;
            $this->view->nome_empresa = $find[0]->nome_empresa;
            $this->view->historico = $historico;

            $mail = new SOSMalas_Mail('UTF8');
            $mail->setBodyHtml($this->view->render('/processos/enviar-email-processo.phtml'));
            $mail->setFrom('naoresponda@sosmalas.com.br', 'Sistema SOS Malas');
            $mail->addTo($find[0]->email, 'Registro');
            $mail->setSubject('Registro de Processo - SOS Malas');
            if (!$mail->sendEmail()) {
                $this->_helper->_flashMessenger(array('error' => SOSMalas_Const::MSG05));
            } else {
                $this->_helper->_flashMessenger(array('success' => SOSMalas_Const::MSG06));
            }
        }
    }

    public function detalhesAction() {
        $model = new Application_Model_Processo();
        $modelPessoa = new Application_Model_Pessoa();
        $modelHistProc = new Application_Model_HistoricoProcesso();
        
        $processo = $model->find($this->_getParam('id'));
        $status = SOSMalas_Const::getStatusProcesso();
        $pessoa = $modelPessoa->find($processo[0]->id_empresa);
        $historico = $modelHistProc->findByProcesso($processo[0]->id_processo);
        
        $this->view->processo = $processo[0];
        $this->view->processo->dt_coleta = SOSMalas_Date::dateToView($processo[0]->dt_coleta);
        $this->view->processo->dt_entrega = SOSMalas_Date::dateToView($processo[0]->dt_entrega);
        $this->view->status = $status[$processo[0]->status_id];
        $this->view->nome_parceiro = $pessoa[0]->nome_empresa;
        $this->view->nome_contato = $pessoa[0]->nome_contato;
        $this->view->historico = $historico;
        
        $this->render('detalhes');
        $this->render('historico-processo');
    }

}
