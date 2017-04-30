<?php

/**
 * This is the model class for table "transaction_report".
 *
 * The followings are the available columns in table 'transaction_report':
 * @property string $id
 * @property string $transaction_id
 * @property string $token
 * @property double $amount
 * @property string $user_id
 * @property string $bid_id
 * @property string $status
 *
 * The followings are the available model relations:
 * @property JobBid $bid
 * @property UserMaster $user
 */
class TransactionReport extends Model
    {
    public $cvv;
    public $expiry_month;
    public $expiry_year;
    public $card_number;
    public $credit_card_type;
    public $card_holder_name;
    public $tc;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return TransactionReport the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'transaction_report';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
// NOTE: you should only define rules for those attributes that
// will receive user inputs.
        return array(
            array('transaction_id, token, amount, user_id, bid_id', 'required','on'=>'paypal'),
            array('cvv, expiry_month, expiry_year, card_number, credit_card_type,card_holder_name', 'required','on'=>'creditCard'),
            array('tc', 'required','on'=>'creditCard','message'=>'Accept Terms and Conditions '),
            array('amount', 'numerical'),
            array('transaction_id', 'length', 'max' => 50),
            array('cvv', 'length', 'max' => 4),
            array('expiry_month', 'length', 'max' => 2),
            array('card_number', 'length', 'max' => 19),
            array('expiry_month,expiry_year,cvv,card_number', 'numerical'),
            array('token', 'length', 'max' => 100),
            array('user_id, bid_id', 'length', 'max' => 20),
            array('status', 'length', 'max' => 2),
// The following rule is used by search().
// Please remove those attributes that should not be searched.
            array('id, transaction_id, token, amount, user_id, bid_id, status', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
// NOTE: you may need to adjust the relation name and the related
// class name for the relations automatically generated below.
        return array(
            'bid' => array(self::BELONGS_TO, 'JobBid', 'bid_id'),
            'manufacturerbid' => array(self::BELONGS_TO, 'ManufacturerJobBid', 'bid_id'),
            'catalog' => array(self::BELONGS_TO, 'Catalog', 'bid_id'),
            'user' => array(self::BELONGS_TO, 'UserMaster', 'user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'transaction_id' => 'Transaction',
            'token' => 'Token',
            'tc'=> 'Terms and Conditions',
            'amount' => 'Amount',
            'user_id' => 'User',
            'bid_id' => 'Bid',
            'status' => 'Status',
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
        $criteria->compare('transaction_id', $this->transaction_id, true);
        $criteria->compare('token', $this->token, true);
        $criteria->compare('amount', $this->amount);
        $criteria->compare('user_id', $this->user_id, true);
        $criteria->compare('bid_id', $this->bid_id, true);
        $criteria->compare('status', $this->status, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    }
