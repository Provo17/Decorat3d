<?php

/**
 * This is the model class for table "manufacturer_catalog".
 *
 * The followings are the available columns in table 'manufacturer_catalog':
 * @property string $id
 * @property string $manufacturer_id
 * @property string $title
 * @property double $price
 * @property string $uploaded_file
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 */
class ManufacturerCatalog extends Model
    {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ManufacturerCatalog the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'manufacturer_catalog';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
// NOTE: you should only define rules for those attributes that
// will receive user inputs.
        return array(
            array('title, price, uploaded_file', 'required'),
            array('uploaded_file', 'file', 'allowEmpty' => true, 'types' => 'stl,zip,rar,jpg,jpeg,gif,png'),
            array('status', 'numerical', 'integerOnly' => true),
            array('price', 'numerical'),
            array('manufacturer_id', 'length', 'max' => 20),
            array('uploaded_file', 'length', 'max' => 255),
// The following rule is used by search().
// Please remove those attributes that should not be searched.
            array('id, manufacturer_id, title, price, uploaded_file, status, created_at, updated_at', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
// NOTE: you may need to adjust the relation name and the related
// class name for the relations automatically generated below.
        return array(
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
            'title' => 'Title',
            'price' => 'Price',
            'uploaded_file' => 'Uploaded File',
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
        $criteria->compare('title', $this->title, true);
        $criteria->compare('price', $this->price);
        $criteria->compare('uploaded_file', $this->uploaded_file, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('updated_at', $this->updated_at, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    }
