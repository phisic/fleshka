<?php
class zzRoot extends zzSite {
    protected $rootPath = __FILE__;

    function doInit(){
        $this->ZZ('Market_Goods_MenuSelect')->each('checkFor', array( 'special' ));
        
        $goods = zzNew('Market_Goods');
        if (!$goods->loadSpecialofferGoods()){
            zzNew('zzView')->redirect('/прайс/');
            return ;
        }
        
        $goods->tmlSetup($this);
    }
}
