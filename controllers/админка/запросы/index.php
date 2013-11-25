<?php
class zzRoot extends zzSite {
    protected $rootPath = __FILE__;

    function doInit(){
        if (zzNew('Source_Get')->offsetExists('order')){
            $group = zzNew('Source_Get')->offsetGet('order');
            
            $this->ZZ('Each_Param.orders')->each('setSource' , array(zzSql::Source('Market_Db_Flashrf_Order')->loadByGroup(array('group' => $group))));
        }
        
        zzNew('Source_Cookie')->offsetSet('manager', 1);
    }
}