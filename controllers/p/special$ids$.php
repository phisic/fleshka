<?php
class zzRoot extends zzSite {
    protected $rootPath = __FILE__;
    
    function onLoad(){
        $ids = $this->urlVars['ids'];
        
        $photo = zzClasses::create('Market_Db_Flashrf_Specialoffer')->photoById(array('id' => $ids), true);

        if (!isset($photo)){
            zzNew('zzView')->redirect('/i/empty.png');
        }elseif (!$photo['photo']){
            zzNew('zzView')->redirect('/i/empty.png');
        }else{
            $this->setParameters($photo);
            
            zzNew('zzView')->setHeader(new Header_Cache(new Header_Image('jpg')));
        }
    }
}