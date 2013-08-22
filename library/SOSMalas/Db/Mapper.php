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

    public function insert(array $data) {

        $arrayFields = array();

        foreach ($data as $key => $value) {
            if (in_array($key, $this->_getCols())) {
                $arrayFields[$key] = $value;
            }
        }

        return parent::insert($arrayFields);
    }

    public function update(array $data, $where) {

        $arrayFields = array();

        foreach ($data as $key => $value) {
            if (in_array($key, $this->_getCols())) {
                $arrayFields[$key] = $value;
            }
        }
        return parent::update($arrayFields, $this->_primary[1] . '=' . $data[$this->_primary[1]], $where);
    }

    public function delete($where) {
        return parent::delete($this->_primary . ' = ' . $where[$this->_primary]);
    }

    public function searchLikeFields(array $fieldsRejected = array(), $value = null, array $whereAnd = null) {
        $query = $this->select();

        foreach ($this->_getCols() as $col) {
            if (!in_array($col, $fieldsRejected)) {
                $query->orHaving($col . ' like ' . "'%{$value}%'");
                $query->limit(10);
            }
        }
        
        foreach($whereAnd as $key => $value){
            if(!empty($value)){
                $query->where($key . ' = ?', $value);
            }
        }

        return $this->fetchAll($query);
    }

}