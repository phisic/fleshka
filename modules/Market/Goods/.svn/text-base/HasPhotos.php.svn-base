<?php
class Market_Goods_HasPhotos extends zzNode{
    protected $source;

    function setSource($source){
        $this->source = $source;
    }

    function __toString() {
        $id = (string)$this->getParameter('goods_id');
        
        $array = $this->source->getIterator();
        
        if (isset($array[$id]) && $array[$id]['count'] > 1){
            return parent::__toString();
        }
        
        return '';
    }
}