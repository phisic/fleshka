<?php

/**
 * This is the model class for table "ordercomments".
 *
 * The followings are the available columns in table 'ordercomments':
 * @property integer $id
 * @property string $order_id
 * @property string $date_created
 * @property integer $manager_id
 * @property string $comment
 */
class Ordercomments extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Ordercomments the static model class
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
        return 'ordercomments';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('order_id, date_created, comment', 'required'),
            array('manager_id', 'numerical', 'integerOnly'=>true),
            array('order_id', 'length', 'max'=>255),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, order_id, date_created, manager_id, comment', 'safe', 'on'=>'search'),
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
            'order' => array(self::BELONGS_TO, 'Morder', 'order_id'),
            'manager' => array(self::BELONGS_TO, 'User', 'manager_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'order_id' => 'Order',
            'date_created' => 'Date Created',
            'manager_id' => 'Manager',
            'comment' => 'Comment',
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
        $criteria->compare('order_id',$this->order_id,true);
        $criteria->compare('date_created',$this->date_created,true);
        $criteria->compare('manager_id',$this->manager_id);
        $criteria->compare('comment',$this->comment,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}