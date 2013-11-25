<?php
class Market_Goods_PDF_Goods extends PDF_Each{
    protected $left = 0;

    function onEachInit($array) {
        $id = (string)$this->getParameter('goods_id');
        
        if (isset($array[$id]))
            return parent::onEachInit($array[$id]);
        
        return array();
    }
}