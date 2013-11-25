<?php
class Market_Order_Menu extends zzTml{
    function __toString() {
        $cookie = zzNew('Source_Cookie');
        if ($cookie->offsetExists('myorders'))
            $orders = explode('_', $cookie->offsetGet('myorders'));
        else
            $orders = array();
        
        $this->ZZ('Each_ValueNumber')->each('setSource', array(
            $orders
        ));
        
        return parent::__toString();
    }
}