<?php
class zzRoot extends zzSite {
    protected $rootPath = __FILE__;
    
    function onLoad(){
        $ids = explode('_', $this->urlVars['ids']);

        $photo = zzClasses::create('Market_Db_Goods_Userphotos')->getThumbByIds(array('ids' => $ids), true);

        if (!$photo){
            zzRoot::redirect('/i/404.gif');
        }else{
            header('Content-Type: image/jpg');

            $this->setParameters($photo);
        }
    }
}