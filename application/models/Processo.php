<?php

class Application_Model_Processo extends SOSMalas_Db_Mapper {

    protected $_name = 'tb_processo';
    protected $_primary = 'id_processo';

    public function listEntrada($where = NULL) {
        $query = $this->select()
                ->from(array('p' => 'tb_processo'), array('*'))
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
                ->joinLeft(array('p' => 'pessoa'), 'p.id_pessoa = e.id_empresa', array('*'));

        foreach ($where as $key => $value) {
            $query->where($key . ' = ?', $value);
        }

        $query->setIntegrityCheck(false);

        return $this->fetchAll($query);
    }

    public function update(array $data, $where = null) {
        $historico = new Application_Model_HistoricoProcesso();
        
        $data['dt_coleta'] = SOSMalas_Date::dateToBanco($data['dt_coleta']);
        $data['dt_entrega'] = SOSMalas_Date::dateToBanco($data['dt_entrega']);

        //Registrando historico
        $historico->insert($data);
        
        return parent::update($data, $where);
    }

    public function insert(array $data) {
        $historico = new Application_Model_HistoricoProcesso();
        
        $data['dt_coleta'] = SOSMalas_Date::dateToBanco($data['dt_coleta']);
        $data['dt_entrega'] = SOSMalas_Date::dateToBanco($data['dt_entrega']);

        $data['id_processo'] = parent::insert($data);

        //Registrando historico
        $historico->insert($data);
        
        return $data['id_processo'];
    }

    public function getProcessosPagination(array $where = null, array $whereLike = null) {

        $query = $this->select()
                ->from(array('pro' => 'tb_processo'), array('*'))
                ->joinLeft(array('p' => 'pessoa'), 'p.id_pessoa = pro.id_empresa', array('p.nome_pessoa', 'p.id_pessoa'))
                ->join(array('sp' => 'tb_status_processo'), 'sp.id_status = pro.status_id', array('sp.tx_status'))
        ;

        foreach ($whereLike as $key => $value) {
            if ($value) {
                $query->orHaving($key . ' like ' . "'%$value%'");
            }
        }

        foreach ($where as $key => $value) {
            if ($value) {
                $query->where($key . ' = ?', $value);
            }
        }

        $query->setIntegrityCheck(false);

        return Zend_Paginator::factory($query);
    }

}
