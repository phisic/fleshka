<?php
class Market_Goods extends zzTml{
    function setGoods($goods){
        $this->ZZ('Market_Goods_Each')->each('setSource', array($goods));

        if ($this->ZZ('^zzRoot Market_Goods_JS')->countResult() == 0)
            trigger_error('Need insert Market_Goods_JS into HTML `head`', E_USER_ERROR);

        if ($this->getAttribute('description'))
            $this->ZZ('H.description')->each('show');
    }
}