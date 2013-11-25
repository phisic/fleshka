<?php
class _Supplier_Q extends Q{
    protected function queryParameters() {
        $params = parent::queryParameters();

        $params['types'] = preg_split('~[\n,\r]+~',$params['support_types']);
        foreach ($params['types'] as $k=>&$type){
            $type = trim($type);
            if (!$type)
                unset($params['types'][$k]);
        }

        return $params;
    }
}

class _SupplierLoad_Q extends Q_Full{
    function doQuery(){
        $results = parent::doQuery();
        
        if ($results[1] && $results[0])
            $results[0][0]['support_types'] = implode("\n", array_keys($results[1]));

        return $results[0];
    }
}

class Market_Db_Supplier_Supplier extends zzSql {}