<?php
class Market_Goods_Header extends zzTml{
    function __toString() {
        $this->setAttributes(array('date' => date('d.m.Y')));
        
        return parent::__toString();
    }
}