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
class Admin_Form_Processos extends Zend_Form {

    const erro = 'Campo de preenchimento obrigatório!';

    function init() {

        $id_processo = new Zend_Form_Element_Hidden('id_processo');
        $this->addElement($id_processo);

        $cod_processo = new Zend_Form_Element_Text('cod_processo', array('required'=>'required'));
        $cod_processo->setLabel('Processo')->setRequired(TRUE)->setAttrib('required', 'required');
        $this->addElement($cod_processo);

        $id_empresa = new Zend_Form_Element_Select('id_empresa');
        $id_empresa->setLabel('Parceiro');
        $this->addElement($id_empresa);

        $nome_cliente = new Zend_Form_Element_Text('nome_cliente');
        $nome_cliente->setLabel('Cliente');
        $this->addElement($nome_cliente);

        $quantidade = new Zend_Form_Element_Text('quantidade');
        $quantidade->setLabel('Quantidade');
        $this->addElement($quantidade);

        $descricao_produto = new Zend_Form_Element_Text('descricao_produto');
        $descricao_produto->setLabel('Produto/Marca/Modelo/Cor');
        $this->addElement($descricao_produto);

        $conserto = new Zend_Form_Element_Text('conserto');
        $conserto->setLabel('Conserto');
        $this->addElement($conserto);

        $dt_coleta = new Zend_Form_Element_Text('dt_coleta');
        $dt_coleta->setLabel('Data Coleta')->setAttrib('ng-controller', 'DatePicker');
        $this->addElement($dt_coleta);

        $dt_entrega = new Zend_Form_Element_Text('dt_entrega');
        $dt_entrega->setLabel('Data Entrega')->setAttrib('ng-controller', 'DatePicker');
        $this->addElement($dt_entrega);

        $status_id = new Zend_Form_Element_Select('status_id');
        $status_id->setLabel('Status')->setRequired(TRUE)->setAttrib('required', 'required');
        $this->addElement($status_id);

        $pessoa_cadastro_id = new Zend_Form_Element_Hidden('pessoa_cadastro_id');
        $pessoa_cadastro_id->setRequired(TRUE);
        $this->addElement($pessoa_cadastro_id);
        
        $local_entrega_id = new Zend_Form_Element_Select('local_entrega_id');
        $local_entrega_id->setLabel('Local Entrega');
        $this->addElement($local_entrega_id);

        $local_coleta_id = new Zend_Form_Element_Select('local_coleta_id');
        $local_coleta_id->setLabel('Local Coleta');
        $this->addElement($local_coleta_id);
        
        $valor = new Zend_Form_Element_Text('valor');
        $valor->setLabel('Valor')->setAttrib('ng-controller', 'MaskMoney');
        $this->addElement($valor);
        
        $forma_faturamento_id = new Zend_Form_Element_Hidden('forma_faturamento_id');
        $this->addElement($forma_faturamento_id);
        
        $this->populaComboEmpresa();
        $this->populaComboStatus();
        $this->populaComboLocalEntregaColeta();

        $this->setDecorators(array(
            array('ViewScript',
                array('viewScript' => 'processos/form-processo.phtml')
            )
        ));

        foreach ($this->getElements() as $element) {
            $element->removeDecorator('HtmlTag');
            $element->removeDecorator('DtDdWrapper');
            $element->setAttrib('ng-model', 'model.' . $element->getName());
        }
    }

    public function populaComboEmpresa() {
        $model = new Application_Model_Pessoa();
        $this->getElement('id_empresa')->addMultiOption(null, '--');

        foreach ($model->fetchAll() as $value) {
            $this->getElement('id_empresa')->addMultiOption($value->id_pessoa, $value->nome_empresa);
        }
    }

    public function populaComboStatus() {
        $model = new Application_Model_StatusProcesso();
        $this->getElement('status_id')->addMultiOption(NULL, '--');
        $arrayEnableOptions = array(1, 5);
        
        foreach ($model->fetchAll() as $value) {
            if(in_array($value->id_status, $arrayEnableOptions)){
                $this->getElement('status_id')->addMultiOption($value->id_status, $value->tx_status);
            }
        }
    }
    
    public function populaComboLocalEntregaColeta() {
        $model = new Application_Model_LocalEntregaColeta();
        $this->getElement('local_entrega_id')->addMultiOption(null, '--');
        $this->getElement('local_coleta_id')->addMultiOption(null, '--');

        foreach ($model->fetchAll() as $value) {
            $this->getElement('local_entrega_id')->addMultiOption($value->id_local_entrega_coleta, $value->tx_local);
            $this->getElement('local_coleta_id')->addMultiOption($value->id_local_entrega_coleta, $value->tx_local);
        }
    }

}
