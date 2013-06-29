<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Mapper
 *
 * @author Bruno
 */
class SOSMalas_Db_Mapper extends Zend_Db_Table_Abstract {

    public function insert($data) {

        $arrayFields = array();

        foreach ($data as $key => $value) {
            if (in_array($key, $this->_getCols())) {
                $arrayFields[$key] = $value;
            }
        }

        return parent::insert($arrayFields);
    }

    public function update($data) {

        $arrayFields = array();

        foreach ($data as $key => $value) {
            if (in_array($key, $this->_getCols())) {
                $arrayFields[$key] = $value;
            }
        }
        return parent::update($arrayFields, $this->_primary[1] . '=' . $data[$this->_primary[1]]);
    }
    
    public function delete($where){
        return parent::delete($this->_primary . ' = ' . $where[$this->_primary]);
    }

}