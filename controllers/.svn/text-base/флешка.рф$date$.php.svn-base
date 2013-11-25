<?php
class zzRoot extends zzSite {
    protected $rootPath = __FILE__;

    function doInit(){
        $goods = zzNew('Market_Goods');
        
        $goods->loadAllGoods();
        
        $goods->groupGoodsByCatalogs();
        
        $goods->tmlPDFSetup($this);
        
        $this->ZZ('PDF_EachCounter')->each('setArray', array(
            array(
                array(
                    'left1' => 10,'left2' => 26,'top1' => 25,'top2' => 32,'top3' => 35.5,'top4' => 45
                ),
                array(
                    'left1' => 110,'left2' => 126,'top1' => 25,'top2' => 32,'top3' => 35.5,'top4' => 45
                ),
                array(
                    'left1' => 10,'left2' => 26,'top1' => 105,'top2' => 112,'top3' => 115.5,'top4' => 125
                ),
                array(
                    'left1' => 110,'left2' => 126,'top1' => 105,'top2' => 112,'top3' => 115.5,'top4' => 125
                ),
                array(
                    'left1' => 10,'left2' => 26,'top1' => 185,'top2' => 192,'top3' => 195.5,'top4' => 205
                ),
                array(
                    'left1' => 110,'left2' => 126,'top1' => 185,'top2' => 192,'top3' => 195.5,'top4' => 205
                ),
            )
        ));
        
        $this->setAttributes(array('datetime' => date('Y-m-d H:i:s')));
        
        zzNew('zzView')->setHeader(new PDF_Header('Flashka_rf_catalog.'.date('d.m.Y')));
    }
}