<?php
class Market_Spreadsheet{
    static protected $grpID = 0, $keys, $cols;

    static function onEachInit($spreadsheet){
        $features = zzClasses::create('Market_Db_Goods_Feature')->getAllFeatures();

        $keys = array();
        foreach($features as $f){
            $ar = explode(',', mb_strtolower($f['keywords'], 'UTF-8'));
            array_walk($ar, function(&$v){$v = trim($v);});
            $ar = array_fill_keys($ar, $f);

            if (!isset($keys[$f['type']]))
                $keys[$f['type']] = $ar;
            else
                $keys[$f['type']] = array_merge($keys[$f['type']], $ar);
        }

        self::$keys = $keys;

        $values = array('id' => zzRoot::$root->getAttribute('id'));
        $sstype = zzClasses::create('Market_Db_Goods_Spreadsheets')->getFeature($values, true);

        self::$grpID = zzClasses::create('Market_Db_Goods_Feature')->getFeatureId(array(
            'type'=>'Группа вывода', 'value'=>'На обработку'
        ), true);
        self::$grpID = self::$grpID['id'];

        self::$cols = unserialize($sstype['serialTypes']);
    }

    static function onEach($index, $value){
        $features = array();

        $modelNameValues = $value;

        foreach (self::$cols as $type => $idxs){
            $bestword = false;
            $keylen = 0;
            foreach ($idxs as $i){
                if (isset(self::$keys[$type]) && isset($value[$i-1]))
                    foreach (self::$keys[$type] as $key => $id){
                        if($key === '')
                            continue;

                        $position = strpos(mb_strtolower($value[$i-1], 'UTF-8'), $key);
                        if ($position !== false){
                            $len = strlen($key);
                            if ($len > $keylen){
                                $bestword = $id;
                                $keylen = $len;
                            }

                            if (isset(self::$cols['Название модели']) && in_array($i, self::$cols['Название модели'])){
                                $modelNameValues[$i-1] = substr($modelNameValues[$i-1], 0, $position).  str_repeat(' ', $len).substr($modelNameValues[$i-1], $position+$len);
                            }
                        }
                    }
            }
            if ($bestword)
                $features[] = array('type'=>$type, 'value'=>$bestword['value'], 'id' => $bestword['id']);
        }
        $features[] = array('type'=>'Группа вывода', 'value'=>'На обработку', 'id' => self::$grpID);

        $model = array();

        if (isset(self::$cols['Название модели']))
            foreach (self::$cols['Название модели'] as $i)
                $model[] = trim(preg_replace('/\s+/', ' ', $modelNameValues[$i-1]));

        if ($model){
            $model = implode (' ', $model);
            if ($model){
                self::$setParameters(array(
                    'model' => $model
                ));
                self::$ZZ('H.model')->each('show');
            }else
                self::$ZZ('H.model')->each('hide');
            
        }

        if (isset(self::$cols['Комментарии'])){
            $comments = array();
            foreach (self::$cols['Комментарии'] as $i)
                $comments[] = $value[$i-1];

            self::$setParameters(array(
                'comments' => implode('. ',$comments)
            ));
            
            self::$ZZ('H.comments')->each('show');
        }else
            self::$ZZ('H.comments')->each('hide');

        if (isset(self::$cols['Оптовая цена'])){
            $price = array();
            foreach (self::$cols['Оптовая цена'] as $i)
                $price = $value[$i-1];

            self::$setParameters(array(
                'price' => $price
            ));
            
            self::$ZZ('H.price')->each('show');
        }else
            self::$ZZ('H.price')->each('hide');

        self::$setParameters(array(
            'features' => $features
        ));
    }
}

