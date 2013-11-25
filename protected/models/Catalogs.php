<?php

class Catalogs extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Catalog the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'catalogs';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
                array('index, show, count, is_delete, date_apply', 'numerical', 'integerOnly' => true),
                array('name, url, header, image', 'length', 'max' => 256),
                array('from_date, to_date, description', 'safe'),
                // The following rule is used by search().
                // Please remove those attributes that should not be searched.
                array('id, name, url, header, index, show, count, image, description, date_apply, from_date, to_date, is_delete', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
                'relgoodscatalogs' => array(self::HAS_MANY, 'Relgoodscatalog', 'catalog_id'),
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
            'name' => 'Наименование',
            'url' => 'Url',
            'header' => 'Заголовок',
            'index' => 'Index',
            'show' => 'Показать',
            'count' => 'Count',
            'image' => 'Рисунок',
            'description' => 'Описание',
            'date_apply' => 'Дата фильтр',
            'from_date' => 'С даты',
            'to_date' => 'По даты',
            'is_delete' => 'Is delete',
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
        $criteria->compare('name', $this->name, true);
        $criteria->compare('url', $this->url, true);
        $criteria->compare('header', $this->header, true);
        $criteria->compare('index', $this->index);
        $criteria->compare('show', $this->show);
        $criteria->compare('count', $this->count);
        $criteria->compare('image', $this->image, true);
        $criteria->compare('description', $this->description);
        $criteria->compare('date_apply', $this->date_apply);
        $criteria->compare('from_date',$this->from_date,true);
        $criteria->compare('to_date',$this->to_date,true);
        $criteria->compare('is_delete', $this->is_delete);

        return new CActiveDataProvider($this, array(
                        'criteria' => $criteria,
                ));
    }
    
}