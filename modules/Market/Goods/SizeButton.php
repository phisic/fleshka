<?php
class Market_Goods_SizeButton extends zzTml{
    protected $selected = array();

    function setSelectedArea(array $selected){
        $this->selected = $selected;
    }
    
    function __toString() {
        $this->ZZ('H.selected')->switchBy(in_array($this->getAttribute('id').'-'.$this->getAttribute('size'), $this->selected)?'':'.n');
        
        return parent::__toString();
    }
}