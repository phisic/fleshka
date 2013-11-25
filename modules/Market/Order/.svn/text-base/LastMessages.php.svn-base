<?php
class Market_Order_LastMessages extends zzSql_Filter{
    protected $count = 2;
    
    function __construct($source, $count) {
        parent::__construct($source);
        
        $this->count = $count;
    }
    
    function getIterator() {
        $result = $this->source;
        
        return array_slice((array)$result->getIterator(), -$this->count);
    }
}