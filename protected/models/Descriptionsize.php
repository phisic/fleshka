<?php

class Descriptionsize extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Descriptionsize the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'descriptionsize';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('index, name', 'required'),
            array('index, trash, count2, count4, count8, count16, count32, count64, instock, is_new', 'numerical', 'integerOnly'=>true),
            array('pricesize2, pricesize4, pricesize8, pricesize16, pricesize32,pricesize64,pricesize2_z, pricesize4_z, pricesize8_z, pricesize16_z, pricesize32_z, pricesize64_z', 'numerical'),
            array('name', 'length', 'max'=>255),
            array('description', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, index, trash, name, description, pricesize2, pricesize4, pricesize8, pricesize16, pricesize32, pricesize64, count2, count4, count8, count16, count32, count64, instock, is_new', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
                'relgoodscatalogs' => array(self::HAS_MANY, 'Relgoodscatalog', 'goods_id'),
                'colorprices' => array(self::HAS_MANY, 'Colorprice', 'ident'),
                'searches' => array(self::HAS_MANY, 'Msearch', 'goods_id'),
                // 'appiontmentScholarships' => array(self::HAS_MANY, 'AppiontmentScholarship', 'citizen_id'),
                // 'birthLocation' => array(self::BELONGS_TO, 'Location', 'birth_location'),
                // 'jobseeker' => array(self::HAS_ONE, 'Jobseeker', 'citizen_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {

        return array(
            'id' => 'Id',
            'index' => 'Index',
            'trash' => 'Trash',
            'name' => 'Название',
            'description' => 'Описание',
            'pricesize2' => 'Цена 2 Гб',
            'pricesize2_z' => 'Цена под заказ 2 Гб',
            'pricesize4' => 'Цена 4 Гб',
            'pricesize4_z' => 'Цена под заказ 4 Гб',
            'pricesize8' => 'Цена 8 Гб',
            'pricesize8_z' => 'Цена под заказ 8 Гб',
            'pricesize16' => 'Цена 16 Гб',
            'pricesize16_z' => 'Цена под заказ 16 Гб',
            'pricesize32' => 'Цена 32 Гб',
            'pricesize64' => 'Цена 64 Гб',
            'pricesize32_z' => 'Цена под заказ 32 Гб',
            'pricesize64_z' => 'Цена под заказ 64 Гб',
            'count2' => 'Кол-во 2 Гб',
            'count4' => 'Кол-во 4 Гб',
            'count8' => 'Кол-во 8 Гб',
            'count16' => 'Кол-во 16 Гб',
            'count32' => 'Кол-во 32 Гб',
            'count64' => 'Кол-во 64 Гб',
            'instock' => 'На складе',
            'is_new' => 'Новый?',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('index', $this->index);
        $criteria->compare('trash', $this->trash);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('pricesize2', $this->pricesize2);
        $criteria->compare('pricesize4', $this->pricesize4);
        $criteria->compare('pricesize8', $this->pricesize8);
        $criteria->compare('pricesize16', $this->pricesize16);
        $criteria->compare('pricesize32', $this->pricesize32);
        $criteria->compare('pricesize64', $this->pricesize64);
        $criteria->compare('count2', $this->count2);
        $criteria->compare('count4', $this->count4);
        $criteria->compare('count8', $this->count8);
        $criteria->compare('count16', $this->count16);
        $criteria->compare('count32', $this->count32);
        $criteria->compare('count64', $this->count64);
        $criteria->compare('instock', $this->instock);
        $criteria->compare('is_new', $this->is_new);

        return new CActiveDataProvider($this, array(
                        'criteria' => $criteria,
                ));
    }

    public function is_special()
    {
        $catalogs = $this->relgoodscatalogs;

        if (count($catalogs)>0) {

            foreach($catalogs as $catalog) {

                if ($catalog->catalog_id==1) {

                    return true;
                }
            }
        }

        return false;
    }

}