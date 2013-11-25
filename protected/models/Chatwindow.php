<?php

/**
 * This is the model class for table "chatwindow".
 *
 * The followings are the available columns in table 'chatwindow':
 * @property integer $id
 * @property string $hash
 * @property integer $manager_id
 * @property string $user_email
 * @property string $url
 * @property string $variables
 * @property string $lastonline
 * @property integer $status
 * @property string $lastmessagedate
 */
class Chatwindow extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Chatwindow the static model class
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
        return 'chatwindow';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('hash, manager_id, status, lastmessagedate', 'required'),
            array('manager_id, status', 'numerical', 'integerOnly'=>true),
            array('hash, user_email, message', 'length', 'max'=>255),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, hash, manager_id, message, user_email, url, variables, lastonline, status, lastmessagedate', 'safe', 'on'=>'search'),
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
            'hash' => 'Hash',
            'manager_id' => 'Manager',
            'message' => 'Message',
            'user_email' => 'User Email',
            'url' => 'Url',
            'variables' => 'Variables',
            'lastonline' => 'Lastonline',
            'status' => 'Status',
            'lastmessagedate' => 'Lastmessagedate',
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
        $criteria->compare('hash',$this->hash,true);
        $criteria->compare('manager_id',$this->manager_id);
        $criteria->compare('message',$this->message, true);
        $criteria->compare('user_email',$this->user_email,true);
        $criteria->compare('url',$this->url,true);
        $criteria->compare('variables',$this->variables,true);
        $criteria->compare('lastonline',$this->lastonline,true);
        $criteria->compare('status',$this->status);
        $criteria->compare('lastmessagedate',$this->lastmessagedate,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}