<?php
class Market_Goods_Menu extends zzTml{
    function __toString() {
        $this->ZZ('Each_Param')->each('setSource', array(
            zzSql::Source('Market_Db_Flashrf_Catalogs')->listMenu()
        ));
        
        return parent::__toString();
    }
}