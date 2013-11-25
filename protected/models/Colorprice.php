<?php

class Colorprice extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Colorprice the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'colorprice';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('ident, color_id', 'required'),
            array('ident, index, color_id, color_group', 'numerical', 'integerOnly'=>true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, ident, index, color_id, color_group', 'safe', 'on'=>'search'),
        );
    }    

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
                'descriptionsize' => array(self::BELONGS_TO, 'Descriptionsize', 'ident'),
                'colors' => array(self::BELONGS_TO, 'Colors', 'color_id'),
                'photoss' => array(self::HAS_MANY, 'Photos', 'ident'),
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
            'ident' => 'Ident',
            'index' => 'Index',
            'color_id' => 'Color Id',
            'color_group' => 'Color Group',
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
        $criteria->compare('ident', $this->ident);
        $criteria->compare('index', $this->index);
        $criteria->compare('color_id', $this->color_id);
        $criteria->compare('color_group', $this->color_group);

        return new CActiveDataProvider($this, array(
                        'criteria' => $criteria,
                ));
    }
    
}