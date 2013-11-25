<?php
class Market_Goods_AllPhotos extends zzNode{
    protected $source;

    function setSource($source){
        $this->source = $source;
    }

    function __toString() {
        $id = (string)$this->getParameter('goods_id');
        
        $array = $this->source->getIterator();
        
        if (isset($array[$id])){
            $result = new ArrayObject();
            for($i = 0; $i<$array[$id]['count']; $i++){
                $this->setAttributes(array('number' => $i));
                $result[] = parent::__toString();
            }
            
            return implode('', (array)$result);
        }
        
        return '';
    }
}