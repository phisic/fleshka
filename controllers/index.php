<?php
class zzRoot extends zzSite {
    protected $rootPath = __FILE__;

    function doInit(){
        $this->ZZ('Each_Param.catalogs')->each('setSource', array(
            zzSql::Source('Market_Db_Flashrf_Catalogs')->listMenu()
        ));

        $this->ZZ('Admin_Image_Link.showcase')->each('sqlClass', array(
            new Admin_PhotoContainer( zzNew('Market_Db_Flashrf_Showcase') )
        ));
        
        $this->ZZ('Each_Param.showcase')->each('setSource', array(
            zzSql::Source('Market_Db_Flashrf_Showcase')->listShowcase()
        ));

        
    }
}
