<?php

class Admin_Form_Coleta extends Zend_Form {

    const erro = 'Campo de preenchimento obrigatório!';

    function init() {
        $os = new Zend_Form_Element_Hidden('os');
        $this->addElement($os);

        $cliente = new Zend_Form_Element_Text('cliente');
        $cliente->setRequired(true)
                ->addErrorMessage(self::erro);
        $this->addElement($cliente);

        $email = new Zend_Form_Element_Text('email');
        $email->setRequired(true)
                ->addErrorMessage(self::erro);
        $this->addElement($email);

        $data_pedido = new Zend_Form_Element_Text('data_pedido');
        $data_pedido->setRequired(true)
                ->addErrorMessage(self::erro)
        ;

        $this->addElement($data_pedido);

        $endereco = new Zend_Form_Element_text('endereco');
        $endereco->setRequired(true)
                ->addErrorMessage(self::erro)
                //->addValidator(new Zend_Validate_Identical('senha'))
        ;
        $this->addElement($endereco);

        $ponto_referencia = new Zend_Form_Element_text('ponto_referencia');
        $ponto_referencia->setRequired(true)
                ->addErrorMessage(self::erro)
                //->addValidator(new Zend_Validate_Identical('senha'))
        ;
        $this->addElement($ponto_referencia);

        $fone_fixo = new Zend_Form_Element_text('fone_fixo');
        $fone_fixo->setRequired(true)
                ->addErrorMessage(self::erro)
                //->addValidator(new Zend_Validate_Identical('senha'))
        ;
        $this->addElement($fone_fixo);

        $pcm = new Zend_Form_Element_text('pcm');
        $pcm->setRequired(true)
                ->addErrorMessage(self::erro)
                //->addValidator(new Zend_Validate_Identical('senha'))
        ;
        $this->addElement($pcm);

        $previsao_coleta = new Zend_Form_Element_text('previsao_coleta');
        $previsao_coleta->setRequired(true)
                ->addErrorMessage(self::erro)
                //->addValidator(new Zend_Validate_Identical('senha'))
        ;
        $this->addElement($previsao_coleta);

        $tipo = new Zend_Form_Element_text('tipo');
        $tipo->setRequired(true)
                ->addErrorMessage(self::erro)
                //->addValidator(new Zend_Validate_Identical('senha'))
        ;
        $this->addElement($tipo);

        $status = new Zend_Form_Element_Text('status');
        $status->setRequired(true)
                ->addErrorMessage(self::erro)
                //->addValidator(new Zend_Validate_Identical('senha'))
        ;
        $this->addElement($status);

        foreach($this->getElements() as $element ) {
            $element->removeDecorator('label')->removeDecorator('htmltag');
        }
    }
}
