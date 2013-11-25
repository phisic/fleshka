<?php

/**
 * This is the model class for table "advertising".
 *
 * The followings are the available columns in table 'advertising':
 * @property string $id
 * @property string $text_advertising
 * @property string $picture
 * @property string $url
 * @property integer $is_blank
 */
class Advertising extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Advertising the static model class
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
        return 'advertising';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('blank, is_active', 'numerical', 'integerOnly'=>true),
            array('text_advertising, picture', 'length', 'max'=>255),
            array('url', 'length', 'max'=>45),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, text_advertising, picture, url, blank, is_active', 'safe', 'on'=>'search'),
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
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'text_advertising' => 'Текст о рекламе',
            'picture' => 'Рисунок',
            'url' => 'Ссылка',
            'blank' => 'Is Blank',
            'is_active' => 'Актив',
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

        $criteria->compare('id',$this->id,true);
        $criteria->compare('text_advertising',$this->text_advertising,true);
        $criteria->compare('picture',$this->picture,true);
        $criteria->compare('url',$this->url,true);
 //       $criteria->compare('blank',$this->blank);
        $criteria->compare('is_active',$this->is_active);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}