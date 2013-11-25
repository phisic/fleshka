<?php
class Market_Goods_PDF_GroupCatalogs extends zzSql_Filter{
    protected $catalogs = null;
    
    function __construct($source, $catalogs) {
        parent::__construct($source);
        
        $this->catalogs = $catalogs;
    }
    
    function getIterator() {
        $goods = $this->source;

        $sorted = new ArrayObject();
        foreach ($goods as $_)
            $sorted[$_['id']] = $_;
        
        $result = new ArrayObject();
        foreach ($this->catalogs as $id => $goods)
            foreach ($goods as $good)
                if (isset($sorted[$good['goods_id']]))
                    $result[$id][] = $sorted[$good['goods_id']];
        
        return $result;
    }
}