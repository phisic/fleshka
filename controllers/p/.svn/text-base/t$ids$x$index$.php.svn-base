<?php
class zzRoot extends zzSite {
    protected $rootPath = __FILE__;
    
    function onLoad(){
        $ids = $this->urlVars['ids'];
        $index = $this->urlVars['index'];
        
        $photo = zzClasses::create('Market_Db_Flashrf_Photos')->photoThumbsByIdent(array('id' => $ids));

        if (!isset($photo[$index])){
            zzNew('zzView')->redirect('/i/404.gif');
        }else{
            $this->setParameters($photo[$index]);
            
            zzNew('zzView')->setHeader(new Header_Cache(new Header_Image('jpg')));
        }
    }
}