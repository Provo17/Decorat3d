<?php

/**
 * This is the model class for table "dispute_thread".
 *
 * The followings are the available columns in table 'dispute_thread':
 * @property string $id
 * @property string $track_id
 * @property integer $type
 * @property string $user_master_id
 * @property integer $dispute_from
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 */
class DisputeThread extends Model {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return DisputeThread the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'dispute_thread';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('reason', 'required', 'on'=>'create'),
            array('type, dispute_from, status', 'numerical', 'integerOnly' => true),
            array('track_id, user_master_id', 'length', 'max' => 20),
            array('reason', 'length', 'max'=>255),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, track_id, type, user_master_id, dispute_from, reason, status, created_at, updated_at', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'disputeFrom' => [self::BELONGS_TO, 'UserMaster', 'user_master_id'],
            'jobBid' => [self::BELONGS_TO, 'JobBid', 'track_id'],
            'messages' => [self::HAS_MANY, 'DisputeConversation', 'dispute_thread_id', 'condition'=>'status="1"']
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'track_id' => 'Track',
            'type' => 'Type',
            'user_master_id' => 'User Master',
            'dispute_from' => 'Dispute From',
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
        $criteria->compare('track_id', $this->track_id, true);
        $criteria->compare('type', $this->type);
        $criteria->compare('user_master_id', $this->user_master_id, true);
        $criteria->compare('dispute_from', $this->dispute_from);
        $criteria->compare('status', $this->status);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('updated_at', $this->updated_at, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
