<?php
class Market_Goods{
    protected $price = array(),$photos = array(),$goods = array(), $colors = array(), $variables = array(), $filterColors = array(), $catalogs = array();
    protected $warehouseFilter = true;
    protected $selectedColors = array();
    protected $selectedSizes = array();

    function filterGoodsByColor($color){
        if ($color){
            $this->variables['colorFilter'] = $color;
            
            $this->colors = new Market_Goods_ColorIdFilter($this->colors, $color);
            
            $this->goods = new Market_Goods_GoodsIdFilter($this->goods, $this->colors);
            
            $this->price = new Market_Goods_GoodsIdFilter($this->price, $this->colors);
        }
        
        return $this;
    }

    function groupGoodsByCatalogs(){
        $this->catalogs = zzNew('Market_Db_Flashrf_Catalogs')->listMenu('id');
        
        $rel = zzNew('Market_Db_Flashrf_Catalogs')->goodsId();
        
        $this->goods = new Market_Goods_PDF_GroupCatalogs($this->goods, $rel);

        $this->price = new Market_Goods_PDF_GroupCatalogs($this->price, $rel);
        
        return $this;
    }
    
    function filterGoodsByInstock($instock){
        $this->variables['instockFilter'] = $instock;
            
        $this->goods = new Market_Goods_GoodsInstockFilter($this->goods, $instock);
        $this->price = new Market_Goods_GoodsInstockFilter($this->price, $instock);
        
        return $this;
    }
    
    function loadWareFilter($warehouse){
        $this->warehouseFilter = $warehouse;
        
        return $this;
    }

    function loadGoodsFromOrder($order){
        $order = zzNew('Market_Db_Flashrf_Order')->load(array('order_id' => $order), true);
        
        if (!$order)
            return false;
        
        $cookie = zzNew('Source_Cookie');
        if ($cookie->offsetExists('order_id') && $cookie->offsetGet('order_id') == $order['order_id'] && $cookie->offsetExists('colors') && $cookie->offsetExists('sizes')){
            $order['sizes'] = implode('_', array_unique( array_merge(explode('_', $order['sizes']), explode('_', $cookie->offsetGet('sizes')))));
            $order['colors'] = implode('_', array_unique( array_merge(explode('_', $order['colors']), explode('_', $cookie->offsetGet('colors')))));
            zzNew('Market_Db_Flashrf_Order')->updateGoods($order);
            
            $cookie->offsetUnset('order_id');
            $cookie->offsetUnset('sizes');
            $cookie->offsetUnset('colors');
        }
        
        $goodsId = array();

        $sizes = explode('_', $order['sizes']);
        foreach($sizes as $_){
            $_ = explode('-', $_);
            $goodsId[$_[0]] = $_[0];
        }
        
        $goodsId = new zzSql_Filter_Keys($goodsId);
        
        $goods = new zzSql_Filter_Cache(
            zzSql::Source('Market_Db_Flashrf_DescriptionSize')->goodsByIds(array('ids' => $goodsId))
        );
        
        $price = new zzSql_Filter_Cache(
            zzSql::Source('Market_Db_Flashrf_DescriptionPrice')->goodsByIds(array('ids' => $goodsId))
        );
        
        $colors = new zzSql_Filter_Cache(
            new zzSql_Filter_Group(
                zzSql::Source('Market_Db_Flashrf_Colorprice')->colorsByGoodsIds(array('ids' => $goodsId)),
                'ident'
            )
        );
        
        $this->filterColors = new Market_Goods_ColorsFormFilter(
            $colors
        );
        
        $this->variables = $order;
        
        $this->goods = $goods;
        $this->price = $price;
        $this->colors = $colors;
        
        $this->selectedColors = explode('_', $order['colors']);
        $this->selectedSizes = explode('_', $order['sizes']);
        
        return $this;
    }    
    
    function loadGoodsFromOrderCookie(){
        $cookie = zzNew('Source_Cookie');
        if ($cookie->offsetExists('sizes') && $cookie->offsetExists('colors')){
            $goodsId = array();

            $sizes = explode('_', $cookie->offsetGet('sizes'));
            foreach($sizes as $_){
                $_ = explode('-', $_);
                $goodsId[$_[0]] = $_[0];
            }
        }else{
            $goodsId = array();
        }
        
        $goodsId = new zzSql_Filter_Keys($goodsId);
        
        $goods = new zzSql_Filter_Cache(
            zzSql::Source('Market_Db_Flashrf_DescriptionSize')->goodsByIds(array('ids' => $goodsId))
        );
        
        $price = new zzSql_Filter_Cache(
            zzSql::Source('Market_Db_Flashrf_DescriptionPrice')->goodsByIds(array('ids' => $goodsId))
        );
        
        $colors = new zzSql_Filter_Cache(
            new zzSql_Filter_Group(
                zzSql::Source('Market_Db_Flashrf_Colorprice')->colorsByGoodsIds(array('ids' => $goodsId)),
                'ident'
            )
        );
        
        $this->filterColors = new Market_Goods_ColorsFormFilter(
            $colors
        );
        
        $this->goods = $goods;
        $this->price = $price;
        $this->colors = $colors;
        
        $cookie = zzNew('Source_Cookie');
        $this->selectedColors = array();
        $this->selectedSizes = array();
        if ($cookie->offsetExists('colors'))
            $this->selectedColors = explode('_', $cookie->offsetGet('colors'));
        if ($cookie->offsetExists('sizes'))
            $this->selectedSizes = explode('_', $cookie->offsetGet('sizes'));
        
        return $this;
    }

    function loadAllGoods(){
        $goodsId = zzNew('Market_Db_Flashrf_Catalogs')->allGoodsId('id');
        
        if (!$goodsId)
            return false;
        
        $goodsId = new zzSql_Filter_Keys($goodsId);
        
        $goods = new zzSql_Filter_Cache(
            zzSql::Source('Market_Db_Flashrf_DescriptionSize')->goodsByIds(array('ids' => $goodsId))
        );
        
        $price = new zzSql_Filter_Cache(
            zzSql::Source('Market_Db_Flashrf_DescriptionPrice')->goodsByIds(array('ids' => $goodsId))
        );
        
        $colors = new zzSql_Filter_Cache(
            new zzSql_Filter_Group(
                zzSql::Source('Market_Db_Flashrf_Colorprice')->colorsByGoodsIds(array('ids' => $goodsId)),
                'ident'
            )
        );
        
        $cookie = zzNew('Source_Cookie');
        if ($cookie->offsetExists('order_id'))
            $this->variables['myorder'] = $cookie->offsetGet('order_id');
                
        $this->filterColors = new Market_Goods_ColorsFormFilter(
            $colors
        );
        
        $this->goods = $goods;
        $this->price = $price;
        $this->colors = $colors;

        $this->selectedColors = array();
        $this->selectedSizes = array();
        $cookie = zzNew('Source_Cookie');
        if ($cookie->offsetExists('colors'))
            $this->selectedColors = explode('_', $cookie->offsetGet('colors'));
        if ($cookie->offsetExists('sizes'))
            $this->selectedSizes = explode('_', $cookie->offsetGet('sizes'));
        
        return $this;
    }

    function loadGoods($name){
        $goodsId = zzNew('Market_Db_Flashrf_Catalogs')->goodsIdByCatalogName(array('name' => $name), 'id');
        
        if (!$goodsId)
            return false;
        
        $goodsId = new zzSql_Filter_Keys($goodsId);
        
        $this->variables = zzNew('Market_Db_Flashrf_Catalogs')->catalogByName(array('name' => $name), true);

        $goods = new zzSql_Filter_Cache(
            zzSql::Source('Market_Db_Flashrf_DescriptionSize')->goodsByIds(array('ids' => $goodsId))
        );
        
        $price = new zzSql_Filter_Cache(
            zzSql::Source('Market_Db_Flashrf_DescriptionPrice')->goodsByIds(array('ids' => $goodsId))
        );

        $colors = new zzSql_Filter_Cache(
            zzSql::Source('Market_Db_Flashrf_Colorprice')->colorsByGoodsIds(array('ids' => $goodsId))
        );
        
        $this->photos = new zzSql_Filter_Cache(
            new Market_Goods_PhotoFilter(
                zzSql::Source('Market_Db_Flashrf_Photos')->photosIdByGoodsIds(
                    array('ids' => new zzSql_Filter_Keys($colors)), 'ident'
                ), $colors
            )
        );
        
        $colors = new zzSql_Filter_Cache(
            new zzSql_Filter_Group( $colors, 'ident')
        );

        $cookie = zzNew('Source_Cookie');
        if (isset($cookie['order_id']))
            $this->variables['myorder'] = $cookie['order_id'];
                
        $this->filterColors = new Market_Goods_ColorsFormFilter(
            $colors
        );
        
        $this->goods = $goods;
        $this->price = $price;
        $this->colors = $colors;

        $this->selectedColors = array();
        $this->selectedSizes = array();
        $cookie = zzNew('Source_Cookie');
        if (isset($cookie['colors']))
            $this->selectedColors = explode('_', $cookie['colors']);
        if (isset($cookie['sizes']))
            $this->selectedSizes = explode('_', $cookie['sizes']);
        
        return $this;
    }
    
    function loadSpecialofferGoods(){
        $goodsId = zzNew('Market_Db_Flashrf_Specialoffer')->adminList('id');
        
        if (!$goodsId)
            return false;
        
        $goodsId = new zzSql_Filter_Keys($goodsId);
        
        $goods = new zzSql_Filter_Cache(
            zzSql::Source('Market_Db_Flashrf_DescriptionSize')->goodsOfferByIds(array('ids' => $goodsId))
        );
        
        $price = new zzSql_Filter_Cache(
            zzSql::Source('Market_Db_Flashrf_DescriptionPrice')->goodsOfferByIds(array('ids' => $goodsId))
        );

        $colors = new zzSql_Filter_Cache(
            zzSql::Source('Market_Db_Flashrf_Colorprice')->colorsByGoodsIds(array('ids' => $goodsId))
        );
        
        $this->photos = new zzSql_Filter_Cache(
            new Market_Goods_PhotoFilter(
                zzSql::Source('Market_Db_Flashrf_Photos')->photosIdByGoodsIds(
                    array('ids' => new zzSql_Filter_Keys($colors->getIterator())), 'ident'
                ), $colors
            )
        );
        
        $colors = new zzSql_Filter_Cache(
            new zzSql_Filter_Group( $colors, 'ident')
        );

        $cookie = zzNew('Source_Cookie');
        if ($cookie->offsetExists('order_id'))
            $this->variables['myorder'] = $cookie->offsetGet('order_id');
                
        $this->filterColors = new Market_Goods_ColorsFormFilter(
            $colors
        );
        
        $this->goods = $goods;
        $this->price = $price;
        $this->colors = $colors;

        $this->selectedColors = array();
        $this->selectedSizes = array();
        $cookie = zzNew('Source_Cookie');
        if ($cookie->offsetExists('colors'))
            $this->selectedColors = explode('_', $cookie->offsetGet('colors'));
        if ($cookie->offsetExists('sizes'))
            $this->selectedSizes = explode('_', $cookie->offsetGet('sizes'));
        
        return $this;
    }
    
    function searchGoods($search){
        $words = explode(' ', (string)$search);

        $goodsId = array();
        foreach($words as $_)
            $goodsId = $goodsId + (array)zzNew('Market_Db_Flashrf_Search')->goodsIdBySearchWord(array('word' => trim($_)), 'id');
        
        //log goods
        $log = zzNew('Market_Db_Flashrf_SearchLog')->logUpdate(array(
            'phrase' => (string)$search, 'results' => count($goodsId)
        ), true);
        
        if ($log['rows'] == 0)
            zzNew('Market_Db_Flashrf_SearchLog')->logCreate(array(
                'phrase' => (string)$search, 'results' => count($goodsId)
            ));
        
        if (!$goodsId){
            return false;
        }
        
        $this->variables['search'] = $search;
            
        $goodsId = new zzSql_Filter_Keys($goodsId);
        
        $goods = new zzSql_Filter_Cache(
            zzSql::Source('Market_Db_Flashrf_DescriptionSize')->goodsByIds(array('ids' => $goodsId))
        );
        
        $price = new zzSql_Filter_Cache(
            zzSql::Source('Market_Db_Flashrf_DescriptionPrice')->goodsByIds(array('ids' => $goodsId))
        );
        
        $colors = new zzSql_Filter_Cache(
            zzSql::Source('Market_Db_Flashrf_Colorprice')->colorsByGoodsIds(array('ids' => $goodsId))
        );
        
        $this->photos = new zzSql_Filter_Cache(
            new Market_Goods_PhotoFilter(
                zzSql::Source('Market_Db_Flashrf_Photos')->photosIdByGoodsIds(
                    array('ids' => new zzSql_Filter_Keys($colors->getIterator())), 'ident'
                ), $colors
            )
        );
        
        $colors = new zzSql_Filter_Cache(
            new zzSql_Filter_Group( $colors, 'ident')
        );

        $cookie = zzNew('Source_Cookie');
        if ($cookie->offsetExists('order_id'))
            $this->variables['myorder'] = $cookie->offsetGet('order_id');
                
        $this->filterColors = new Market_Goods_ColorsFormFilter(
            $colors
        );
        
        $this->goods = $goods;
        $this->price = $price;
        $this->colors = $colors;

        $this->selectedColors = array();
        $this->selectedSizes = array();
        $cookie = zzNew('Source_Cookie');
        if ($cookie->offsetExists('colors'))
            $this->selectedColors = explode('_', $cookie->offsetGet('colors'));
        if ($cookie->offsetExists('sizes'))
            $this->selectedSizes = explode('_', $cookie->offsetGet('sizes'));
        
        return $this;
    }
    
    function tmlSetup($tml){
        if ($this->goods)
            $this->goods = new zzSql_Filter_Cache($this->goods);
        
        if ($this->price)
            $this->price = new zzSql_Filter_Cache($this->price);
        
        $tml->ZZ('Market_Goods_Var')->each('setParameters', array($this->variables));

        $tml->ZZ('Market_Goods_Size')->each('setSource', array(
            $this->goods
        ));
        
        $tml->ZZ('Market_Goods_Price')->each('setSource', array(
            $this->price
        ));
        
        $tml->ZZ('Market_Goods_InSearch, Market_Goods_Empty')
            ->each('addSource', array($this->goods))
            ->each('addSource', array($this->price));
        
        if ($this->selectedColors)
            $tml->ZZ('Market_ColorMaker')->each('setSelectedArea', array($this->selectedColors));
        
        if ($this->selectedSizes)
            $tml->ZZ('Market_Goods_SizeButton')->each('setSelectedArea', array($this->selectedSizes));

        $tml->ZZ('Market_Goods_HasPhotos, Market_Goods_AllPhotos')->each('setSource', array(
            $this->photos
        ));
        
        $tml->ZZ('Market_Goods_GoodsColors, Market_Goods_ImageLink')->each('setSource', array(
            $this->colors
        ));
        
        $tml->ZZ('Market_Goods_ColorsForm')->each('setSource', array(
            $this->filterColors
        ));
    }

    function tmlPDFSetup($tml){
        $tml->ZZ('Market_Goods_Var')->each('setParameters', array($this->variables));

        $tml->ZZ('Market_Goods_PDF_Goods.goods')->each('setSource', array(
            $this->goods
        ));
        
        $tml->ZZ('PDF_Each.catalogs')->each('setSource', array(
            $this->catalogs
        ));
        
        $tml->ZZ('Market_Goods_PDF_Goods.price')->each('setSource', array(
            $this->price
        ));
        
        $tml->ZZ('Market_Goods_PDF_GoodsColors, Market_Goods_PDF_ImageLink')->each('setSource', array(
            $this->colors
        ));
    }
}