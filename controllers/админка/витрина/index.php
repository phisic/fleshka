<?php
class zzRoot extends zzSite {
    protected $rootPath = __FILE__;

    function doInit(){
//        var_dump($this->ZZ('Admin_Block.editor')->countResult());
        
        $this->ZZ('Admin_Unit.editor, Admin_Image_Link.photo')->each('sqlClass', array(
            new Admin_PhotoContainer( zzNew('Market_Db_Flashrf_Showcase') )
        ));
    }
}