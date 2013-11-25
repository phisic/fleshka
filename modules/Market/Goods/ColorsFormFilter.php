<?php
class Market_Goods_ColorsFormFilter extends zzSql_Filter{
    function getIterator() {
        $colors = $this->source;
        
        $result = new ArrayObject();
        foreach ($colors as $idc){
            foreach ($idc as $col){
                foreach ($col['color_html'] as $color){
                    if (!isset($result[$color['color_id']]))
                        $result[$color['color_id']] = $color;
                }
            }
        }
        
        return $result;
    }
}