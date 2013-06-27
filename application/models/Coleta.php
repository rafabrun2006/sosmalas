<?php

class Application_Model_Coleta extends Zend_Db_Table_Abstract {
    
    protected $_name = 'coletas';
    protected $_primary = 'os_coleta';

    public function listColeta($where = NULL){
        $query = $this->select()
                ->from(array('c' => 'coletas'), array('*'))
                //->joinInner(array('p' => 'tb_pessoa'), 'p.cod_pessoa = f.cod_pessoa', array('*'))
                ->setIntegrityCheck(false);

        if($where){
            $query->where(key($where)." like ?", "%{$where['os']}%");
        }
        
        //echo $query;
        return $this->fetchAll($query);
    }

    public function getArrayById($coletas){

        $query = $this->select()
                ->from(array('c' => 'coletas'), array('*'))
                /*->join(array('p' => 'tb_pessoa'), 'f.cod_pessoa = p.cod_pessoa', array('*'))
                ->join(array('e' => 'tb_endereco'), 'p.cod_end = e.cod_end', array('*'))
                ->join(array('t' => 'tb_telefone'), 't.cod_pessoa = p.cod_pessoa', array('*'))
                ->joinLeft(array('l' => 'tb_login'), 'l.cod_login = p.cod_login', array('*'))*/
                ->where('c.coletas = ?', $coletas)
                ->setIntegrityCheck(false)
                ;

        return $this->fetchAll($query)->toArray();
    }

    public function edit($array){
        $this->update($array, array('os' => $array['os']));
    }
}


