<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Const
 *
 * @author Bruno
 */
class SOSMalas_Const {

    const DATE_FORMAT_DB = 'Y-m-d';
    const DATE_FORMAT_VIEW = 'd-m-Y';
    const TIPO_USUARIO_ADMIN = 'admin';
    const TIPO_USUARIO_MEMBER = 'member';
    const TIPO_USUARIO_USER = 'user';
    const MSG01 = 'Operação realizada com sucesso';
    const MSG02 = 'Erro ao executar a operação';
    const MSG03 = 'Verifique seu formulário, os campos obrigatórios não foram preenchidos';
    //Mensagens do sistema
    const MSG_SIS01 = 'Você não tem previlégio o suficiente para acessar esta página';

    static function getStatusProcesso() {
        return array(
            1 => 'Em concerto',
            2 => 'Aguardando peça',
            3 => 'Reprovada p/ concerto',
            4 => 'Em trânsito',
            5 => 'Finalizado');
    }

}
