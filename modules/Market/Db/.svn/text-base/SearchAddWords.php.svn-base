<?php
class Market_Db_SearchAddWords extends Q{
    function doQuery(){
        $result = parent::doQuery();
        
        $return = array('word' => array(), 'id' => $this->getParameter('id'));
        foreach($result as $word)
            $return['word'][] = $word['word'];
        
        $return['words'] = implode(', ', $return['word']);
        
        return array($return);
    }
}