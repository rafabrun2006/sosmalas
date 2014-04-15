<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of VwProcessos
 *
 * @author Bruno
 */
class Application_Model_VwProcessos extends SOSMalas_Db_Mapper {
    
    protected $_name = 'vw_processos';
    protected $_primary = 'id_processo';
    
    public function findVwProcessos(array $whereAnd = null){
        
        $select = $this->select()
                ->from(array('vw' => 'vw_processos'))
                ->setIntegrityCheck(FALSE);
        
        foreach($whereAnd as $key => $value){
            $select->where($key . ' = ?', $value);
        }
        
        return $this->fetchAll($select);
    }
    
}
