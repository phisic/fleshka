<?php
class Market_Goods_Empty extends zzNode{
    protected $sources = array();

    function addSource($source){
        if (is_array($source))
            return $this;
            
        $this->sources[] = $source;
        
        return $this;
    }
    
    function __toString() {
        foreach($this->sources as $source)
            if (count($source))
                return '';
        
        return parent::__toString();
    }
}