<?php
class Market_Goods_ColorMaker extends zzTml{
    function  __toString() {
        $var = $this->getAttribute('color')->get();
        
        $this->setParameters($var);
        
        $this->ZZ('H.selected')->switchBy(
            (string)$this->getAttribute('selected') == (string)$var['color_id']?'':'.n'
        );

        return parent::__toString();
    }
}