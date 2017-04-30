<?php

/**
 * This is the model class for table "dispute_conversation".
 *
 * The followings are the available columns in table 'dispute_conversation':
 * @property string $id
 * @property string $dispute_thread_id
 * @property string $message
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 */
class DisputeConversation extends Model {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return DisputeConversation the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'dispute_conversation';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
// NOTE: you should only define rules for those attributes that
// will receive user inputs.
        return array(
            array('dispute_thread_id, message', 'required'),
            array('status', 'numerical', 'integerOnly' => true),
            array('dispute_thread_id', 'length', 'max' => 20),
// The following rule is used by search().
// Please remove those attributes that should not be searched.
            array('id, dispute_thread_id, message, status, created_at, updated_at', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
// NOTE: you may need to adjust the relation name and the related
// class name for the relations automatically generated below.
        return array(
            'user'=>[self::BELONGS_TO, 'UserMaster', 'user_id'],
            'disputeThread'=>[self::BELONGS_TO, 'DisputeThread', 'dispute_thread_id']
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'dispute_thread_id' => 'Dispute Thread',
            'message' => 'Message',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
// Warning: Please modify the following code to remove attributes that
// should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('dispute_thread_id', $this->dispute_thread_id, true);
        $criteria->compare('message', $this->message, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('updated_at', $this->updated_at, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
