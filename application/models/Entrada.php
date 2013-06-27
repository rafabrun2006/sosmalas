<?php

class Application_Model_Entrada extends Zend_Db_Table_Abstract {

    protected $_name = 'entrada';
    protected $_primary = 'id';

    public function listEntrada($where = NULL){
        $query = $this->select()
                ->from(array('e' => 'entrada'), array('*'))
                //->joinInner(array('p' => 'tb_pessoa'), 'p.cod_pessoa = f.cod_pessoa', array('*'))
                ->setIntegrityCheck(false);

        if($where){
            $query->where(key($where)." like ?", "%{$where['id']}%");
        }

        //echo $query;
        return $this->fetchAll($query);
    }

    public function getArrayById($entrada){

        $query = $this->select()
                ->from(array('e' => 'entrada'), array('*'))
                /*->join(array('p' => 'tb_pessoa'), 'f.cod_pessoa = p.cod_pessoa', array('*'))
                ->join(array('e' => 'tb_endereco'), 'p.cod_end = e.cod_end', array('*'))
                ->join(array('t' => 'tb_telefone'), 't.cod_pessoa = p.cod_pessoa', array('*'))
                ->joinLeft(array('l' => 'tb_login'), 'l.cod_login = p.cod_login', array('*'))*/
                ->where('e.entrada = ?', $entrada)
                ->setIntegrityCheck(false)
                ;

        return $this->fetchAll($query)->toArray();
    }

    public function edit($array){
        $this->update($array, array('id' => $array['id']));
    }
}


