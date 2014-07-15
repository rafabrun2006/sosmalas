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

    public function permissaoAction() {

        $this->_helper->viewRenderer->setNoRender(true);
    }

    public function verificaVersaoAction() {
        $result[] = shell_exec('git-sh; pull origin master;');

        $this->_helper->json(array('version' => $result));
    }

    public function checkoutAlteracaoAction() {
        if ($this->getRequest()->getParam('cmd')) {
            echo '<pre>';
            echo 'cmd: ' . $this->getRequest()->getParam('cmd');
            $shell = exec($this->getRequest()->getParam('cmd'));
            print_r($shell);
            echo '</pre>';
        }
        
        exit('the end...');
    }

}
