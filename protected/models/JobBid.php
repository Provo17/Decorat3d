<?php

/**
 * This is the model class for table "job_bid".
 *
 * The followings are the available columns in table 'job_bid':
 * @property string $id
 * @property string $user_master_id
 * @property string $jobs_id
 * @property string $uploaded_file
 * @property string $price
 * @property string $is_featured
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 */
class JobBid extends Model {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return JobBid the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'job_bid';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
// NOTE: you should only define rules for those attributes that
// will receive user inputs.
        return array(
            array('uploaded_file, price', 'required'),
            array('uploaded_file', 'file', 'allowEmpty' => true, 'types' => 'stl,zip,rar,jpg,jpeg,gif,png'),
            array('price', 'numerical'),
            array('user_master_id, jobs_id, price', 'length', 'max' => 20),
            array('uploaded_file', 'length', 'max' => 55),
            array('is_featured', 'length', 'max' => 3),
            array('status', 'length', 'max' => 1),
// The following rule is used by search().
// Please remove those attributes that should not be searched.
            array('id, user_master_id, jobs_id, uploaded_file, price, is_featured, status, created_at, updated_at', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
// NOTE: you may need to adjust the relation name and the related
// class name for the relations automatically generated below.
        return array(
            'job' => array(self::BELONGS_TO, 'Jobs', 'jobs_id'),
//            'transaction' => array(self::HAS_ONE, 'TransactionReport', 'bid_id','condition'=>"status=23"),
            'designer' => array(self::BELONGS_TO, 'UserMaster', 'user_master_id'),
            'disputeThread'=>[self::HAS_ONE, 'DisputeThread', 'track_id', 'condition'=>'status="1"']
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'user_master_id' => 'Designer',
            'jobs_id' => 'Jobs',
            'uploaded_file' => 'Uploaded File',
            'price' => 'Price',
            'is_featured' => 'Is Featured',
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
        $criteria->compare('user_master_id', $this->user_master_id, true);
        $criteria->compare('jobs_id', $this->jobs_id, true);
        $criteria->compare('uploaded_file', $this->uploaded_file, true);
        $criteria->compare('price', $this->price, true);
        $criteria->compare('is_featured', $this->is_featured, true);
        $criteria->compare('status', $this->status, true);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('updated_at', $this->updated_at, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
