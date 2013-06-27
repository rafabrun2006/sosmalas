<?php


class Config {

    public static function getMailInstance() {
        require_once 'Zend/Mail/Transport/Smtp.php';

        $config ['auth'] = 'rhi.grupo1@gmail.com'; // Email servidor autenticados
        $config ['username'] = 'rhi.grupo1@gmail.com'; // informa o login do E-mail
        $config ['password'] = 'fortiumgama'; // senha

        return new Zend_Mail_Transport_Smtp ( "smtp.gmail.com", $config );
    }

}