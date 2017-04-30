<?php

/**
 * This is the model class for table "chat_inbox".
 *
 * The followings are the available columns in table 'chat_inbox':
 * @property string $id
 * @property string $chat_master_id
 * @property string $sender_id
 * @property string $receiver_id
 * @property string $message
 * @property integer $status
 * @property string $created_at
 */
class ChatInbox extends Model
    {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ChatInbox the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'chat_inbox';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
// NOTE: you should only define rules for those attributes that
// will receive user inputs.
        return array(
            array('chat_master_id, sender_id, receiver_id, message', 'required'),
            array('status', 'numerical', 'integerOnly' => true),
            array('id', 'length', 'max' => 40),
            array('chat_master_id, sender_id, receiver_id', 'length', 'max' => 20),
// The following rule is used by search().
// Please remove those attributes that should not be searched.
            array('id, chat_master_id, sender_id, receiver_id, message, status, created_at', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
// NOTE: you may need to adjust the relation name and the related
// class name for the relations automatically generated below.
        return array(
            'sender' => array(self::BELONGS_TO, 'UserMaster', 'sender_id'),
            'receiver' => array(self::BELONGS_TO, 'UserMaster', 'receiver_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'chat_master_id' => 'Chat Master',
            'sender_id' => 'Sender',
            'receiver_id' => 'Receiver',
            'message' => 'Message',
            'status' => 'Status',
            'created_at' => 'Created At',
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
        $criteria->compare('chat_master_id', $this->chat_master_id, true);
        $criteria->compare('sender_id', $this->sender_id, true);
        $criteria->compare('receiver_id', $this->receiver_id, true);
        $criteria->compare('message', $this->message, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('created_at', $this->created_at, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    }
