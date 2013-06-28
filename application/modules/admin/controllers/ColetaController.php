<?php

class Admin_ColetaController extends Zend_Controller_Action {

    public function indexAction() {
        $model = new Application_Model_Coleta();

        $this->view->coleta = $model->fetchAll();
    }

    public function cadastroColetaAction() {
        $post = $this->_request->getPost();

        $form = new Admin_Form_Coleta();

        if ($this->_request->isPost()) {
            $model = new Application_Model_Coleta();

            if ($form->isValid($post)) {
                $os = $model->insert($post);
                $status = $post['status_coleta'];

                $mail = new SOSMalas_Mail();
                $mail->setBodyText('Prezado cliente, seu processo de número ' . $os . ' foi cadastrado com sucesso e encontra-se no seguinte status: ' . $status);
                $mail->setFrom('rhi.grupo1@gmail.com', 'Sistema SOS Malas');
                $mail->addTo('rafabrun2006@gmail.com', 'Cliente');
                $mail->setSubject('subject');
                $mail->sendEmail();
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
                $model->update($post);
            }

            $form->populate($post);
        } else {
            $form->populate($result);
        }

        $this->view->form = $form;
    }

    public function pesquisarColetaAction() {
        $modelc = new Application_Model_Coleta();

        $this->view->listColeta = $modelc
                ->listColeta($this->_request->getPost());
    }

    public function consultarStatusAction() {
        $modelc = new Application_Model_Coleta();

        $this->view->listColeta = $modelc
                ->listColeta($this->_request->getPost());
    }

}