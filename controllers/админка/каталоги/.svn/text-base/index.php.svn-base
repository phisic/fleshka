<?php
class zzRoot extends zzSite {
    protected $rootPath = __FILE__;

    function doInit(){
        $this->ZZ('Admin_Unit.editor')->each('sqlClass', array(
            new Admin_DataContainer( zzNew('Market_Db_Flashrf_Catalogs') )
        ));
    }
}