<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Mail
 *
 * @author Bruno
 */
class SOSMalas_Mail extends Zend_Mail {

    const EMAIL = 'rhi.grupo1@gmail.com';
    const PASSWORD = 'fortiumgama';
    const SSL = 'ssl';
    const PORT = '465';

    public $config = array();

    public function __construct($charset = null) {

        $this->config = array('auth' => 'login',
            'username' => self::EMAIL,
            'password' => self::PASSWORD,
            'ssl' => self::SSL,
            'port' => self::PORT
        );

        parent::__construct($charset);
    }

    public function sendEmail() {
        $transport = new Zend_Mail_Transport_Smtp('smtp.gmail.com', $this->config);
        return $this->send($transport);
    }

}