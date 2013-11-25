<?php

/**
 * This is the model class for table "search".
 *
 * The followings are the available columns in table 'search':
 * @property integer $id
 * @property integer $goods_id
 * @property string $word
 */
class Msearch extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Search the static model class
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
        return 'search';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('goods_id, word', 'required'),
            array('goods_id', 'numerical', 'integerOnly'=>true),
            array('word', 'length', 'max'=>255),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, goods_id, word', 'safe', 'on'=>'search'),
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
                'descriptionsize' => array(self::BELONGS_TO, 'Descriptionsize', 'goods_id'),            
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'goods_id' => 'Goods',
            'word' => 'Word',
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
        $criteria->compare('goods_id',$this->goods_id);
        $criteria->compare('word',$this->word,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}