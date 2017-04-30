<?php

/**
* This is the model class for table "country".
*
* The followings are the available columns in table 'country':
    * @property integer $id
    * @property string $countryCode
    * @property string $countryName
*/
class Country extends Model
{
/**
* Returns the static model of the specified AR class.
* @param string $className active record class name.
* @return Country the static model class
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
return 'country';
}

/**
* @return array validation rules for model attributes.
*/
public function rules()
{
// NOTE: you should only define rules for those attributes that
// will receive user inputs.
return array(
    array('countryCode', 'length', 'max'=>2),
    array('countryName', 'length', 'max'=>45),
// The following rule is used by search().
// Please remove those attributes that should not be searched.
array('id, countryCode, countryName', 'safe', 'on'=>'search'),
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
    'countryCode' => 'Country Code',
    'countryName' => 'Country Name',
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
		$criteria->compare('countryCode',$this->countryCode,true);
		$criteria->compare('countryName',$this->countryName,true);

return new CActiveDataProvider($this, array(
'criteria'=>$criteria,
));
}
}