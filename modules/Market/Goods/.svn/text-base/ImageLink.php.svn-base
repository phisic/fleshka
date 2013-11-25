<?php
class Market_Goods_ImageLink extends zzNode{
    protected $source;

    function setSource($source){
        $this->source = $source;
    }

    function __construct($node = null) {
        parent::__construct($node);
        
        $this->setParameters(array(
            'index' => 0
        ));
    }
    
    function __toString() {
        $id = (string)$this->getParameter('goods_id');
        
        $array = $this->source->getIterator();
        
        if (isset($array[$id])){
            $colors = $array[$id];

            $colors = reset($colors);

            return '/p/ph'.$colors['color_group'].'x'.$this->getParameter('index').'.jpg';
        }
        return '/i/404.gif';
    }
}