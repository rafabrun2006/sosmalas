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
        $id = new Zend_Form_Element_Hidden('id_entrada');
        $this->addElement($id);

        $data_entrada = new Zend_Form_Element_Text('data_entrada', array('class'=>'date'));
        $data_entrada->setLabel('Data Entrada:')
                ->setRequired(true)
                ->addErrorMessage(self::erro);
        $this->addElement($data_entrada);

        $empresa = new Zend_Form_Element_Text('empresa_entrada');
        $empresa->setRequired(true)
                ->setLabel('Empresa:')
                ->addErrorMessage(self::erro);
        $this->addElement($empresa);

        $processo = new Zend_Form_Element_Text('processo_entrada');
        $processo->setRequired(true)
                ->setLabel('Processo: ')
                ->addErrorMessage(self::erro);
        $this->addElement($processo);

        $marca = new Zend_Form_Element_text('marca_entrada');
        $marca->setRequired(true)
                ->setLabel('Marca: ')
                ->addErrorMessage(self::erro);
        $this->addElement($marca);


        $nome = new Zend_Form_Element_text('nome_entrada');
        $nome->setRequired(true)
                ->setLabel('Nome: ')
                ->addErrorMessage(self::erro);
        $this->addElement($nome);


        $dano = new Zend_Form_Element_text('dano_entrada');
        $dano->setRequired(true)
                ->setLabel('Dano: ')
                ->addErrorMessage(self::erro);
        $this->addElement($dano);


        $preco = new Zend_Form_Element_text('preco_entrada', array('class'=>'money'));
        $preco->setRequired(true)
                ->setLabel('Preço: ')
                ->addErrorMessage(self::erro);
        $this->addElement($preco);


        $data_conclusao = new Zend_Form_Element_text('data_conclusao_entrada', array('class'=>'date'));
        $data_conclusao->setRequired(true)
                ->setLabel('Data Conclusão: ')
                ->addErrorMessage(self::erro);
        $this->addElement($data_conclusao);


        $data_previsao = new Zend_Form_Element_text('data_previsao_entrada', array('class'=>'date'));
        $data_previsao->setRequired(true)
                ->setLabel('Data Previsão: ')
                ->addErrorMessage(self::erro);
        $this->addElement($data_previsao);


        $data_entrega = new Zend_Form_Element_text('data_entrega_entrada', array('class'=>'date'));
        $data_entrega->setRequired(true)
                ->setLabel('Data Entrega: ')
                ->addErrorMessage(self::erro);
        $this->addElement($data_entrega);

        $this->setDecorators(array(
            array('ViewScript',
                array('viewScript' => 'entrada/form-entrada.phtml')
            )
        ));

        foreach ($this->getElements() as $element) {
            $element->removeDecorator('HtmlTag');
            $element->removeDecorator('DtDdWrapper');
        }
    }

}
