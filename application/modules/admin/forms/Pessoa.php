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

        $nome = new Zend_Form_Element_Text('nome_pessoa');
        $nome->setRequired(true)
                ->addErrorMessage(self::erro)
                ->setLabel("Nome:");
        $this->addElement($nome);

        $email = new Zend_Form_Element_Text('email_pessoa');
        $email->setRequired(true)
                ->addErrorMessage(self::erro)
                ->addValidator(new Zend_Validate_EmailAddress())
                ->setLabel("Email:");
        $this->addElement($email);

        $tel_res = new Zend_Form_Element_Text('tel_res_pessoa', array('class'=>'fone'));
        $tel_res->setLabel("Telefone Residencial:");
        $this->addElement($tel_res);

        $tel_cel = new Zend_Form_Element_Text('tel_cel_pessoa', array('class'=>'fone'));
        $tel_cel->setLabel('Telefone Celular:');
        $this->addElement($tel_cel);

        $endereco = new Zend_Form_Element_Text('endereco_pessoa');
        $endereco->setLabel('Endereço:');
        $this->addElement($endereco);

        $ponto_ref = new Zend_Form_Element_Text('ponto_ref_pessoa');
        $ponto_ref->setLabel('Ponto de Referencia:');
        $this->addElement($ponto_ref);

        $senha = new Zend_Form_Element_Password('senha_pessoa');
        $senha->setRenderPassword(true)
                ->setRequired(true)
                ->addErrorMessage(self::erro)
                ->setLabel("Senha:");
        $this->addElement($senha);
        
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

}
