<?php
class Market_Goods_Price_Each extends Each_Param{
    protected $sub1 = 0, $sub2 = 0, $sub3 = 0;

    function  __construct() {
        parent::__construct();

        $this->setAttributes(array(
            'minus1' => 10,
            'minus2' => 20,
            'minus3' => 45
        ));
    }

    function onEachInit($array) {
        $this->sub1 = $this->getAttribute('minus1');
        $this->sub2 = $this->getAttribute('minus2');
        $this->sub3 = $this->getAttribute('minus3');

        return parent::onEachInit($array);
    }

    function onEach($index, $value) {
        if ($value['price'] == 0){
            $this->ZZ('O.manager')->switchBy('.noprice');
        }else{
            $this->ZZ('O.manager')->switchBy('.price');

            $this->setParameters(array(
                'price2' => $value['price'] - $this->sub1,
                'price3' => $value['price'] - $this->sub2,
                'price4' => $value['price'] - $this->sub3,
            ));
        }

        return parent::onEach($index, $value);
    }
}

