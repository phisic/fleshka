<?php
class Market_Order{
    protected $comments = array(), $order = null;

    function load($order){
        $this->order = zzNew('Market_Db_Flashrf_Order')->load(array('order_id' => $order), true);
        
        $this->comments = new zzSql_Filter_Cache(
            zzSql::Source('Market_Db_Flashrf_OrderComments')->load(array('order_id' => $order))
        );
        
        return $this;
    }    
    
    function tmlSetup($tml){
        $tml->ZZ('Market_Order_AllMessages')->each('setSource', array(
            new Market_Order_LastMessages($this->comments, 3)
        ));
        
        $tml->ZZ('Market_Order_ShowOldMessages')->switchBy(
            count($this->comments->getIterator())>3?'':'.n'
        );
        
        $tml->ZZ('Market_Order_AllOldMessages')->each('setSource', array(
            new Market_Order_StartMessages($this->comments, 3)
        ));
        
        $tml->ZZ('Market_Order_State')->switchBy(
             ($this->order['state']==1)?'.address':
             (($this->order['state']==2)?'.online':'.closed')
        );
        
        $tml->ZZ('Market_Order_Manager')->switchBy(
             (zzNew('Source_Cookie')->offsetExists('manager'))?'':'.n'
        );
    }
}