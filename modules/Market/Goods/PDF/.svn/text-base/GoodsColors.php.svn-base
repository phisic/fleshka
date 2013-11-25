<?php
class Market_Goods_PDF_GoodsColors extends PDF_Each{
    protected $left = 0;

    function onEachInit($array) {
        $id = (string)$this->getParameter('goods_id');
        $this->left = (string)$this->getAttribute('left');
        
        if (isset($array[$id]))
            return parent::onEachInit($array[$id]);
        
        return array();
    }
    
    function onEach($index, $value){
        $width = 5/count($value['color_html']);
        
        $this->pdf->SetFillColor(30);
        $this->pdf->Rect($this->left-0.25, (string)$this->getAttribute('top')-0.2, 5.5, 3.4, 'F');
        
        foreach ($value['color_html'] as $color){
            $this->ZZ('PDF_FillRect')->each('setAttributes', array(
                array('left' => $this->left, 'color' => $color['color_html'], 'width' => $width)
            ));

            $this->left += $width;

            parent::onEach($index, $value);
        }

        $this->left += 2;
    }
}