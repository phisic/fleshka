<?php
class Market_Goods_PDF_ImageLink extends PDF_Save{
    protected $source;

    function setSource($source){
        $this->source = $source;
    }
    
    function toPDF(){
        $id = (string)$this->getParameter('goods_id');
        
        $array = $this->source->getIterator();
        
        if (isset($array[$id])){
            $colors = $array[$id];

            $colors = reset($colors);

            $this->setAttributes(array(
                'id' => $colors['color_group']
            ));
            
            parent::toPDF();
        }
    }
}