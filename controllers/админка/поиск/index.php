<?php
class zzRoot extends zzSite {
    protected $rootPath = __FILE__;

    function doInit(){
        $this->ZZ('Each_Param.search')->each('setSource' , array(zzSql::Source('Market_Db_Flashrf_SearchLog')->logList()));
    }
}