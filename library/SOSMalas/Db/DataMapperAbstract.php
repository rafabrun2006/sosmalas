<?php

abstract class SOSMalas_Db_DataMapperAbstract {

    private static $_db = null;
    protected $_dbTable = null;
    protected $_model = null;

    //metodos Owen Bruno
    public function getMethods($name, $params = array()) {
        return $this->$name($params);
    }

    public function getNumRows($id) {
        $dbTable = $this->getDbTable();

        $db = $this->getDb();
        $query = (is_null($id)) ? 'SELECT COUNT(' . $id . ') FROM ' . $this->_dbTable : 'SELECT COUNT(id) FROM ' . $this->_dbTable;

        return $dbTable->find($query);
    }

    public function getAllAsArray(Zend_Db_Select $select = null) {
        $dbTable = $this->getDbTable();
        $db = $this->getDb();
        $data = (!is_null($select)) ? $db->fetchAll($select) : $dbTable->fetchAll();
        return $data->toArray();
    }

    //-----------------------------

    public function getDb() {
        if (is_null(self::$_db))
            self::$_db = Zend_Db_Table::getDefaultAdapter();
        return self::$_db;
    }

    public function getDbTable() {
        $this->_dbTable = new $this->_dbTable;
        if (!$this->_dbTable instanceof Zend_Db_Table_Abstract)
            throw new Exception('Tipo inválido de tabela');
        return $this->_dbTable;
    }

    public function save(Owen_Db_DomainObjectAbstract $obj) {
        if (is_null($obj->getId())) {

            /* Author: Bruno - Alteração feita em 16/09/12 por motivo de exibção de retorno da execucao */
            if ($return = $this->_insert($obj)) {
                return $return;
            }
        } else {
            $obj->getId();
            /* Author: Bruno - Alteração feita em 01/10/12 por motivo de exibção de retorno da execucao */
            if ($return = $this->_update($obj)) {
                return $return;
            }
        }
    }

    public function fetchAll(Zend_Db_Select $select = null) {
        $dbTable = $this->getDbTable();
        $db = $this->getDb();
        $data = (!is_null($select)) ? $db->fetchAll($select) : $dbTable->fetchAll();
        $dataObjArray = array();
        foreach ($data as $row)
            $dataObjArray[] = $this->_populate($row);
        return $dataObjArray;
    }

    public function find($id, $popular = true) {
        $result = $this->getDbTable()->find((int) $id);
        if (0 == count($result))
            return false;
        $row = $result->current();
        if ($popular === true) {
            return $this->_populate($row);
        } else {
            return $row;
        }
    }

    public function getAsArray($id) {
        $result = $this->getDbTable()->find((int) $id);
        if (0 == count($result))
            return false;
        $row = $result->current();
        return $row->toArray();
    }

    public function delete($id) {
        $result = $this->getDbTable()->find((int) $id);
        if (0 == count($result))
            return false;
        $row = $result->current();
        return $row->delete();
    }

    protected function _populate($data) {
        $obj = new $this->_model;
        foreach ($data as $k => $v) {
            $method = 'set' . ucfirst($k);
            if (!method_exists($obj, $method)) {
                throw new Exception('Invalid property <strong>' . $method . '</strong> in class <strong>' . get_class($obj) . '</strong>');
            }
            $obj->$method($v);
        }
        return $obj;
    }

    public function getLastInsertId() {
        $db = $this->getDb();
        return $db->lastInsertId();
    }

    abstract protected function _insert(Owen_Db_DomainObjectAbstract $obj);

    abstract protected function _update(Owen_Db_DomainObjectAbstract $obj);
}