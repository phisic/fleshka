<?php

/**
 * This is the model class for table "specialoffer".
 *
 * The followings are the available columns in table 'specialoffer':
 * @property integer $id
 * @property string $description
 * @property string $header
 * @property string $photo
 */
class Specialoffer extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Specialoffer the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'specialoffer';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id', 'required'),
            array('id', 'numerical', 'integerOnly'=>true),
            array('header', 'length', 'max'=>255),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, description, header, photo', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'fleshka' => array(self::BELONGS_TO, 'Descriptionsize', 'id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'description' => 'Description',
            'header' => 'Header',
            'photo' => 'Photo',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id);
        $criteria->compare('description',$this->description,true);
        $criteria->compare('header',$this->header,true);
        $criteria->compare('photo',$this->photo,true);

        return new CActiveDataProvider($this, array(
            'pagination' => array(
                         'pageSize' => 200,
                    ),            
            'criteria'=>$criteria,
        ));
    }
}