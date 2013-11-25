<?php
class Market_ColorMaker extends zzTml{
    protected $selected = array();

    function setSelectedArea(array $selected){
        $this->selected = $selected;
    }
    
    function __toString() {
        $var = $this->getAttribute('color')->get();
        
        $this->setAttributes(array(
            'percent' => 100/count($var)
        ));
        
        $this->ZZ('H.selected')->switchBy(in_array((string)$this->getAttribute('id'), $this->selected)?'':'.n');
        
        $this->ZZ('Each')->each('setSource', array($var));

        return parent::__toString();
    }
}