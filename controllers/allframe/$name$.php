<?php
class zzRoot extends zzSite {
    protected $rootPath = __FILE__;

    function doInit(){
        if (!$this->urlVars['name'] || $this->urlVars['name'] == 'index'){
            $this->urlVars['name'] = '';
        }
        
        $goods = zzNew('Market_Goods');
        if (!$goods->loadGoods( $this->urlVars['name'] )){
            zzNew('zzView')->redirect('/прайс/');
            return ;
        }
        
        if (zzNew('Source_Get')->offsetExists('color'))
            $goods->filterGoodsByColor( zzNew('Source_Get')->offsetGet('color') );
        
        if (zzNew('Source_Get')->offsetexists('instock'))
            $goods->filterGoodsByInStock( zzNew('Source_Get')->offsetGet('instock') );
        else
            $goods->filterGoodsByInStock( 1 );
        
        $goods->tmlSetup($this);
        
        $this->ZZ('Market_Goods_MenuSelect')->each('checkFor', array( $this->urlVars['name'] ));
    }
}
