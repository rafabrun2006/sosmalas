<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UtilsController
 *
 * @author Bruno
 */
class Admin_UtilsController extends Zend_Controller_Action {

    public function atualizaVersaoAction() {
        
        $this->view->version = exec("echo (git version)");
        
        if ($this->_request->isPost()) {
            try {
                $shell = exec('git pull origin master', $output, $return);

                echo 'result exec: ' . $shell . '<br><br>';
                echo 'result out: ' . print_r($output, true) . '<br><br>';
                echo 'result retu: ' . $return . '<br><br>';
            } catch (Zend_Exception $e) {
                echo 'ZendException: ' . $e;
            } catch (ErrorException $error) {
                echo 'Error: ' . $error;
            } catch (Exception $ex) {
                echo 'Exception: ' . $ex;
            }
        }

    }

    public function permissaoAction(){
        
        $this->_helper->viewRenderer->setNoRender(true);
        
    }
    
    public function verificaVersaoAction(){
        $result = shell_exec("cd /home/sosmalas/public_html/sistema/sosmalas/; git log -1;");
        $this->_helper->json(array('version' => $result));
    }
    
}