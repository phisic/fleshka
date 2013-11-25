<?php

class Relgoodscatalog extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Relgoodscatalog the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'relgoodscatalog';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
                array('catalog_id, goods_id', 'numerical', 'integerOnly' => true),
                // The following rule is used by search().
                // Please remove those attributes that should not be searched.
                array('id, catalog_id, goods_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
                'catalog' => array(self::BELONGS_TO, 'Catalogs', 'catalog_id'),
                'descriptionsize' => array(self::BELONGS_TO, 'Descriptionsize', 'goods_id'),
                'descriptionprice' => array(self::BELONGS_TO, 'Descriptionprice', 'goods_id'),                
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
            'catalog_id' => 'Catalog Id',
            'goods_id' => 'Goods Id',
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
        $criteria->compare('catalog_id', $this->name);
        $criteria->compare('goods_id', $this->url);

        return new CActiveDataProvider($this, array(
                        'criteria' => $criteria,
                ));
    }
    
}