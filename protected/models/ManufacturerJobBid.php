<?php

/**
 * This is the model class for table "manufacturer_job_bid".
 *
 * The followings are the available columns in table 'manufacturer_job_bid':
 * @property string $id
 * @property string $manufacturer_id
 * @property string $jobs_id
 * @property string $job_bid_id
 * @property string $price
 * @property string $is_featured
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 */
class ManufacturerJobBid extends Model
    {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ManufacturerJobBid the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'manufacturer_job_bid';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
// NOTE: you should only define rules for those attributes that
// will receive user inputs.
        return array(
            array('manufacturer_id, jobs_id, job_bid_id, price, is_featured, status', 'required'),
            array('manufacturer_id, jobs_id, job_bid_id, price', 'length', 'max' => 20),
            array('price', 'numerical'),
            array('is_featured', 'length', 'max' => 3),
            array('status', 'length', 'max' => 1),
// The following rule is used by search().
// Please remove those attributes that should not be searched.
            array('id, manufacturer_id, jobs_id, job_bid_id, price, is_featured, status, created_at, updated_at', 'safe', 'on' => 'search'),
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
            'catalog' => array(self::BELONGS_TO, 'Catalog', 'jobs_id'),
            'bid' => array(self::BELONGS_TO, 'JobBid', 'job_bid_id'),
            'manufacturer' => array(self::BELONGS_TO, 'UserMaster', 'manufacturer_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'manufacturer_id' => 'Manufacturer',
            'jobs_id' => 'Jobs',
            'job_bid_id' => 'Job Bid',
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
        $criteria->compare('manufacturer_id', $this->manufacturer_id, true);
        $criteria->compare('jobs_id', $this->jobs_id, true);
        $criteria->compare('job_bid_id', $this->job_bid_id, true);
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
