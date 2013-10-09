<?php

class Application_Model_Processo extends SOSMalas_Db_Mapper {

    protected $_name = 'processos';
    protected $_primary = 'id_processo';

    public function listEntrada($where = NULL) {
        $query = $this->select()
                ->from(array('e' => 'entrada'), array('*'))
                ->setIntegrityCheck(false);

        if ($where) {
            $query->where(key($where) . " like ?", "%{$where['id_entrada']}%");
        }

        return $this->fetchAll($query);
    }

    public function getArrayById($processo) {

        $query = $this->select()
                ->from(array('p' => 'processo'), array('*'))
                ->where('p.processo = ?', $processo)
                ->setIntegrityCheck(false)
        ;

        return $this->fetchAll($query)->toArray();
    }

    public function getProcessos(array $where = null) {
        $query = $this->select()
                ->from(array('e' => 'processos'), array('*'))
                ->joinLeft(array('p' => 'pessoa'), 'p.id_pessoa = e.pessoa_entrada', array('*'));

        foreach ($where as $key => $value) {
            $query->where($key . ' = ?', $value);
        }
        
        $query->setIntegrityCheck(false);
        
        return $this->fetchAll($query);
    }

    public function update(array $data, $where = null) {

        $data['data_coleta_processo'] = SOSMalas_Date::dateToBanco($data['data_coleta_processo']);
        $data['data_entrega_processo'] = SOSMalas_Date::dateToBanco($data['data_entrega_processo']);

        return parent::update($data, $where);
    }

    public function insert(array $data) {

        $data['data_coleta_processo'] = SOSMalas_Date::dateToBanco($data['data_coleta_processo']);
        $data['data_entrega_processo'] = SOSMalas_Date::dateToBanco($data['data_entrega_processo']);

        return parent::insert($data);
    }
    
    public function getProcessosPagination(array $where = null){
        
        $query = $this->select()
                ->from(array('e' => 'processos'), array('*'))
                ->joinLeft(array('p' => 'pessoa'), 'p.id_pessoa = e.pessoa_entrada', array('*'))
                ;

        foreach ($where as $key => $value) {
            $query->where($key . ' like '."'%$value%'");
        }
        
        $query->setIntegrityCheck(false);
        
        return Zend_Paginator::factory($query);
    }

}

