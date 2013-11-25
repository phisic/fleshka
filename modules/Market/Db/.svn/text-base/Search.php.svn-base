<?php
class Market_Db_Search extends Q{
    protected function queryParameters(){
        $params = $this->getParameters();
        
        if (isset($params['words'])){
            $words = explode(',', (string)$params['words']);
            
            foreach($words as &$_)
                $_ = trim($_);            
            unset($_);
            
            $this->ZZ('Q_Each')->each('setSource', array(
                $words
            ));
        }
        
        return $params;
    }
}