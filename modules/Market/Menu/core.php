<?php
class _Market_Menu_Each extends Each_Param{
    protected $url = false;

    function  onEachInit($array) {
        $this->url = zzRoot::$root->getAttribute('url');

        return parent::onEachInit($array);
    }

    function  onEach($index, $value) {
        $this->ZZ('H.selected')->switchBy(($this->url == $value['url'])?'':'.not');

        return parent::onEach($index, $value);
    }
}

class Market_Menu extends zzTml{
    function  __construct() {
        parent::__construct();

        $this->ZZ('Each.marketmenu')
            ->each('setSource', array(
                zzNew('Market_Db_Goods_Catalog')->loadMenuCatalog()
            ));

        $this->ZZ('Each.marketmenu2')
            ->each('setSource', array(
                zzNew('Market_Db_Goods_Texts')->loadMenuCatalog()
            ));

        if (zzNew('Source_Cookie')->exists('orderID'))
            $this->ZZ('H.order')->each('show')->each('setParameters', array(array(
                'order' => zzNew('Source_Cookie')->get('orderID')
            )));

        if (zzNew('Source_Cookie')->exists('catalogue') && zzNew('Source_Cookie')->get('catalogue') == 2){
            $this->setAttributes(array('catname' => 'прайс'));
        }else{
            $this->setAttributes(array('catname' => 'каталог'));
        }
    }

    function setCatalogue($number){
        zzNew('Source_Cookie')->set('catalogue', $number);

        if (zzNew('Source_Cookie')->get('catalogue') == 2){
            $this->setAttributes(array('catname' => 'прайс'));
        }else{
            $this->setAttributes(array('catname' => 'каталог'));
        }
    }
}