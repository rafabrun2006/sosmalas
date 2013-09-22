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

    /**
     * Metadatas of table
     * @var Array $metadata
     */
    protected $_metadata;

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

        $where = $this->_primary[1] . '=' . $data[$this->_primary[1]];

        return parent::update($arrayFields, $where);
    }

    public function delete($where) {
        return parent::delete($this->_primary . ' = ' . $where[$this->_primary]);
    }

    public function searchLikeFields(array $fieldsRejected = array(), $value = null, array $whereAnd = null) {
        $query = $this->select();

        $this->_metadata = $this->info();

        foreach ($this->_metadata['metadata'] as $col) {
            if (!in_array($col['COLUMN_NAME'], $fieldsRejected)) {
                $value = $this->formateDataByType($value, $col['DATA_TYPE']);
                $query->orHaving($col['COLUMN_NAME'] . ' like ' . "'%{$value}%'");
            }
        }

        foreach ($whereAnd as $key => $value) {
            if (!empty($value)) {
                $query->where($key . ' = ?', $value);
            }
        }
        $query->limit(10);
        return $this->fetchAll($query);
    }

    private function formateDataByType($value, $format) {
        switch ($format) {
            case 'date':
                return SOSMalas_Date::dateToBanco($value);
        }
    }

}
