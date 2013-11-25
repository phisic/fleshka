<?php
class Market_Goods_Each extends Each_Param{
    protected $number = 0;

    function  onEachInit($array) {
        $this->number = 0;

        return parent::onEachInit($array);
    }

    function onEach($index, $value) {
        if (count($value['colors'])>1 || $this->number != 0)
            $this->number++;

        $this->ZZ('H.first')->switchBy(($this->number === 1)?'.yes':'.no');

        $this->ZZ('H.oneselect')->switchBy((count($value['colors'])>1)?'.more':'.one');

        $this->ZZ('Checkbox.color')->each('setAttributes', array(array('checked' => (count($value['colors'])<=1))));

        return parent::onEach($index, $value);
    }
}

