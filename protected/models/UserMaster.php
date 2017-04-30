<?php

/**
 * This is the model class for table "{{admin_user}}".
 *
 * The followings are the available columns in table '{{admin_user}}':
 * @property string $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $role
 * @property string $create_at
 * @property string $update_at
 * @property integer $status
 */
class UserMaster extends CActiveRecord {

    public $pass;
    public $reset_new_password;
    public $reset_confirm_new_password;
    public $old_password;
    public $new_password;
    public $new_conf_email;
    public $new_email;
    public $new_conf_password;
// holds the password confirmation word
    public $repeat_password;
    //will hold the encrypted password for update actions.
    public $initialPassword;
    public $accept_term_condition;

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    //user type
    const ROLE_ADMIN = 'admin';

    //const TYPE_RECEPTIONIST = 2;
    //const TYPE_PROFESSONAL = 3;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{user_master}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('old_password,new_password,new_conf_password', 'required', 'on' => 'user_password_change'),
            array('new_conf_password', 'compare', 'compareAttribute' => 'new_password', 'on' => 'user_password_change'),
            array('email,password,new_conf_email,new_email', 'required', 'on' => 'user_email_change'),
            array('new_conf_email', 'compare', 'compareAttribute' => 'new_email', 'on' => 'user_email_change'),
            array('name,email', 'required', 'on' => 'userProfileUpdate'),
            array('username,email,zip', 'required', 'on' => 'admin_both_update'),
            array('username', 'unique'),
            array('username,email,password,zip,accept_term_condition,security_question_id,security_question_ans', 'required', 'on' => 'register'),
            array('username,zip,security_question_id,security_question_ans,description', 'required', 'on' => 'user_profile_update'),
            array('description', 'length', 'max' => 1200, 'on' => 'user_profile_update'),
            array('zip', 'numerical', 'on' => 'register'),
            array('email', 'required', 'on' => 'forgot-pwd'),
            array('reset_new_password,reset_confirm_new_password', 'required', 'on' => 'reset-pwd'),
            array('reset_confirm_new_password', 'compare', 'compareAttribute' => 'reset_new_password', 'on' => 'reset-pwd'),
            array('email', 'required', 'on' => 'socialSite'),
            array('bank_acc_no', 'numerical', 'on' => 'user_facc_details'),
            array('paypal_marchant_email', 'email', 'on' => 'user_facc_details'),
            array('username', 'required', 'on' => 'socialSiteUserName'),
//            array('email', 'unique', 'criteria' => array('condition' => 'status<>3'), 'on' => 'update'),
            //  array('name', 'length', 'max' => 50),
//            array('email', 'length', 'max' => 254),
            array('email', 'email'),
            array('email', 'unique', 'except' => 'forgot-pwd'),
//            array('password, repeat_password', 'length', 'min' => 6, 'max' => 15),
            // array('password', 'compare', 'compareAttribute' => 'repeat_password'),
            array('user_type_id', 'length', 'max' => 20),
            array('password,pass, repeat_password', 'required', 'on' => 'updateProfilePassword'),
            array('repeat_password', 'compare', 'compareAttribute' => 'pass', 'on' => 'updateProfilePassword'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, email, password, user_type_id,created_at, updated_at, status', 'safe', 'on' => 'search'),
            array('email, password', 'safe'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'userskill' => array(self::HAS_MANY, 'UserSkill', 'user_master_id'),
            'jobs'=>[self::HAS_MANY, 'Jobs', 'added_by', 'condition'=>'status="1"'],
            'jobBid' => array(self::HAS_MANY, 'JobBid', 'user_master_id'),
            'manufacturerJobBid' => array(self::HAS_MANY, 'ManufacturerJobBid', 'manufacturer_id'),
            'disputeConversations'=>array(self::HAS_MANY, 'DisputeConversation', 'user_id')
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            //   'name' => 'Name',
            'email' => 'Email',
            'pass' => 'New Password',
            'new_conf_password' => 'New Confirm Password',
            'reset_confirm_new_password' => 'Confirm Password',
            'security_question_id' => 'Security Question',
            'security_question_ans' => 'Security Question Answer',
            'password' => 'Password',
            'zip' => 'Zip Code',
            'bank_acc_no' => 'Bank Account No',
            'routing_no' => 'Routing No',
            'user_type_id' => 'Roles',
            'created_at' => 'Create At',
            'updated_at' => 'Update At',
            'status' => 'Status',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search($columns, $user_type) {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $pagination = new EDTPagination();

        if (isset($_GET['sSearch'])) {
            $criteria->compare('id', $_GET['sSearch'], true, 'OR');
            $criteria->compare('name', $_GET['sSearch'], true, 'OR');
            $criteria->compare('username', $_GET['sSearch'], true, 'OR');
            $criteria->compare('email', $_GET['sSearch'], true, 'OR');
            $criteria->compare('zip', $_GET['sSearch'], true, 'OR');
            $criteria->compare('status', $_GET['sSearch'], true, 'OR');
            $criteria->compare('created_at', $_GET['sSearch'], true, 'OR');
            $criteria->compare('updated_at', $_GET['sSearch'], true, 'OR');
        }

        $criteria->compare('id', $this->id, true);
        $criteria->compare('user_type_id', $user_type, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('username', $this->username, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('zip', $this->zip, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('updated_at', $this->updated_at, true);
        $criteria->addCondition("status != 3");

        $sort = new EDTSort(__CLASS__, $columns);
        $sort->defaultOrder = 'id DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => $sort,
            'pagination' => $pagination,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return AdminUser the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeSave() {
        // in this case, we will use the old hashed password.
        if (empty($this->password) && empty($this->repeat_password) && !empty($this->initialPassword)) {
            $this->password = $this->initialPassword;
        }

        if ($this->isNewRecord) {
            $this->created_at = date('Y-m-d H:i:s');
        } else {
            if (!empty($this->password) && !empty($this->repeat_password)) {
                $this->password = md5($this->password);
            }
            $this->updated_at = date('Y-m-d H:i:s');
        }

        return parent::beforeSave();
    }

    public function afterFind() {
        //reset the password to null because we don't want the hash to be shown.
        $this->initialPassword = $this->password;
        $this->password = null;

        parent::afterFind();
    }

    public function saveModel($data = array()) {
        //because the hashes needs to match
        if (!empty($data['password']) && !empty($data['repeat_password'])) {
            $data['password'] = $data['password'];
            $data['repeat_password'] = $data['repeat_password'];
        }
        $this->attributes = $data;

        if ($this->save()) {
            if (isset($data['password']) && $data['password'] != '') {
                $this->password = md5($data['password']);
                $this->save(false);
            }
        } else {
            return CHtml::errorSummary($this);
        }

        return true;
    }

    public function showThumbImage() {
        return CHtml::Image(Yii::app()->baseUrl . '/upload/usersImage/thumb/' . $this->profile_image);
    }

}
