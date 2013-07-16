<?php

class Admin_ColetaController extends Zend_Controller_Action {

    public function indexAction() {
        $model = new Application_Model_Coleta();

        $this->view->coleta = $model->fetchAll();
    }

    public function cadastroColetaAction() {
        $form = new Admin_Form_Coleta();

        if ($this->_request->isPost()) {
            $post = $this->_request->getPost();

            $model = new Application_Model_Coleta();

            if ($form->isValid($post)) {
                try {
                    $os = $model->insert($post);

                    $htmlEmail = 'Prezado cliente, seu processo de número ' .
                            $os . ' foi cadastrado com sucesso <br> caso queira consulta-la ' .
                            'acesse o link http://sistema.sosmalas.com.br/index/os/hashcod/' . base64_encode($os);

                    $mail = new SOSMalas_Mail('UTF8');
                    $mail->setBodyHtml($htmlEmail);
                    $mail->setFrom('naoresponda@sosmalas.com.br', 'Sistema SOS Malas');
                    $mail->addTo($post['cliente_email'], 'Cliente');
                    $mail->setSubject('Registro de Coleta - SOS Malas');
                    if ($mail->sendEmail()) {
                        $this->_helper->flashMessenger(array('success' => 'Coleta registrada com sucesso, um email foi enviado para ' . $pessoa[0]->email_pessoa));
                        $this->_redirect('/admin/coleta/pesquisar-coleta');
                    }
                } catch (Exception $e) {
                    $this->_helper->flashMessenger(array('danger' => $e));
                }
            } else {
                $this->_helper->flashMessenger(array('danger' => SOSMalas_Const::MSG03));
            }
        }

        $this->view->form = $form;
    }

    public function deleteAction() {
        $model = new Application_Model_Coleta();

        $model->delete(array('os_coleta' => $this->_getParam('os_coleta')));

        $this->_redirect('/admin/coleta/pesquisar-coleta');
    }

    public function editarAction() {

        $model = new Application_Model_Coleta();
        $getArray = $model->getArrayById($this->_getParam('os_coleta'));
        $result = $getArray[0];

        $result['previsao_coleta'] = SOSMalas_Date::dateToView($result['previsao_coleta']);
        $result['data_pedido_coleta'] = SOSMalas_Date::dateToView($result['data_pedido_coleta']);

        $form = new Admin_Form_Coleta();

        if ($this->_request->isPost()) {
            $post = $this->_request->getPost();
            if ($form->isValid($post)) {
                if($model->update($post)){
                    $this->_helper->flashMessenger(array('success'=>  SOSMalas_Const::MSG01));
                    $this->_redirect('/admin/coleta/pesquisar-coleta');
                }else{
                    $this->_helper->flashMessenger(array('danger'=>  SOSMalas_Const::MSG02));
                }
            }

            $form->populate($post);
        } else {
            $form->populate($result);
        }

        $this->view->form = $form;
    }

    public function pesquisarColetaAction() {
        $modelc = new Application_Model_Coleta();
        $modelStasus = new Application_Model_StatusColeta();

        $this->view->statusColeta = array();

        foreach ($modelStasus->fetchAll()->toArray() as $status) {
            $this->view->statusColeta[$status['id_status_coleta']] = $status['nome_status_coleta'];
        }

        $this->view->listColeta = $modelc
                ->listColeta($this->_request->getPost());
    }

    public function consultarStatusAction() {
        $modelc = new Application_Model_Coleta();

        $this->view->listColeta = $modelc
                ->listColeta($this->_request->getPost());
    }

    public function ajaxSearchColetaAction(){
        $modelc = new Application_Model_Coleta();
        
        $result = $modelc->listColeta(array('os_coleta' => $this->_getParam('os_coleta')))->toArray();
        
        return $this->_helper->json($result);
    }
}