<?php

/**
 * This is the model class for table "descriptionprice".
 *
 * The followings are the available columns in table 'descriptionprice':
 * @property integer $id
 * @property integer $index
 * @property integer $trash
 * @property string $name
 * @property string $description
 * @property double $price
 * @property integer $count
 * @property integer $instock
 */
class Descriptionprice extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Descriptionprice the static model class
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
        return 'descriptionprice';
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
            array('id, index, trash, count, instock, is_new, is_custom_text', 'numerical', 'integerOnly'=>true),
            array('price', 'numerical'),
            array('name', 'length', 'max'=>255),
            array('description, custom_text', 'safe'),            
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, index, trash, name, description, price, count, instock, is_new, is_custom_text, custom_text', 'safe', 'on'=>'search'),
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
            'relgoodscatalogs' => array(self::HAS_MANY, 'Relgoodscatalog', 'goods_id'),
            'colorprices' => array(self::HAS_MANY, 'Colorprice', 'ident'),
            'searches' => array(self::HAS_MANY, 'Msearch', 'goods_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'index' => 'Index',
            'trash' => 'Trash',
            'name' => 'Название',
            'description' => 'Описание',
            'price' => 'Цена',
            'count' => 'Кол-во',
            'instock' => 'На складе',
            'is_new' => 'Новый?',
            'is_custom_text' => 'Текст?',
            'custom_text' => 'Текст',
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
        $criteria->compare('index',$this->index);
        $criteria->compare('trash',$this->trash);
        $criteria->compare('name',$this->name,true);
        $criteria->compare('description',$this->description,true);
        $criteria->compare('price',$this->price);
        $criteria->compare('count',$this->count);
        $criteria->compare('instock',$this->instock);
        $criteria->compare('is_new',$this->instock);
        $criteria->compare('is_custom_text',$this->is_custom_text);
        $criteria->compare('custom_text',$this->custom_text);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    public function is_special()
    {
        $catalogs = $this->relgoodscatalogs;

        if (count($catalogs)>0) {

            foreach($catalogs as $catalog) {

                if ($catalog->catalog_id==1) {

                    return true;
                }
            }
        }

        return false;
    }
    
}