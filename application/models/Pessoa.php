<?php

class Application_Model_Pessoa extends SOSMalas_Db_Mapper {

    protected $_name = 'pessoa';
    protected $_primary = 'id_pessoa';

    public function listPessoa($where = NULL) {
        $query = $this->select()
                ->from(array('p' => 'pessoa'), array('*'))
                ->setIntegrityCheck(false);

        if ($where) {
            $query->where(key($where) . " like ?", "%{$where['nome_pessoa']}%");
        }

        //echo $query;
        return $this->fetchAll($query);
    }

    public function getArrayById($cod_pessoa) {

        $query = $this->select()
                ->from(array('f' => 'pessoa'), array('*'))
                ->where('p.id_pessoa = ?', $cod_pessoa)
                ->setIntegrityCheck(false)
        ;

        return $this->fetchAll($query)->toArray();
    }

    public function update($array) {
        return parent::update($array);
    }

    public function searchPerson(array $where) {

        $query = $this->select();

        foreach ($where as $key => $value) {
            $query->where($key . ' ' . $value);
        }

        return $this->fetchAll($query)->toArray();
    }

}

