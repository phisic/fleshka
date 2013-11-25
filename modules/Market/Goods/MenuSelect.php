<?php
class Market_Goods_MenuSelect extends O{
    protected $name = false;

    function checkFor($name){
        $this->name = $name;
    }
    
    function __toString() {
        if ($this->getAttribute('invert')){
            if ($this->name !== false && $this->name == (string)$this->getAttribute('test'))
                $this->hide();
            else
                $this->show();
        }else{
            if ($this->name !== false && $this->name == (string)$this->getAttribute('test'))
                $this->show();
            else
                $this->hide();
        }
        
        return parent::__toString();
    }
}