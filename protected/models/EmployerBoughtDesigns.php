<?php

/**
 * This is the model class for table "employer_bought_designs".
 *
 * The followings are the available columns in table 'employer_bought_designs':
 * @property string $id
 * @property string $employer_id
 * @property string $track_id
 * @property integer $type
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 */
class EmployerBoughtDesigns extends Model
    {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return EmployerBoughtDesigns the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'employer_bought_designs';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
// NOTE: you should only define rules for those attributes that
// will receive user inputs.
        return array(
            array('employer_id, track_id, type, status', 'required'),
            array('type, status', 'numerical', 'integerOnly' => true),
            array('employer_id, track_id', 'length', 'max' => 20),
// The following rule is used by search().
// Please remove those attributes that should not be searched.
            array('id, employer_id, track_id, type, status, created_at, updated_at', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
// NOTE: you may need to adjust the relation name and the related
// class name for the relations automatically generated below.
        return array(
            'employer' => array(self::BELONGS_TO, 'UserMaster', 'employer_id'),
            'transaction' => array(self::BELONGS_TO, 'TransactionReport', 'transaction_report_id'),
            'job_bid' => array(self::BELONGS_TO, 'JobBid', 'track_id'),
            'manufacturer_job_bid' => array(self::BELONGS_TO, 'ManufacturerJobBid', 'track_id'),
            'catalog' => array(self::BELONGS_TO, 'Catalog', 'track_id'),
            'maufacturerCatalog' => array(self::BELONGS_TO, 'ManufacturerCatalog', 'track_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'employer_id' => 'Employer',
            'track_id' => 'Track',
            'type' => 'Type',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
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

        if (isset($_GET['sSearch']))
            {
            $criteria->compare('id', $_GET['sSearch'], true, 'OR');
            $criteria->compare('employer_id', $_GET['sSearch'], true, 'OR');
            $criteria->compare('track_id', $_GET['sSearch'], true, 'OR');
            $criteria->compare('type', $_GET['sSearch'], true, 'OR');
            $criteria->compare('status', $_GET['sSearch'], true, 'OR');
            $criteria->compare('payment_notification', $_GET['sSearch'], true, 'OR');
            $criteria->compare('created_at', $_GET['sSearch'], true, 'OR');
            $criteria->compare('updated_at', $_GET['sSearch'], true, 'OR');
            }

        $criteria->compare('id', $this->id, true);
        $criteria->compare('employer_id', $this->employer_id, true);
        $criteria->compare('track_id', $this->track_id, true);
        $criteria->compare('type', $this->type);
        $criteria->compare('status', $this->status);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('updated_at', $this->updated_at, true);

        $sort = new EDTSort(__CLASS__, $columns);
        $sort->defaultOrder = 'payment_notification=1 DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => $sort,
            'pagination' => $pagination,
        ));
    }

    public function getPayername($id) {
        if (isset($id) && $id != '')
            {
            $payemnt_made_to = '';
            $employerBD = EmployerBoughtDesigns::model()->findByPk($id);
            if ($employerBD != '')
                {
                if ($employerBD->type == 1)
                    {
                    $payemnt_made_to = $employerBD->job_bid->designer->username;
                    }
                elseif ($employerBD->type == 2)
                    {
                    $payemnt_made_to = $employerBD->manufacturer_job_bid->manufacturer->username;
                    }
                elseif ($employerBD->type == 3)
                    {
                    $payemnt_made_to = $employerBD->catalog->designer->username;
                    }
                }
            }
//            $criteria->with = array('job_bid', 'job_bid.designer');
        return $payemnt_made_to;
    }

    public function getAllDoc($id) {
        if (isset($id) && $id != '')
            {
            $data = [];
            $ext = '';
            $payemnt_made_to = $buy_type = $purchased_img = $description = '';
            $employerBD = EmployerBoughtDesigns::model()->findByPk($id);
            if ($employerBD != '')
                {
                if ($employerBD->type == 1)
                    {
                    $buy_type = 'Employer purchased designers design against own posted project';
                    $payemnt_made_to = $employerBD->job_bid->designer->username;
                    $payment_made_to_paypal_email = $employerBD->job_bid->designer->paypal_marchant_email;
                    $ext = pathinfo($employerBD->job_bid->uploaded_file, PATHINFO_EXTENSION);
                    if ($ext == 'stl')
                        {
                        $org_file_name = explode(".", $employerBD->job_bid->uploaded_file);
                        $purchased_img = 'jobs/' . $org_file_name[0] . '.jpg';
                        }
                    else
                        {
                        $purchased_img = 'jobs/' . $employerBD->job_bid->uploaded_file;
                        }
                    $description = $employerBD->job_bid->job->description;
                    }
                elseif ($employerBD->type == 2)
                    {
                    $payemnt_made_to = $employerBD->manufacturer_job_bid->manufacturer->username;
                    $payment_made_to_paypal_email = $employerBD->manufacturer_job_bid->manufacturer->paypal_marchant_email;
                    if ($employerBD->manufacturer_job_bid->type == '1')
                        {
                        $ext = pathinfo($employerBD->manufacturer_job_bid->bid->uploaded_file, PATHINFO_EXTENSION);
                        $buy_type = 'Employer purchased manufacturer Bid against his purchased design against own posted project';
                        if ($ext == 'stl')
                            {
                            $org_file_name = explode(".", $employerBD->manufacturer_job_bid->bid->uploaded_file);
                            $purchased_img = 'jobs/' . $org_file_name[0] . '.jpg';
                            }
                        else
                            {
                            $purchased_img = 'jobs/' . $employerBD->manufacturer_job_bid->bid->uploaded_file;
                            }
                        $description = $employerBD->manufacturer_job_bid->bid->job->description;
                        }
                    elseif ($employerBD->manufacturer_job_bid->type == '2')
                        {
                        $ext = pathinfo($employerBD->manufacturer_job_bid->catalog->uploaded_file, PATHINFO_EXTENSION);
                        $buy_type = 'Employer purchased manufacturer Bid against his purchased catalog';
                        if ($ext == 'stl')
                            {
                            $org_file_name = explode(".", $employerBD->manufacturer_job_bid->catalog->uploaded_file);
                            $purchased_img = 'catalog/' . $org_file_name[0] . '.jpg';
                            }
                        else
                            {
                            $purchased_img = 'catalog/' . $employerBD->manufacturer_job_bid->catalog->uploaded_file;
                            }
                        $description = $employerBD->manufacturer_job_bid->catalog->title;
                        }
                    }
                elseif ($employerBD->type == 3)
                    {
                    $ext = pathinfo($employerBD->catalog->uploaded_file, PATHINFO_EXTENSION);
                    $buy_type = 'Employer Purchased Designers Catalog';
                    $payemnt_made_to = $employerBD->catalog->designer->username;
                    $payment_made_to_paypal_email = $employerBD->catalog->designer->paypal_marchant_email;
                    if ($ext == 'stl')
                        {
                        $org_file_name = explode(".", $employerBD->catalog->uploaded_file);
                        $purchased_img = 'catalog/' . $org_file_name[0] . '.jpg';
                        }
                    else
                        {
                        $purchased_img = 'catalog/' . $employerBD->catalog->uploaded_file;
                        }
                    $description = $employerBD->catalog->title;
                    }
                else if ($employerBD->type == 4)
                    {
                    $ext = pathinfo($employerBD->maufacturerCatalog->uploaded_file, PATHINFO_EXTENSION);
                    $buy_type = 'Employer Purchased Manufacturer Catalog';
                    $payemnt_made_to = $employerBD->maufacturerCatalog->manufacturer->username;
                    $payment_made_to_paypal_email = $employerBD->maufacturerCatalog->manufacturer->paypal_marchant_email;
                    if ($ext == 'stl')
                        {
                        $org_file_name = explode(".", $employerBD->maufacturerCatalog->uploaded_file);
                        $purchased_img = 'manufacturer_catalog/' . $org_file_name[0] . '.jpg';
                        }
                    else
                        {
                        $purchased_img = 'manufacturer_catalog/' . $employerBD->maufacturerCatalog->uploaded_file;
                        }
                    $description = $employerBD->maufacturerCatalog->title;
                    }
                }
            }
        $data['payment_made_by'] = $employerBD->employer->username;
        $data['payment_made_to'] = $payemnt_made_to;
        $data['payment_made_to_paypal_email'] = $payment_made_to_paypal_email;        
        $data['Buy_type'] = $buy_type;
        $data['purchased_img'] = $purchased_img;
        $data['description'] = $description;
        $data['token'] = $employerBD->transaction->token;
        $data['transaction_id'] = $employerBD->transaction->transaction_id;
        $data['payment_release_status'] = $employerBD->payment_notification == 3 ? 'Payment released' : 'Payment not released yet';
        $data['payment_made_at'] = $employerBD->transaction->created_at;
        $data['payment_through'] = $employerBD->transaction->payment_type == '1' ? 'Paypal' : 'Credit Card';
        $data['payment_amount'] = $employerBD->transaction->amount;

        return $data;
    }

    }
