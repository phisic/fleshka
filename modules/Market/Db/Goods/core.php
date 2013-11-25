<?php
class Market_Db_Goods{
    static function GoodsFilter($attr = array()){
        //get goods
        if ($attr)
            $goods = zzNew('Market_Db_Goods_GoodsGroup')->loadGoodsByFilter(array(
                'filter' => $attr
            ), 'id');
        else
            $goods = zzNew('Market_Db_Goods_GoodsGroup')->loadGoods('id');

        //get features
        $features = zzNew('Market_Db_Goods_RelGoodsFeature')->getFeaturesByIds(array('ids' => array_keys($goods)));

        //remove unusual
        foreach ($features as $k1 => $fes)
            foreach ($fes as $k2 => $fe )
                switch ($fe['type']){
                    case 'Группа вывода':
                    case 'Основная группа':
                    case 'Логотип':
                    case 'Стиль':
                    case 'Спецпредложение':
                        unset($features[$k1][$k2]);
                }

        $group = array();
        foreach ($goods as $id => $good){
            if (isset($features[$id]))
                $good['features'] = $features[$id];
            else
                $good['features'] = array();

            $groupId = $good['goodsgroup_id'];

            if (!isset($group[$groupId])){
                $group[$groupId] = $good;
                $group[$groupId]['goods'] = array($good);
            }else{
                $group[$groupId]['goods'][] = $good;

                //remove local goods features
                foreach ($group[$groupId]['features'] as $set => $fe1)
                    foreach ($good['features'] as $fe2)
                        if ($fe1['type'] == $fe2['type'] && $fe1['value'] != $fe2['value'])
                            unset($group[$groupId]['features'][$set]);
            }
        }

        return $group;
    }

    static function GoodsOrder($order){
        //get goods
        $goods = zzNew('Market_Db_Goods_GoodsGroup')->loadGoodsByOrder(array(
            'order_id' => $order
        ), 'id');

        if (!$goods)
            return false;

        //get features
        $features = zzNew('Market_Db_Goods_RelGoodsFeature')->getFeaturesByIds(array('ids' => array_keys($goods)));

        //get order counts

        $group = array();
        foreach ($goods as $id => $good){
            if (isset($features[$id]))
                $good['features'] = $features[$id];
            else
                $good['features'] = array();

            $groupId = $good['goodsgroup_id'];

            if (!isset($group['goods'][$groupId])){
                $group['goods'][$groupId] = $good;
                $group['goods'][$groupId]['goods'] = array($good);
            }else{
                $group['goods'][$groupId]['goods'][] = $good;

                //remove local goods features
                foreach ($group['goods'][$groupId]['features'] as $set => $fe1)
                    foreach ($good['features'] as $fe2)
                        if ($fe1['type'] == $fe2['type'] && $fe1['value'] != $fe2['value'])
                            unset($group['goods'][$groupId]['features'][$set]);
            }
        }

        ksort($group);

        return $group;
    }

    static protected function GoodsGroup ($goods){
        foreach ($goods as &$gg) {
            $gg['image'] = array();
            $gg['colors'] = array();
            $gg['size'] = array();
            foreach ($gg['goods'] as $go){
                $gg['image'][] = $go['id'];
                foreach ($go['features'] as $fe){
                    switch ($fe['type']){
                        case "Цвет":
                            if (!isset($gg['colors'][$fe['feature_id']])){
                                $gg['colors'][$fe['feature_id']] = $fe;
                                $gg['colors'][$fe['feature_id']]['imageID'] = $go['id'];
                                $gg['colors'][$fe['feature_id']]['goods'] = $go['id'];
                            }else{
                                $gg['colors'][$fe['feature_id']]['goods'] .= '_'.$go['id'];
                            }
                        break;
                        case "Емкость":
                            if (!isset($gg['size'][$fe['feature_id']])){
                                $gg['size'][$fe['feature_id']] = $fe;
                                $gg['size'][$fe['feature_id']]['goods'] = $go['id'];
                                $gg['size'][$fe['feature_id']]['price'] = $go['price'];
                            }else{
                                $gg['size'][$fe['feature_id']]['goods'] .= '_'.$go['id'];
                            }
                        break;
                    }
                }
            }
            $gg['image'] = implode('_', $gg['image']);
        }unset($gg);
        return $goods;
    }

    static function GoodsFilterGrouped($filter = array()){
        $goods = self::GoodsFilter($filter);

        $goods = self::GoodsGroup ($goods);

        return $goods;
    }

    static function OrderFilterGrouped($orderId){
        $goods = self::GoodsOrder($orderId);

        if (!$goods)
            return false;

        $goods['goods'] = self::GoodsGroup ($goods['goods']);

        return $goods;
    }
}
