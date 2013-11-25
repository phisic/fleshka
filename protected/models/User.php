<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property string $id_user
 * @property string $username
 * @property string $password
 * @property string $fio
 * @property string $email
 * @property string $phone
 * @property string $skype
 * @property string $icq
 */
class User extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return User the static model class
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
        return 'user';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('username, email, phone, skype, icq', 'length', 'max'=>45),
            array('password, fio', 'length', 'max'=>100),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id_user, username, password, fio, email, phone, skype, icq', 'safe', 'on'=>'search'),
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
            'id_user' => 'Id User',
            'username' => 'Username',
            'password' => 'Password',
            'fio' => 'Fio',
            'email' => 'Email',
            'phone' => 'Phone',
            'skype' => 'Skype',
            'icq' => 'Icq',
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

        $criteria->compare('id_user',$this->id_user,true);
        $criteria->compare('username',$this->username,true);
        $criteria->compare('password',$this->password,true);
        $criteria->compare('fio',$this->fio,true);
        $criteria->compare('email',$this->email,true);
        $criteria->compare('phone',$this->phone,true);
        $criteria->compare('skype',$this->skype,true);
        $criteria->compare('icq',$this->icq,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    public function checkUser($username, $password)
    {
        $salt = 'lmbrdjon';

        $criteria = new CDbCriteria;

        $username = addslashes($username);

        $password = md5($salt.addslashes($password));

        $criteria->condition = 'username="'.$username.'" and password="'.$password.'"';

        $user = $this->find($criteria);

        if (count($user)>0) {

            Yii::app()->session['user_id'] = $user->id_user;
            Yii::app()->session['user'] = $user;

            return true;

        } else {

            return false;
        }
    }

}