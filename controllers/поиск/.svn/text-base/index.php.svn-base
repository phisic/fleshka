<?php
class _SearchForm extends Form{
    protected $goods = null;

    function __construct($node = null){
        parent::__construct($node);
        
        $this->setAttributes(array(
            'name' => 's'
        ));
        
        $this->setParameters(array(
            'prefix' => 'f'
        ));
    }
    
    function setGoods($goods){
        $this->goods = $goods;
    }
    
    function onOk($fields){
        $values = $this->getFieldsValues($fields);
        
        $this->goods->searchGoods( $values['search'] );
    }
}

class zzRoot extends zzSite {
    protected $rootPath = __FILE__;

    function doInit(){
    }
    
    function onLoad(){
        $goods = zzNew('Market_Goods');
        $this->ZZ('_SearchForm')->each('setGoods', array($goods));
        
        parent::onLoad();
        
        $goods->tmlSetup($this);
    }
}
