<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Pessoa
 *
 * @author Luis Thiago
 */
class Admin_Form_Pessoa extends Zend_Form {

    const erro = 'Campo de preenchimento obrigatório!';

    function init() {
        $id = new Zend_Form_Element_Hidden('id_pessoa');
        $this->addElement($id);

        $nome = new Zend_Form_Element_Text('nome_contato');
        $nome->setRequired(true)
                ->addErrorMessage(self::erro)
                ->setLabel("Nome Contato:");
        $this->addElement($nome);
        
        $nome_empresa = new Zend_Form_Element_Text('nome_empresa');
        $nome_empresa->setRequired(true)
                ->addErrorMessage(self::erro)
                ->setLabel("Nome Empresa:");
        $this->addElement($nome_empresa);

        $email = new Zend_Form_Element_Text('email');
        $email->setRequired(true)
                ->addErrorMessage(self::erro)
                ->addValidator(new Zend_Validate_EmailAddress())
                ->setLabel("Email:");
        $this->addElement($email);

        $tel_res = new Zend_Form_Element_Text('fone_empresa', array('class'=>'fone'));
        $tel_res->setLabel("Telefone:");
        $this->addElement($tel_res);

        $senha = new Zend_Form_Element_Password('senha');
        $senha->setRenderPassword(true)
                ->setRequired(true)
                ->addErrorMessage(self::erro)
                ->setLabel("Senha:");
        $this->addElement($senha);
        
        $tipoAcesso = new Zend_Form_Element_Select('tipo_acesso_id');
        $tipoAcesso->setLabel('Tipo de Acesso: ');
        $this->addElement($tipoAcesso);
        
        $this->comboTipoAcesso();
        
        $this->setDecorators(array(
            array('ViewScript',
                array('viewScript' => 'pessoa/form-pessoa.phtml')
            )
        ));

        foreach ($this->getElements() as $element) {
            $element->removeDecorator('HtmlTag');
            $element->removeDecorator('DtDdWrapper');
        }
    }
    
    public function comboTipoAcesso(){
        $model = new Application_Model_TipoAcesso();
        
        foreach($model->fetchAll() as $value){
            $this->getElement('tipo_acesso_id')->addMultiOption($value->id_tipo_acesso, $value->descricao_tipo_acesso);
        }
    }

}
