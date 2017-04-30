<?php

/**
 * This is the model class for table "review".
 *
 * The followings are the available columns in table 'review':
 * @property string $id
 * @property string $by_user
 * @property string $to_user
 * @property string $job_bid_id
 * @property string $review
 * @property double $rating
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 */
class Review extends Model
    {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Review the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'review';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
// NOTE: you should only define rules for those attributes that
// will receive user inputs.
        return array(
//    array('by_user, to_user, job_bid_id, review, rating, status, created_at, updated_at', 'required'),
            array('by_user, to_user, review', 'required'),
            array('job_bid_id', 'required','message' => 'Please select a project.'),
            array('status', 'numerical', 'integerOnly' => true),
            array('rating', 'numerical'),
            array('by_user, to_user, job_bid_id', 'length', 'max' => 20),
// The following rule is used by search().
// Please remove those attributes that should not be searched.
            array('id, by_user, to_user, job_bid_id, review, rating, status, created_at, updated_at', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
// NOTE: you may need to adjust the relation name and the related
// class name for the relations automatically generated below.
        return array(
            'job_bid' => array(self::BELONGS_TO, 'JobBid', 'job_bid_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'by_user' => 'By User',
            'to_user' => 'To User',
            'job_bid_id' => 'Job Bid',
            'review' => 'Review',
            'rating' => 'Rating',
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
        $criteria->compare('by_user', $this->by_user, true);
        $criteria->compare('to_user', $this->to_user, true);
        $criteria->compare('job_bid_id', $this->job_bid_id, true);
        $criteria->compare('review', $this->review, true);
        $criteria->compare('rating', $this->rating);
        $criteria->compare('status', $this->status);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('updated_at', $this->updated_at, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    }
