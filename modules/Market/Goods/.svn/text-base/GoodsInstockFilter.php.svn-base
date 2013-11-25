<?php
class Market_Goods_GoodsInstockFilter extends zzSql_Filter{
    protected $instockFilter = null;
    
    function __construct($source, $instock) {
        parent::__construct($source);
        
        $this->instockFilter = $instock;
    }
    
    function getIterator() {
        $goods = $this->source;
        
        $result = new ArrayObject();
        foreach ($goods as $good)
            if ($good['instock'] == $this->instockFilter)
                $result[] = $good;
        
        return $result;
    }
}