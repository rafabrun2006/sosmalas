<?php

class Application_Model_HistoricoProcesso extends SOSMalas_Db_Mapper {

    protected $_name = 'tb_historico_processo';
    protected $_primary = 'id_historico_processo';

    public function insert(array $data) {
        $date = new Zend_Date();
        
        $textoHistorico = !empty($data['texto_historico'])  ? 
                $data['texto_historico'].',' : null;
        
        $data['dt_cadastro'] = $date->get('Y-MM-dd H:m:s');
        $data['texto_historico'] = sprintf(
                SOSMalas_Const::TEXTO_HISTORICO, $textoHistorico, $date->toString()
        );
        
        return parent::insert($data);
    }
    
    public function findByProcesso($id){
        
        $query = $this->select()
                ->from(array('h' => 'tb_historico_processo'))
                ->order('h.dt_cadastro DESC')
                ->where('h.processo_id = ?', $id)
                ->setIntegrityCheck(FALSE);
        
        return $this->fetchAll($query);
    }

}
