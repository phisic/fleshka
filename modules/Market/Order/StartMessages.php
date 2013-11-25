<?php
class Market_Order_StartMessages extends zzSql_Filter{
    protected $count = 2;
    
    function __construct($source, $count) {
        parent::__construct($source);
        
        $this->count = $count;
    }
    
    function getIterator() {
        $result = $this->source;
        
        return array_slice((array)$result->getIterator(), 0, -$this->count);
    }
}