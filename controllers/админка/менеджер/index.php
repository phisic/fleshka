<?php
class zzRoot extends zzSite {
    protected $rootPath = __FILE__;

    function doInit(){
        $this->ZZ('Admin_Unit.editor')->each('sqlClass', array(
            new Admin_DataContainer( zzNew('Manager_Db_Managers_User') )
        ));
    }
}