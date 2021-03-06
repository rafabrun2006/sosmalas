<?php

class Application_Model_Pessoa extends SOSMalas_Db_Mapper {

    protected $_name = 'tb_pessoa';
    protected $_primary = 'id_pessoa';

    public function listPessoa($where = NULL) {
        $query = $this->select()
                ->from(array('p' => 'tb_pessoa'), array('*'))
                ->setIntegrityCheck(false);

        if ($where) {
            $query->where(key($where) . " like ?", "%{$where['nome_contato']}%");
        }

        return $this->fetchAll($query);
    }

    public function getArrayById($cod_pessoa) {

        $query = $this->select()
                ->from(array('f' => 'tb_pessoa'), array('*'))
                ->where('p.id_pessoa = ?', $cod_pessoa)
                ->setIntegrityCheck(false)
        ;

        return $this->fetchAll($query)->toArray();
    }

    public function update(array $array, $where = null) {
        $this->_primary = 'id_pessoa';
        return parent::update($array, $where);
    }

    public function searchPerson(array $where) {

        $query = $this->select();

        foreach ($where as $key => $value) {
            $query->where($key . ' ' . $value);
        }

        return $this->fetchAll($query)->toArray();
    }
    
    public function adicionarCliente($data){
        $this->_primary = 'id_pessoa';
        return parent::insert($data);
    }
    
    public function verifyExistsPessoaByEmailAndName($nome_contato = NULL, $email = NULL){
        $query = $this->select()
                ->from(array('p' => 'tb_pessoa'), array('*'))
                ->where('p.nome_contato like ?', $nome_contato)
                ->orWhere('p.email like ?', '%'.$email.'%')
                ->setIntegrityCheck(false)
        ;
        
        return $this->fetchRow($query);
    }

}

