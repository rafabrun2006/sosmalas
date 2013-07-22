<?php

class Application_Model_Entrada extends SOSMalas_Db_Mapper {

    protected $_name = 'entrada';
    protected $_primary = 'id_entrada';

    public function listEntrada($where = NULL) {
        $query = $this->select()
                ->from(array('e' => 'entrada'), array('*'))
                ->setIntegrityCheck(false);

        if ($where) {
            $query->where(key($where) . " like ?", "%{$where['id_entrada']}%");
        }

        return $this->fetchAll($query);
    }

    public function getArrayById($entrada) {

        $query = $this->select()
                ->from(array('e' => 'entrada'), array('*'))
                ->where('e.entrada = ?', $entrada)
                ->setIntegrityCheck(false)
        ;

        return $this->fetchAll($query)->toArray();
    }

    public function getProcessos(array $where = null) {
        $query = $this->select()
                ->from(array('e' => 'entrada'), array('*'))
                ->joinLeft(array('p' => 'pessoa'), 'p.id_pessoa = e.empresa_entrada', array('*'));

        foreach ($where as $key => $value) {
            $query->where($key . ' = ?', $value);
        }
        
        $query->setIntegrityCheck(false);
        
        return $this->fetchAll($query);
    }

    public function update($data) {

        $data['data_entrada'] = SOSMalas_Date::dateToBanco($data['data_entrada']);
        $data['data_conclusao_entrada'] = SOSMalas_Date::dateToBanco($data['data_conclusao_entrada']);
        $data['data_previsao_entrada'] = SOSMalas_Date::dateToBanco($data['data_previsao_entrada']);
        $data['data_entrega_entrada'] = SOSMalas_Date::dateToBanco($data['data_entrega_entrada']);

        return parent::update($data);
    }

    public function insert($data) {

        $data['data_entrada'] = SOSMalas_Date::dateToBanco($data['data_entrada']);
        $data['data_conclusao_entrada'] = SOSMalas_Date::dateToBanco($data['data_conclusao_entrada']);
        $data['data_previsao_entrada'] = SOSMalas_Date::dateToBanco($data['data_previsao_entrada']);
        $data['data_entrega_entrada'] = SOSMalas_Date::dateToBanco($data['data_entrega_entrada']);

        return parent::insert($data);
    }

}

