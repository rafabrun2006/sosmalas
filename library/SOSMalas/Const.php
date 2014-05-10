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
    const TEXTO_HISTORICO = 'Última atualização: %s %s';
    const MSG_SIS01 = 'Você não tem previlégio o suficiente para acessar esta página';
    const APRESENTACAO_EMAIL_ATUALIZA = 'Processo Finalizado Nº %s';
    const APRESENTACAO_EMAIL_NOVO = 'Novo Processo Cadastrado Nº %s';
    const STATUS_PROCESSO_EM_CONSERTO = 1;
    const STATUS_PROCESSO_AGUARDANDO_PECA = 2;
    const STATUS_PROCESSO_REPROVADA_CONSERTO = 3;
    const STATUS_PROCESSO_EM_TRANSITO = 4;
    const STATUS_PROCESSO_FINALIZADO = 5;
    const LOCAL_ENTREGA_COLETA_AEROPORTO = 1;
    const LOCAL_ENTREGA_COLETA_RESIENCIA = 2;
    const LOCAL_ENTREGA_COLETA_OFICINA = 3;

    static function getStatusProcesso() {
        return array(
            SOSMalas_Const::STATUS_PROCESSO_EM_CONSERTO => 'Em conserto',
            SOSMalas_Const::STATUS_PROCESSO_AGUARDANDO_PECA => 'Aguardando peça',
            SOSMalas_Const::STATUS_PROCESSO_REPROVADA_CONSERTO => 'Reprovada p/ conserto',
            SOSMalas_Const::STATUS_PROCESSO_EM_TRANSITO => 'Em trânsito',
            SOSMalas_Const::STATUS_PROCESSO_FINALIZADO => 'Finalizado');
    }

    static function getStringRecebNotif($value = false) {
        return $value ? self::RECEBE_NOTIFICACOES_SIM : self::RECEBE_NOTIFICACOES_NAO;
    }

    static function getLocalEntregaColeta() {
        return array(
            SOSMalas_Const::LOCAL_ENTREGA_COLETA_AEROPORTO => 'Aeroporto',
            SOSMalas_Const::LOCAL_ENTREGA_COLETA_RESIENCIA => 'Residência',
            SOSMalas_Const::LOCAL_ENTREGA_COLETA_OFICINA => 'Oficina'
        );
    }

}
