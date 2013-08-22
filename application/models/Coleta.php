<?php

class Application_Model_Coleta extends SOSMalas_Db_Mapper {
    
    protected $_name = 'coletas';
    protected $_primary = 'os_coleta';

    public function listColeta($where = NULL){
        $query = $this->select()
                ->from(array('c' => 'coletas'), array('*'))
                ->setIntegrityCheck(false);
        
        if($where){
            $query->where(key($where)." like ?", "%{$where['os_coleta']}%");
        }
        
        return $this->fetchAll($query);
    }

    public function getArrayById($coletas){

        $query = $this->select()
                ->from(array('c' => 'coletas'), array('*'))
                ->where('c.os_coleta = ?', $coletas)
                ->setIntegrityCheck(false)
                ;

        return $this->fetchAll($query)->toArray();
    }

    public function update(array $array, $where){
        $array['data_pedido_coleta'] = SOSMalas_Date::dateToBanco($array['data_pedido_coleta']);
        $array['previsao_coleta'] = SOSMalas_Date::dateToBanco($array['previsao_coleta']);
        
        return parent::update($array, $where);
    }
    
    public function insert(array $data){
        
        $data['data_pedido_coleta']  = SOSMalas_Date::dateToBanco($data['data_pedido_coleta']);
        $data['previsao_coleta']  = SOSMalas_Date::dateToBanco($data['previsao_coleta']);
        
        return parent::insert($data);
    }
}


