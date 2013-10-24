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
    const RECEBE_NOTIFICACOES_SIM = 'Sim';
    const RECEBE_NOTIFICACOES_NAO = 'Não';
    
    const MSG01 = 'Operação realizada com sucesso';
    const MSG02 = 'Erro ao executar a operação';
    const MSG03 = 'Verifique seu formulário, os campos obrigatórios não foram preenchidos';
    const MSG04 = 'E-mail enviado com sucesso';
    const MSG05 = 'Erro no envio do E-mail';
    const MSG06 = 'Um e-mail foi enviado para o correspondente';
    const TEXTO_HISTORICO = 'Status: %s %s %s';
    
    const MSG_SIS01 = 'Você não tem previlégio o suficiente para acessar esta página';

    const APRESENTACAO_EMAIL_ATUALIZA = 'O registro do processo abaixo foi atualizado!';
    const APRESENTACAO_EMAIL_NOVO = 'O registro do processo abaixo foi realizado com sucesso!';
    
    static function getStatusProcesso() {
        return array(
            1 => 'Em conserto',
            2 => 'Aguardando peça',
            3 => 'Reprovada p/ conserto',
            4 => 'Em trânsito',
            5 => 'Finalizado');
    }
    
    static function getStringRecebNotif($value = false){
        return $value ? self::RECEBE_NOTIFICACOES_SIM : self::RECEBE_NOTIFICACOES_NAO;
    }

}
