<?php

/**
* This is the model class for table "user_skill".
*
* The followings are the available columns in table 'user_skill':
    * @property string $id
    * @property string $user_master_id
    * @property string $skill_id
    * @property string $created_at
    * @property string $updated_at
*/
class UserSkill extends Model
{
/**
* Returns the static model of the specified AR class.
* @param string $className active record class name.
* @return UserSkill the static model class
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
return 'user_skill';
}

/**
* @return array validation rules for model attributes.
*/
public function rules()
{
// NOTE: you should only define rules for those attributes that
// will receive user inputs.
return array(
    array('user_master_id, skill_id', 'required'),
    array('user_master_id', 'length', 'max'=>20),
    array('skill_id', 'length', 'max'=>10),
// The following rule is used by search().
// Please remove those attributes that should not be searched.
array('id, user_master_id, skill_id, created_at, updated_at', 'safe', 'on'=>'search'),
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
    'skill' => array(self::BELONGS_TO, 'Skill', 'skill_id'),
);
}

/**
* @return array customized attribute labels (name=>label)
*/
public function attributeLabels()
{
return array(
    'id' => 'ID',
    'user_master_id' => 'User Master',
    'skill_id' => 'Skill',
    'created_at' => 'Created At',
    'updated_at' => 'Updated At',
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
		$criteria->compare('user_master_id',$this->user_master_id,true);
		$criteria->compare('skill_id',$this->skill_id,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('updated_at',$this->updated_at,true);

return new CActiveDataProvider($this, array(
'criteria'=>$criteria,
));
}
}