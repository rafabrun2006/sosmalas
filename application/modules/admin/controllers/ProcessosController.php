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
    
    public function pesquisarAction(){
        $auth = Zend_Auth::getInstance()->getIdentity();
        
        $method = $auth->tx_tipo_acesso.'-pesquisar';
        
        $this->getResponse()->setRedirect($method);
    }
    
    public function memberPesquisarAction(){
        $modelEntrada = new Application_Model_Entrada();
        
        $where = array(
            'empresa_entrada' => Zend_Auth::getInstance()->getIdentity()->id_pessoa
        );
        
        $this->view->processos = $modelEntrada->getProcessos($where);
        $this->render('pesquisar');
    }
    
    public function adminPesquisarAction(){
        $modelEntrada = new Application_Model_Entrada();
        
        $this->view->processos = $modelEntrada->getProcessos(array());
        
        $this->render('pesquisar');
    }
}