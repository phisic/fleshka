<?php
class Market_Goods_DataContainer extends Admin_DataContainer{
    function copyData($values) {
        $storeValues = parent::copyData($values);
        
        $cpTable = zzNew('Market_Db_Flashrf_Colorprice');
        $colors = $cpTable->colorsByGoodsIds(array('ids' => array($values['id'])));
        
        foreach($colors as $colorGroup){
            $first = true;
            foreach ($colorGroup['color_html'] as $clr){
                if ($first){
                    $colorGroup['id'] = $storeValues['id'];
                    $colorId = $cpTable->adminCreate($colorGroup, true);

                    zzNew('Market_Db_Flashrf_Photos')->adminCopy(
                        array(
                            'id' => $colorGroup['color_group'],
                            'newId' => $colorId['id'],
                        )
                    );
                    
                    $first = false;
                }else{
                    $cpTable->colorsCreate(array(
                        'id' => $colorId['id'],
                        'ident' => $storeValues['id']
                    ) + $clr);
                }
            }
        }
        
        return $storeValues;
    }
}