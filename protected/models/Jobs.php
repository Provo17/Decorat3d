<?php

/**
 * This is the model class for table "jobs".
 *
 * The followings are the available columns in table 'jobs':
 * @property string $id
 * @property string $added_by
 * @property string $title
 * @property string $description
 * @property string $dimention
 * @property string $colour
 * @property string $uploaded_file
 * @property string $is_featured
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 */
class Jobs extends Model
    {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Jobs the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'jobs';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
// NOTE: you should only define rules for those attributes that
// will receive user inputs.
        return array(
//            array('description,uploaded_file, dimention, colour', 'required', 'on' => 'insert'),
            array('description,dimention, colour', 'required', 'on' => 'insert'),
            array('uploaded_file', 'file', 'allowEmpty' => true, 'types' => 'stl,zip,rar,jpg,jpeg,gif,png'),
            array('added_by', 'length', 'max' => 20),
            array('title', 'length', 'max' => 105),
            array('description', 'length', 'max' => 205),
            array('dimention, colour', 'length', 'max' => 35),
            array('uploaded_file', 'length', 'max' => 55),
            array('is_featured', 'length', 'max' => 3),
            array('status', 'length', 'max' => 1),
// The following rule is used by search().
// Please remove those attributes that should not be searched.
            array('id, added_by, title, description, dimention, colour, uploaded_file, is_featured, status, created_at, updated_at', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
// NOTE: you may need to adjust the relation name and the related
// class name for the relations automatically generated below.
        return array(
            'job_owner' => array(self::BELONGS_TO, 'UserMaster', 'added_by'),
            'chat_thread' => array(self::HAS_ONE, 'ChatMaster', 'track_id'),
//            'dimention_master' => array(self::BELONGS_TO, 'DimentionMaster', 'dimention'),
            'jobBids'=>[self::HAS_MANY, 'JobBid', 'jobs_id', 'condition'=>'status="1"']
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'added_by' => 'Added By',
            'title' => 'Title',
            'description' => 'Description',
            'dimention' => 'Dimension',
            'colour' => 'Color',
            'uploaded_file' => 'Upload File',
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
    public function search($columns) {
// Warning: Please modify the following code to remove attributes that
// should not be searched.

        $criteria = new CDbCriteria;
        $pagination = new EDTPagination();

        if (isset($_GET['sSearch']))
            {
            $criteria->compare('id', $_GET['sSearch'], true, 'OR');
            $criteria->compare('added_by', $_GET['sSearch'], true, 'OR');
            $criteria->compare('title', $_GET['sSearch'], true, 'OR');
            $criteria->compare('description', $_GET['sSearch'], true, 'OR');
            $criteria->compare('dimention', $_GET['sSearch'], true, 'OR');
            $criteria->compare('colour', $_GET['sSearch'], true, 'OR');
            $criteria->compare('status', $_GET['sSearch'], true, 'OR');
            $criteria->compare('created_at', $_GET['sSearch'], true, 'OR');
            $criteria->compare('updated_at', $_GET['sSearch'], true, 'OR');
            }

        $criteria->compare('id', $this->id, true);
        $criteria->compare('added_by', $this->added_by, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('dimention', $this->dimention, true);
        $criteria->compare('colour', $this->colour, true);
        $criteria->compare('uploaded_file', $this->uploaded_file, true);
        $criteria->compare('is_featured', $this->is_featured, true);
        $criteria->compare('status', $this->status, true);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('updated_at', $this->updated_at, true);

        $sort = new EDTSort(__CLASS__, $columns);
        $sort->defaultOrder = 'id DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => $sort,
            'pagination' => $pagination,
        ));
    }

    }
