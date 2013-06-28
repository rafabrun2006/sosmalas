<?php

class Application_Model_Coleta extends SOSMalas_Db_Mapper {
    
    protected $_name = 'coletas';
    protected $_primary = 'os_coleta';

    public function listColeta($where = NULL){
        $query = $this->select()
                ->from(array('c' => 'coletas'), array('*'))
                ->joinInner(array('p' => 'pessoa'), 'p.id_pessoa = c.cliente_id', array('*'))
                ->setIntegrityCheck(false);

        if($where){
            $query->where(key($where)." like ?", "%{$where['os_coleta']}%");
        }
        
        return $this->fetchAll($query);
    }

    public function getArrayById($coletas){

        $query = $this->select()
                ->from(array('c' => 'coletas'), array('*'))
                ->join(array('p' => 'pessoa'), 'c.cliente_id = p.id_pessoa', array('*'))
                ->where('c.os_coleta = ?', $coletas)
                ->setIntegrityCheck(false)
                ;

        return $this->fetchAll($query)->toArray();
    }

    public function update($array){
        $array['data_pedido_coleta'] = SOSMalas_Date::dateToBanco($array['data_pedido_coleta']);
        $array['previsao_coleta'] = SOSMalas_Date::dateToBanco($array['previsao_coleta']);
        
        parent::update($array);
    }
    
    public function insert($data){
        
        $data['data_pedido_coleta']  = SOSMalas_Date::dateToBanco($data['data_pedido_coleta']);
        $data['previsao_coleta']  = SOSMalas_Date::dateToBanco($data['previsao_coleta']);
        
        return parent::insert($data);
    }
}


