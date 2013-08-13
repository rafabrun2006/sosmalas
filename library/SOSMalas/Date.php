<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Simova_Date
 *
 * @author Administrador
 */
class SOSMalas_Date {

    /**
     * Formata data para formato exigido pelo banco de dados
     * @param type $date
     * @return type
     */
    public static function dateToBanco($date) {
        if(!is_null($date)){
            return date(SOSMalas_Const::DATE_FORMAT_DB, strtotime($date));
        }else{
            return null;
        }
    }

    /**
     * Formata data para formato de visualização
     * @param type $date
     * @return type
     */
    public static function dateToView($date) {
        if (is_null($date) or $date === '0000-00-00') {
            return null;
        } else {
            return date(SOSMalas_Const::DATE_FORMAT_VIEW, strtotime($date));
        }
    }

}