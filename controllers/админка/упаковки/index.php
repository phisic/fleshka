<?php
class zzRoot extends zzSite {
    protected $rootPath = __FILE__;

    function doInit(){
        $this->ZZ('Admin_Unit.editor')->each('sqlClass', array(
            new Admin_DataContainer( zzNew('Market_Db_Flashrf_DescriptionPrice') )
        ));

        $this->ZZ('Admin_Unit.searcher')->each('sqlClass', array(
            new Admin_DataContainer( 
                zzNew('Market_Db_Flashrf_Search') 
            )
        ));

        $this->ZZ('Admin_Unit.colors')->each('sqlClass', array(
            new Admin_DataContainer( zzNew('Market_Db_Flashrf_Colorprice') )
        ));

        $this->ZZ('Admin_Unit.colorchange')->each('sqlClass', array(
            new Admin_DataContainer( zzNew('Market_Db_Flashrf_Colorprice'), 'colors' )
        ));

        $this->ZZ('Admin_Image_Link.photo, Admin_Unit.photo')->each('sqlClass', array(
            new Admin_PhotoContainer( zzNew('Market_Db_Flashrf_Photos') )
        ));

        $this->ZZ('Admin_Unit.catalogs')->each('sqlClass', array(
            new Admin_DataContainer( zzNew('Market_Db_Flashrf_RelGoodsCatalog') )
        ));

        $this->ZZ('Options.selectedcatalogs')->each('setSource', array(
            zzNew('Market_Db_Flashrf_Catalogs')->adminList()
        ));

        $this->ZZ('Options.selectedcolors')->each('setSource', array(
            zzNew('Market_Db_Flashrf_Colors')->adminList()
        ));
    }
}