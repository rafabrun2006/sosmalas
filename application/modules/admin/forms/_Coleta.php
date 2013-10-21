<?php

class Admin_Form_Coleta extends Zend_Form {

    const erro = 'Campo de preenchimento obrigatório!';

    function init() {
        $os = new Zend_Form_Element_Hidden('os_coleta');
        $this->addElement($os);
        
        $cliente = new Zend_Form_Element_Text('cliente_email');
        $cliente->setRequired(true)
                ->addErrorMessage(self::erro);
        $this->addElement($cliente);

        $data_pedido = new Zend_Form_Element_Text('data_pedido_coleta', array('class'=>'date'));
        $data_pedido->setRequired(true)
                ->addErrorMessage(self::erro)
        ;

        $this->addElement($data_pedido);

        $pcm = new Zend_Form_Element_text('pcm_coleta');
        $pcm->setRequired(true)
                ->addErrorMessage(self::erro)
        ;
        $this->addElement($pcm);

        $previsao_coleta = new Zend_Form_Element_text('previsao_coleta', array('class'=>'date'));
        $previsao_coleta->setRequired(true)
                ->addErrorMessage(self::erro)
        ;
        $this->addElement($previsao_coleta);

        $tipo = new Zend_Form_Element_text('tipo_coleta');
        $tipo->setRequired(true)
                ->addErrorMessage(self::erro)
        ;
        $this->addElement($tipo);

        $status = new Zend_Form_Element_Select('status_coleta');
        $status->setRequired(true)
                ->addErrorMessage(self::erro)
        ;
        $this->addElement($status);

        foreach($this->getElements() as $element ) {
            $element->removeDecorator('label')->removeDecorator('htmltag');
        }
        
        $this->populaStatusColeta();
        
        $this->setDecorators(array(
            array('ViewScript',
                array('viewScript' => 'coleta/form-coleta.phtml')
            )
        ));
    }
    
    public function populaStatusColeta(){
        $statusColeta = new Application_Model_StatusColeta();
        
        $this->getElement('status_coleta')->addMultiOption(null, '--');
        
        foreach($statusColeta->fetchAll() as $value){
            $this->getElement('status_coleta')->addMultiOption($value->id_status_coleta, $value->nome_status_coleta);
        }
    }
}
