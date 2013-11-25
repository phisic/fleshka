<?php
class Market_Goods_Minus extends zzNode_PointerInside{
    function __construct($node = null) {
        parent::__construct($node);
        
        $this->setAttributes(array('minus' => 0));
    }
    
    function __toString() {
        $price = parent::__toString();
        
        return (string)(int)($price-(string)$this->getAttribute('minus'));
    }
}