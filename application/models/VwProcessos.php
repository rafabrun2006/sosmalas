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
    
    public function findVwProcessos(){
        
        $select = $this->select()
                ->from(array('vw' => 'vw_processos'))
                //->limit(200)
                ->setIntegrityCheck(FALSE);
        
        return $this->fetchAll($select);
    }
    
}
