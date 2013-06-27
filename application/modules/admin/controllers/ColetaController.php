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
                $status = $this->_request->getParam('status');
                $email = $this->_request->getParam('email');

                $config = array('auth' => 'login',
                    'username' => 'rhi.grupo1@gmail.com',
                    'password' => 'fortiumgama',
                    'ssl' => 'ssl',
                    'port' => '465'
                );

                $transport = new Zend_Mail_Transport_Smtp('smtp.gmail.com', $config);

                $mail = new Zend_Mail();
                $mail->setBodyText('Prezado cliente, seu processo de número ' . $os . ' foi cadastrado com sucesso e encontra-se no seguinte status: ' . $status);
                $mail->setFrom('rhi.grupo1@gmail.com', 'Sistema SOS Malas');
                $mail->addTo($email, 'Cliente');
                $mail->setSubject('dentro do if');
                $mail->send($transport);

                if ($os) {
                    $this->view->texto = 'Usuario ' . $os . ' inserido com sucesso';
                    $this->_redirect('/coleta/cadastro-coleta');
                }
            }
        }

        $this->view->form = $form;
    }

    public function deleteAction() {
        $model = new Application_Model_Coleta();

        $os = $model->delete('os = ' . $this->_getParam('os'));

        $this->_redirect('/coleta/pesquisar-coleta');
        $this->view->texto = 'Usuario ' . $id . ' deletado com sucesso!';
    }

    public function editarColetaAction() {

        $model = new Application_Model_Coleta();
        $result = $model->find($this->_getParam('os'))->toArray();

        $form = new Application_Form_Coleta();

        //echo '<pre>';
        //print_r($result);



        if ($this->_request->isPost()) {
            $post = $this->_request->getPost();
            if ($form->isValid($post)) {
                $os = $model->edit($post);
            }
        }

        $form->populate($result[0]);
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