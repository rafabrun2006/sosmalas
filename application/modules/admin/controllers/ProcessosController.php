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

    /**
     * @uses AngularJS
     * Metodo que carrega pagina de processos e lista de processos existentes
     */
    public function indexAction() {
        //Conteudo correspondente em HTML e Ajax

        $pessoa = new Application_Model_Pessoa();

        $this->view->form = new Admin_Form_Processos();
        $this->view->parceiros = $pessoa->fetchAll();

        $this->view->user = Zend_Auth::getInstance()->getIdentity();
        $this->view->acl = Zend_Registry::get('acl');

        $this->view->formTemplate = $this->view->render('processos/form-template.phtml');
        $this->view->listarTemplate = $this->view->render('processos/listar-template.phtml');
    }

    public function ajaxProcessosAction() {
        $model = new Application_Model_VwProcessos();
        $where = array();
        $logged = Zend_Auth::getInstance()->getIdentity();

        if (!in_array($logged->tipo_acesso_id, array(SOSMalas_Const::TIPO_USUARIO_ADMIN, SOSMalas_Const::TIPO_USUARIO_MEMBER))) {
            $where['id_empresa'] = $logged->id_pessoa;
        }

        $this->_helper->json($model->findVwProcessos($where)->toArray());
    }

    public function ajaxGetProcessoByIdAction() {
        $model = new Application_Model_VwProcessos();
        $result = $model->findVwProcessosById($this->getRequest()->getParam('id'));
        $toArray = $result->toArray();
        $this->_helper->json($toArray[0]);
    }

    public function saveAction() {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();

        $form = new Admin_Form_Processos();
        $processosModel = new Application_Model_Processo();

        $post = Zend_Json::decode($this->getRequest()->getRawBody());
        $post['pessoa_cadastro_id'] = Zend_Auth::getInstance()->getIdentity()->id_pessoa;

        if ($this->_request->isPost()) {

            if ($form->isValid($post)) {
                $isUpdate = array_key_exists('id_processo', $post) ? TRUE : FALSE;

                $post['id_processo'] = $processosModel->save($post);

                //Chamando o processo de envio de email
                $model = new Application_Model_VwProcessos();

                if ($isUpdate && $post['status_id'] == SOSMalas_Const::STATUS_PROCESSO_FINALIZADO) {
                    $this->enviarEmailProcessoAction($post);
                }

                if (!$isUpdate && $post['status_id'] == SOSMalas_Const::STATUS_PROCESSO_EM_CONSERTO) {
                    $this->enviarEmailProcessoAction($post, TRUE);
                }

                $result = $model->find($post['id_processo'])->toArray();

                $this->_helper->json(array(
                    'model' => $result[0],
                    'result' => TRUE,
                    'messages' => SOSMalas_Const::MSG01)
                );
            } else {
                $result = array('result' => FALSE, 'messages' => $form->getMessages(), 'model' => $post);
                $this->_helper->json($result);
            }
        }
    }

    public function deleteAction() {

        if ($this->_getParam('id_processo')) {
            $processoModel = new Application_Model_Processo();

            if ($processoModel->delete(array('id_processo' => $this->_getParam('id_processo')))) {
                $this->_helper->json(array('result' => 'success'));
            } else {
                $this->_helper->json(array('result' => 'error'));
            }
        }
    }

    public function enviarEmailProcessoAction($post = array(), $insertId = false) {
        if ($post) {
            $pessoa = new Application_Model_Pessoa();
            $find = $pessoa->find($post['id_empresa']);

            if ($find[0]->recebe_notificacao) {
                $modelHistProc = new Application_Model_HistoricoProcesso();
                $statusProcesso = SOSMalas_Const::getStatusProcesso();
                $localColEnt = SOSMalas_Const::getLocalEntregaColeta();
                $historico = $modelHistProc->findByProcesso($post['id_processo']);

                $texto_apresentacao = $insertId ?
                        SOSMalas_Const::APRESENTACAO_EMAIL_NOVO :
                        SOSMalas_Const::APRESENTACAO_EMAIL_ATUALIZA;

                if (array_key_exists('local_coleta_id', $post)) {
                    $this->view->local_coleta = $localColEnt[$post['local_coleta_id']];
                }
                if (array_key_exists('local_entrega_id', $post)) {
                    $this->view->local_entrega = $localColEnt[$post['local_entrega_id']];
                }

                $this->view->cod_processo = $post['cod_processo'];
                $this->view->dt_coleta = array_key_exists('dt_coleta', $post) ? $post['dt_coleta'] : NULL;
                $this->view->dt_entrega = array_key_exists('dt_entrega', $post) ? $post['dt_entrega'] : NULL;
                $this->view->nome_cliente = array_key_exists('nome_cliente', $post) ? $post['nome_cliente'] : NULL;
                $this->view->status = $statusProcesso[$post['status_id']];
                $this->view->quantidade = $post['quantidade'];
                $this->view->descricao_produto = array_key_exists('descricao_produto', $post) ? $post['descricao_produto'] : NULL;
                $this->view->nome_contato = $find[0]->nome_contato;
                $this->view->nome_empresa = $find[0]->nome_empresa;
                $this->view->historico = $historico;

                $mail = new SOSMalas_Mail('UTF8');
                $mail->setBodyHtml($this->view->render('/processos/enviar-email-processo.phtml'));
                $mail->setFrom('naoresponda@sosmalas.com.br', sprintf($texto_apresentacao, $post['cod_processo']));
                $mail->addBcc('naoresponda@sosmalas.com.br');
                $mail->addTo($find[0]->email, $find[0]->nome_contato);
                $mail->setSubject('Processo ' . $post['cod_processo'] . ' - SOS Malas');

                $mail->sendEmail();
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

    /**
     * @uses AngularJS
     * Metodo que retorna json de historico de um processo
     */
    public function findHistoricoProcessoAction() {
        $modelHistProc = new Application_Model_HistoricoProcesso();
        $this->_helper->json($modelHistProc->findByProcesso($this->_getParam('id'))->toArray());
    }

    /**
     * Metodo responsavel por inserir historico em um processo
     * @uses AngularJS
     */
    public function saveHistoricoProcessoAction() {
        $modelHistProc = new Application_Model_HistoricoProcesso();
        $json = $this->getRequest()->getRawBody();
        $data = Zend_Json_Decoder::decode($json);
        $processo_id = $modelHistProc->insert($data);

        $result = $modelHistProc->find($processo_id)->toArray();

        $this->_helper->json($result[0]);
    }

}
