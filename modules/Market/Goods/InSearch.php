<?php
class Market_Goods_InSearch extends Market_Goods_Empty{
    function __toString() {
        foreach($this->sources as $source)
            if (count($source))
                return zzNode::__toString();
        
        return '';
    }
}