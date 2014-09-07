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

        $this->view->version = shell_exec("git --version");
        $this->view->currentBranch = shell_exec("git branch | sed -n '/\* /s///p'");

        $arrayBranchNames = array();
        $shellBranchs = shell_exec('git branch -l');
        $branchs = explode(' ', preg_replace('/  /', ' ', $shellBranchs));
        
        foreach ($branchs as $value) {
            if ($value) {
                array_push($arrayBranchNames, trim(str_replace('*', '', $value)));
            }
        }

        $this->view->branchs = $arrayBranchNames;

        if ($this->_request->isPost()) {
            $post = $this->getRequest()->getPost();

            try {
                $shell = shell_exec('git pull origin ' . $post['branch']);

                echo 'result exec: ' . $shell;
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
