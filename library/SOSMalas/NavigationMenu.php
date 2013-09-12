<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NavigationMenu
 *
 * @author rafabrun2006
 */
class SOSMalas_NavigationMenu {

    const MENU_LEVEL = 1;
    const MENU_OPTIONS = 3;

    public $module;
    public $menu = array();

    public function getModule() {
        return $this->module;
    }

    public function setModule($module) {
        $this->module = strtolower($module);
    }

    public function mountMenu() {
        $navigationXml = new Zend_Config_Xml(APPLICATION_PATH . '/configs/navigation.xml', $this->getModule());
        
        foreach ($navigationXml as $value) {
            
            $actionType = explode('|', $value->actionType);
            
            $this->menu[] = array(
                'label' => $value->label,
                'link' => "/{$value->module}/{$value->controller}"
            );
        }
        
        return $this;
    }
    
    public function getMenuActions(array $actions){
        $arrayActions = array();
        
        foreach($actions as $key=>$value){
            if($value->level == self::MENU_LEVEL){
                $arrayActions[] = $key;
            }
        }
        
        return $arrayActions;
    }

}