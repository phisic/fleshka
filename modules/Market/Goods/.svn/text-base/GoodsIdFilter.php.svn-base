<?php
class Market_Goods_GoodsIdFilter extends zzSql_Filter{
    protected $idsFilter = null;
    
    function __construct($source, $ids) {
        parent::__construct($source);
        
        $this->idsFilter = $ids;
    }
    
    function getIterator() {
        $goods = $this->source;
        $ids = $this->idsFilter->getIterator();
        
        $result = new ArrayObject();
        foreach ($goods as $good)
            if (isset($ids[$good['id']]))
                $result[] = $good;
        
        return $result;
    }
}