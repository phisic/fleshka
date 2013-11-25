<?php
class Market_Goods_GoodsColors extends Each_Param{
    function onEachInit($array) {
        $id = (string)$this->getParameter('goods_id');
        
        if (isset($array[$id]))
            return parent::onEachInit($array[$id]);
        
        return array();
    }
}