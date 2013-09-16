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
        $id = new Zend_Form_Element_Hidden('id_processo');
        $this->addElement($id);

        $data_coleta = new Zend_Form_Element_Text('data_coleta_processo', array('class'=>'date'));
        $data_coleta->setLabel('Coleta:')
                ->addErrorMessage(self::erro);
        $this->addElement($data_coleta);

        $empresa = new Zend_Form_Element_Select('pessoa_entrada');
        $empresa->setRequired(true)
                ->setLabel('Empresa:')
                ->addErrorMessage(self::erro);
        $this->addElement($empresa);

        $processo = new Zend_Form_Element_Text('os_processo');
        $processo->setRequired(true)
                ->setLabel('Processo: ')
                ->addErrorMessage(self::erro);
        $this->addElement($processo);

        $nomepax = new Zend_Form_Element_text('nome_pax_processo');
        $nomepax->setRequired(true)
                ->setLabel('Passageiro: ')
                ->addErrorMessage(self::erro);
        $this->addElement($nomepax);

        $qtd_bagagem = new Zend_Form_Element_text('qtd_bagagem_processo');
        $qtd_bagagem->setRequired(true)
                ->setLabel('Quant.: ')
                ->addErrorMessage(self::erro);
        $this->addElement($qtd_bagagem);


        $servico_realizado = new Zend_Form_Element_text('servico_realizado_processo');
        $servico_realizado->setRequired(true)
                ->setLabel('Serviço Realizado: ')
                ->addErrorMessage(self::erro);
        $this->addElement($servico_realizado);


        $data_entrega = new Zend_Form_Element_text('data_entrega_processo', array('class'=>'date'));
        $data_entrega->setLabel('Entrega: ')
                ->addErrorMessage(self::erro);
        $this->addElement($data_entrega);

        $obs = new Zend_Form_Element_text('obs_processo');
        $obs->setRequired(true)
                ->setLabel('Observação: ')
                ->addErrorMessage(self::erro);
        $this->addElement($obs);

        $this->populaComboEmpresa();
        
        $this->setDecorators(array(
            array('ViewScript',
                array('viewScript' => 'processos/form-processo.phtml')
            )
        ));

        foreach ($this->getElements() as $element) {
            $element->removeDecorator('HtmlTag');
            $element->removeDecorator('DtDdWrapper');
        }
    }
    
    public function populaComboEmpresa(){
        $model = new Application_Model_Pessoa();
        $this->getElement('pessoa_entrada')->addMultiOption(null, '--');
        
        foreach($model->fetchAll() as $value){
            $this->getElement('pessoa_entrada')->addMultiOption($value->id_pessoa, $value->nome_pessoa);
        }
    }

}
