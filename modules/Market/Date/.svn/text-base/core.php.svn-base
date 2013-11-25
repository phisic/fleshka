<?php
class Market_Date extends zzTml{
    public function setTextAttributes($textattributes, zzParser_TreePartNode $parser){
        parent::setTextAttributes($textattributes, $parser);

        if ($this->issetAttribute('time'))
            $this->ZZ('H.withtime')->each('show');

        if ($this->issetAttribute('year'))
            $this->ZZ('H.withyear')->each('show');

        return $this;
    }

    public function  __toString() {
        $date = date_parse_from_format('Y-m-d H:i:s', (string)$this->ZZ('O.insideDate'));
        
        if ($date['errors'])
            return 'Date error: '.implode (', ', $date['errors']);
        
        if ($date['minute']<10)
            $date['minute'] = '0'.$date['minute'];

        $this->ZZ('H.month')->switchBy('.'.$date['month']);
        $this->setAttributes($date);

        return parent::__toString();
    }
}