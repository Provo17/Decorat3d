<?php

/**
* This is the model class for table "chat_master".
*
* The followings are the available columns in table 'chat_master':
    * @property string $id
    * @property string $track_id
    * @property integer $type
    * @property integer $track_status
    * @property string $created_at
*/
class ChatMaster extends Model
{
/**
* Returns the static model of the specified AR class.
* @param string $className active record class name.
* @return ChatMaster the static model class
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
return 'chat_master';
}

/**
* @return array validation rules for model attributes.
*/
public function rules()
{
// NOTE: you should only define rules for those attributes that
// will receive user inputs.
return array(
    array('track_id, type, track_status, created_at', 'required'),
    array('type, track_status', 'numerical', 'integerOnly'=>true),
    array('track_id', 'length', 'max'=>20),
// The following rule is used by search().
// Please remove those attributes that should not be searched.
array('id, track_id, type, track_status, created_at', 'safe', 'on'=>'search'),
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
    'user_by' => array(self::BELONGS_TO, 'UserMaster', 'started_by'),
    'user' => array(self::BELONGS_TO, 'UserMaster', 'started_to'),
);
}

/**
* @return array customized attribute labels (name=>label)
*/
public function attributeLabels()
{
return array(
    'id' => 'ID',
    'track_id' => 'Track',
    'type' => 'Type',
    'track_status' => 'Track Status',
    'created_at' => 'Created At',
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
		$criteria->compare('track_id',$this->track_id,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('track_status',$this->track_status);
		$criteria->compare('created_at',$this->created_at,true);

return new CActiveDataProvider($this, array(
'criteria'=>$criteria,
));
}
}