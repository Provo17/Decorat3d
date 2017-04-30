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
            array('reason', 'required', 'on' => 'create'),
            array('type, dispute_from, status', 'numerical', 'integerOnly' => true),
            array('track_id, user_master_id', 'length', 'max' => 20),
            array('reason', 'length', 'max' => 255),
            array('status', 'safe', 'on' => 'update'),
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
            'disputeFrom' => [self::BELONGS_TO, 'AdminUserMaster', 'user_master_id'],
            'jobBid' => [self::BELONGS_TO, 'JobBid', 'track_id'],
            'messages' => [self::HAS_MANY, 'DisputeConversation', 'dispute_thread_id', 'condition' => 'status="1"']
        );
    }

    public function showDisputeFromType() {
        $type = "";
        switch ($this->dispute_from) {
            case "1":case 1: $type = "Employer";
                break;
            case "2":case 2:$type = "Designer";
                break;
            case "3":case 3:$type = "Manufacturer";
                break;
            default:$type = "";
        }
        return $type;
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

    protected function decodeType($type) {
        return $type == 'Designer Bid' ? "1" : "";
    }

    protected function decodeDisputeFrom($disputeFrom) {
        $disputeFrom = strtolower($disputeFrom);
        $disputeFrom = "";

        switch ($disputeFrom) {
            case 'employer': $disputeFrom="1";break;
            case 'designer': $disputeFrom="1";break;
            case 'manufacturer': $disputeFrom="1";break;
            default: $disputeFrom = "";
        }
        return $disputeFrom;
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search($columns) {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $pagination = new EDTPagination();
        $criteria->with = ['jobBid', 'jobBid.job', 'jobBid.job.job_owner', 'disputeFrom'];


        if (isset($_GET['sSearch'])) {
            $criteria->compare('job_owner.username', $_GET['sSearch'], true, 'OR');
            $criteria->compare('disputeFrom.username', $_GET['sSearch'], true, 'OR');
//            $criteria->compare('t.type', decodeType($_GET['sSearch']), true, 'OR');
//            $criteria->compare('t.dispute_from', decodeDisputeFrom($_GET['sSearch']), true, 'OR');
        }
        $criteria->having="t.status<>'3'";

        $sort = new EDTSort(__CLASS__, $columns);
        $sort->defaultOrder = 't.updated_at DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => $sort,
            'pagination' => $pagination,
        ));
    }

}
