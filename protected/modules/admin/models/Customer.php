<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property string $id
 * @property string $user_name
 * @property string $email
 * @property string $first_name
 * @property string $last_name
 * @property string $password_hash
 * @property string $phone
 * @property string $salt
 * @property string $address1
 * @property string $address2
 * @property string $zip
 * @property string $city
 * @property string $state
 * @property integer $country_id
 * @property string $company
 * @property integer $verify_email
 * @property string $confirmation_token
 * @property integer $status
 * @property integer $blocked_by_admin
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 */
class Customer extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Customer the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'user';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
// NOTE: you should only define rules for those attributes that
// will receive user inputs.
        return array(
            array('first_name,last_name,user_name,email,password_hash,phone, state,country_id', 'required', 'on' => 'customer_update'),
            array('email', 'email', 'on' => 'customer_update'),
            array('email', 'unique', 'on' => 'customer_update'),
            //array('phone', 'required'),
            array('first_name,last_name,', 'match',
                'pattern' => '/^[A-Za-z]+$/u',
                'message' => ' Name can contain only Character', 'on' => 'customer_update'
            ),
            array('user_name', 'match',
                'pattern' => '/^[A-Za-z0-9]+$/u',
                'message' => ' User Name can contain only alphanumeric',
            ),
            array('country_id, verify_email, status, blocked_by_admin', 'numerical', 'integerOnly' => true),
            array('user_name, city', 'length', 'max' => 50),
            array('email, state, company, confirmation_token', 'length', 'max' => 100),
            array('first_name, last_name, zip', 'length', 'max' => 20),
            array('password_hash', 'length', 'min' => 6),
            array('phone', 'length', 'min' => 10),
            array('salt', 'length', 'max' => 60),
            // array('address1, address2, created_at, updated_at, deleted_at', 'safe'),
// The following rule is used by search().
// Please remove those attributes that should not be searched.
            array('id, user_name, email, first_name, last_name, password_hash, phone, salt, address1, address2, zip, city, state, country_id, company, verify_email, confirmation_token, status, blocked_by_admin, created_at, updated_at, deleted_at', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
// NOTE: you may need to adjust the relation name and the related
// class name for the relations automatically generated below.
        return array(
            'country' => array(self::BELONGS_TO, 'Country', 'country_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'user_name' => 'User Name',
            'email' => 'Email',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'password_hash' => 'Password',
            'phone' => 'Phone',
            'salt' => 'Salt',
            'address1' => 'Address1',
            'address2' => 'Address2',
            'zip' => 'Zip',
            'city' => 'City',
            'state' => 'State',
            'country_id' => 'Country',
            'company' => 'Company',
            'verify_email' => 'Verify Email',
            'confirmation_token' => 'Confirmation Token',
            'status' => 'Status',
            'blocked_by_admin' => 'Blocked By Admin',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        );
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

        if (isset($_GET['sSearch'])) {
            $criteria->compare('id', $_GET['sSearch'], true, 'OR');
            $criteria->compare('user_name', $_GET['sSearch'], true, 'OR');
            $criteria->compare('email', $_GET['sSearch'], true, 'OR');
            $criteria->compare('first_name', $_GET['sSearch'], true, 'OR');
            $criteria->compare('last_name', $_GET['sSearch'], true, 'OR');
            $criteria->compare('password_hash', $_GET['sSearch'], true, 'OR');
            $criteria->compare('phone', $_GET['sSearch'], true, 'OR');
            $criteria->compare('salt', $_GET['sSearch'], true, 'OR');
            $criteria->compare('address1', $_GET['sSearch'], true, 'OR');
            $criteria->compare('address2', $_GET['sSearch'], true, 'OR');
            $criteria->compare('zip', $_GET['sSearch'], true, 'OR');
            $criteria->compare('city', $_GET['sSearch'], true, 'OR');
            $criteria->compare('state', $_GET['sSearch'], true, 'OR');
            $criteria->compare('country_id', $_GET['sSearch'], true, 'OR');
            $criteria->compare('company', $_GET['sSearch'], true, 'OR');
            $criteria->compare('verify_email', $_GET['sSearch'], true, 'OR');
            $criteria->compare('confirmation_token', $_GET['sSearch'], true, 'OR');
            $criteria->compare('status', $_GET['sSearch'], true, 'OR');
            $criteria->compare('blocked_by_admin', $_GET['sSearch'], true, 'OR');
            $criteria->compare('created_at', $_GET['sSearch'], true, 'OR');
            $criteria->compare('updated_at', $_GET['sSearch'], true, 'OR');
            $criteria->compare('deleted_at', $_GET['sSearch'], true, 'OR');
        }
        $criteria->compare('id', $this->id, true);
        $criteria->compare('user_name', $this->user_name, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('first_name', $this->first_name, true);
        $criteria->compare('last_name', $this->last_name, true);
        $criteria->compare('password_hash', $this->password_hash, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('salt', $this->salt, true);
        $criteria->compare('address1', $this->address1, true);
        $criteria->compare('address2', $this->address2, true);
        $criteria->compare('zip', $this->zip, true);
        $criteria->compare('city', $this->city, true);
        $criteria->compare('state', $this->state, true);
        $criteria->compare('country_id', $this->country_id);
        $criteria->compare('company', $this->company, true);
        $criteria->compare('verify_email', $this->verify_email);
        $criteria->compare('confirmation_token', $this->confirmation_token, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('blocked_by_admin', $this->blocked_by_admin);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('updated_at', $this->updated_at, true);
        $criteria->compare('deleted_at', $this->deleted_at, true);

        $sort = new EDTSort(__CLASS__, $columns);
        $sort->defaultOrder = 'id DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => $sort,
            'pagination' => $pagination,
        ));
    }

}
