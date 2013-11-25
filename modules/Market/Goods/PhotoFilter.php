<?php
class Market_Goods_PhotoFilter extends zzSql_Filter{
    protected $photos;

    function  __construct($photos, $source) {
        $this->photos = $photos;
        $this->source = $source;
    }

    function getIterator() {
        $colors = $this->source;
        $photos = $this->photos->getIterator();
        
        $result = new ArrayObject();
        foreach($colors as $color)
            if (isset($photos[$color['id']]))
                $result[$color['ident']] = $photos[$color['id']];
        
        return $result;
    }
}