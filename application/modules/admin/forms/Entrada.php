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
class Admin_Form_Entrada extends Zend_Form {

    const erro = 'Campo de preenchimento obrigatório!';

    function init() {
        $id = new Zend_Form_Element_Hidden('id');
        $this->addElement($id);

        $data_entrada = new Zend_Form_Element_Text('data_entrada');
        $data_entrada->setRequired(true)
                ->addErrorMessage(self::erro);
        $this->addElement($data_entrada);

        $empresa = new Zend_Form_Element_Text('empresa');
        $empresa->setRequired(true)
                ->addErrorMessage(self::erro);
        $this->addElement($empresa);

        $processo = new Zend_Form_Element_Text('processo');
        $processo->setRequired(true)
                ->addErrorMessage(self::erro);
        $this->addElement($processo);

        $marca = new Zend_Form_Element_text('marca');
        $marca->setRequired(true)
                ->addErrorMessage(self::erro);
        $this->addElement($marca);

        
        $nome = new Zend_Form_Element_text('nome');
        $nome->setRequired(true)
                ->addErrorMessage(self::erro);
        $this->addElement($nome);


        $dano = new Zend_Form_Element_text('dano');
        $dano->setRequired(true)
                ->addErrorMessage(self::erro);
        $this->addElement($dano);


        $preco = new Zend_Form_Element_text('preco');
        $preco->setRequired(true)
                ->addErrorMessage(self::erro);
        $this->addElement($preco);


        $data_conclusao = new Zend_Form_Element_text('data_conclusao');
        $data_conclusao->setRequired(true)
                ->addErrorMessage(self::erro);
        $this->addElement($data_conclusao);


        $data_previsao = new Zend_Form_Element_text('data_previsao');
        $data_previsao->setRequired(true)
                ->addErrorMessage(self::erro);
        $this->addElement($data_previsao);


        $data_entrega = new Zend_Form_Element_text('data_entrega');
        $data_entrega->setRequired(true)
                ->addErrorMessage(self::erro);
        $this->addElement($data_entrega);

        foreach($this->getElements() as $element ) {
            $element->removeDecorator('label')->removeDecorator('htmltag');
        }
    }
}
