<?php

/**
 * This is the model class for table "cart".
 *
 * The followings are the available columns in table 'cart':
 * @property integer $id
 * @property string $user_id
 * @property string $bid_id
 * @property integer $amount
 * @property string $added_at
 *
 * The followings are the available model relations:
 * @property UserMaster $user
 * @property JobBid $bid
 */
class Cart extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Cart the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'cart';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
// NOTE: you should only define rules for those attributes that
// will receive user inputs.
        return array(
            array('user_id, bid_id, amount', 'required'),
            array('amount', 'numerical', 'integerOnly' => true),
            array('user_id, bid_id', 'length', 'max' => 20),
// The following rule is used by search().
// Please remove those attributes that should not be searched.
            array('id, user_id, bid_id, amount, added_at', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
// NOTE: you may need to adjust the relation name and the related
// class name for the relations automatically generated below.
        return array(
            'user' => array(self::BELONGS_TO, 'UserMaster', 'user_id'),
            'bid' => array(self::BELONGS_TO, 'JobBid', 'bid_id'),
            'manufacturerbid' => array(self::BELONGS_TO, 'ManufacturerJobBid', 'bid_id'),
            'designer_catalog' => array(self::BELONGS_TO, 'Catalog', 'bid_id'),
            'manufacturerCatalog' => array(self::BELONGS_TO, 'ManufacturerCatalog', 'bid_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'user_id' => 'User',
            'bid_id' => 'Bid',
            'amount' => 'Amount',
            'added_at' => 'Added At',
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

        $criteria->compare('id', $this->id);
        $criteria->compare('user_id', $this->user_id, true);
        $criteria->compare('bid_id', $this->bid_id, true);
        $criteria->compare('amount', $this->amount);
        $criteria->compare('added_at', $this->added_at, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
