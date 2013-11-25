<?php

/**
 * This is the model class for table "order".
 *
 * The followings are the available columns in table 'order':
 * @property string $order_id
 * @property string $date_created
 * @property string $date_expire
 * @property string $date_expire_to
 * @property integer $delivery
 * @property string $email
 * @property string $company
 * @property string $phone
 * @property string $address
 * @property integer $state
 * @property integer $group
 * @property integer $hits
 * @property string $sizes
 * @property string $colors
 */
class Morder extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Order the static model class
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
        return 'order';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('order_id, date_created', 'required'),
            array('delivery, state, group, hits', 'numerical', 'integerOnly'=>true),
            array('order_id, date_expire, date_expire_to, email, company, phone', 'length', 'max'=>255),
            array('address', 'length', 'max'=>1024),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, order_id, date_created, date_expire, date_expire_to, delivery, email, company, phone, address, state, group, hits, sizes, colors', 'safe', 'on'=>'search'),
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
            'comments' => array(self::HAS_MANY, 'Ordercomments', array('order_id' => 'order_id')),
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
            'date_created' => 'Создан',
            'date_expire' => 'Date Expire',
            'date_expire_to' => 'Date Expire To',
            'delivery' => 'Delivery',
            'email' => 'Email',
            'company' => 'Компания',
            'phone' => 'Телефон',
            'address' => 'Адрес',
            'state' => 'State',
            'group' => 'Group',
            'hits' => 'Hits',
            'sizes' => 'Sizes',
            'colors' => 'Colors',
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
        $criteria->compare('order_id',$this->order_id,true);
        $criteria->compare('date_created',$this->date_created,true);
        $criteria->compare('date_expire',$this->date_expire,true);
        $criteria->compare('date_expire_to',$this->date_expire_to,true);
        $criteria->compare('delivery',$this->delivery);
        $criteria->compare('email',$this->email,true);
        $criteria->compare('company',$this->company,true);
        $criteria->compare('phone',$this->phone,true);
        $criteria->compare('address',$this->address,true);
        $criteria->compare('state',$this->state);
        $criteria->compare('group',$this->group);
        $criteria->compare('hits',$this->hits);
        $criteria->compare('sizes',$this->sizes,true);
        $criteria->compare('colors',$this->colors,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    function getManagers()
    {
        $comments  = $this->comments;

        if (count($comments)>0) {
            foreach($comments as $comment) {

                if ($comment->manager_id>0)
                    $manager = $comment->manager->fio;
            }
        }

        return $manager;
    }

}