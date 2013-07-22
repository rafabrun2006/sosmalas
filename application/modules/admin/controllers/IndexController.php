<?php

class Admin_IndexController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {
        // action body
    }

    public function informationAction() {
        
        $msg = $this->_getParam('MSG_SIS');
        
        switch ($msg[0]) {
            case 'ERROR':
                $this->_helper->flashMessenger(array('danger'=>$msg[1]));
                break;
        }
    }

}

