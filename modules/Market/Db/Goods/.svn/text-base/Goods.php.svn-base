<?php
class _ChangePrice extends My_Query{
    function onPrepareQuery(){
        if ($this->getParameter('name'))
            $this->ZZ('H.name')->each('show');
        else
            $this->ZZ('H.name')->each('hide');

        $price = trim($this->getParameter('price'));

        if (substr($price, 0, 1) == '+'){
            $q = $this->ZZ('H.price.plus')->each('show');

            if (substr($price, -1) == '%'){
                $q->select('H.percent')->each('show');

                $price = substr($price, 1, -1)/100;
            }else{
                $q->select('H.number')->each('show');
                
                $price = substr($price, 1);
            }
        }elseif (substr($price, 0, 1) == '-'){
            $q = $this->ZZ('H.price.minus')->each('show');

            if (substr($price, -1) == '%'){
                $q->select('H.percent')->each('show');
                
                $price = substr($price, 1, -1)/100;
            }else{
                $q->select('H.number')->each('show');

                $price = substr($price, 1);
            }
        }elseif (is_numeric ($price)){
            $this->ZZ('H.price.eq')->each('show');
        }else{
            $this->ZZ('H.price')->each('hide');
        }

        $this->setParameters(array('price' => $price));
    }
}

class Market_Db_Goods_Goods extends zzSql {}