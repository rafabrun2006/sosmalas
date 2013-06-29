<?php

class Zend_View_Helper_FlashMessenger extends Zend_View_Helper_Abstract {

    /**
     * @var Zend_Controller_Action_Helper_FlashMessenger
     */
    private $_flashMessenger = null;

    public function flashMessenger($key = 'warning', $template = NULL) {

        $template = '<div class="alert alert-%s">%s</div>';

        $flashMessenger = $this->_getFlashMessenger();

        //get messages from previous requests
        $messages = $flashMessenger->getMessages();

        //add any messages from this request
        if ($flashMessenger->hasCurrentMessages()) {
            $messages = array_merge(
                    $messages, $flashMessenger->getCurrentMessages()
            );
            //we don't need to display them twice.
            $flashMessenger->clearCurrentMessages();
        }

        //initialise return string
        $output = NULL;
        //process messages
        foreach ($messages as $message) {
            if (is_array($message)) {
                list($key, $message) = each($message);
            }
            //$output .= sprintf($template, $key, $message);
            $output .= sprintf($template, $key, $message);
        }

        return $output;
    }
    /**
     * Lazily fetches FlashMessenger Instance.
     *
     * @return Zend_Controller_Action_Helper_FlashMessenger
     */
    public function _getFlashMessenger() {
        if (null === $this->_flashMessenger) {
            $this->_flashMessenger =
                    Zend_Controller_Action_HelperBroker::
                    getStaticHelper('FlashMessenger');
        }
        return $this->_flashMessenger;
    }

}
