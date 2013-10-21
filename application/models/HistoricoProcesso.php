<?php

class Application_Model_HistoricoProcesso extends SOSMalas_Db_Mapper {

    protected $_name = 'tb_historico_processo';
    protected $_primary = 'id_historico_processo';

    public function insert(array $data) {
        $status = SOSMalas_Const::getStatusProcesso();
        $date = new Zend_Date();
        
        $textoHistorico = !empty($data['texto_historico'])  ? 
                $data['texto_historico'].',' : null;
        
        $data['dt_cadastro'] = $date->get('Y-MM-dd H:m:s');
        $data['processo_id'] = $data['id_processo'];
        $data['texto_historico'] = sprintf(
                SOSMalas_Const::TEXTO_HISTORICO, $status[$data['status_id']].',', $textoHistorico, $date->toString()
        );
        
        return parent::insert($data);
    }
    
    public function findByProcesso($id){
        
        $where = 'processo_id = '.$id;
        
        return $this->fetchAll($where);
    }

}
