<?php
class Market_Goods_ColorIdFilter extends zzSql_Filter{
    protected $colorFilter = null;
    
    function __construct($source, $color) {
        parent::__construct($source);
        
        $this->colorFilter = $color;
    }
    
    function getIterator() {
        $goods = $this->source;
        
        $result = new ArrayObject();
        foreach ($goods as $goodId => $good){
            foreach($good as $colors){
                foreach($colors['color_html'] as $color){
                    if ($color['color_id'] == $this->colorFilter){
                        $result[$goodId][] = $colors;
                        break;
                    }
                }
            }
        }
        
        return $result;
    }
}