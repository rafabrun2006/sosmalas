<?php

class Admin_MarcaController extends Zend_Rest_Controller {

    public function indexAction() {
        $model = new Application_Model_Marca();
        $this->_helper->json($model->fetchAll()->toArray());
    }

    public function deleteAction() {
        
    }

    public function getAction() {
        
    }

    public function postAction() {
        $post = Zend_Json::decode($this->getRequest()->getRawBody());
        $model = new Application_Model_Marca();
        $id = $model->insert($post);
        $result = $model->find($id)->current()->toArray();
        
        $this->_helper->json($result);
    }

    public function putAction() {
        
    }

}