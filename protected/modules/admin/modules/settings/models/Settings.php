<?php

/**
 * This is the model class for table "{{settings}}".
 *
 * The followings are the available columns in table '{{settings}}':
 * @property string $id
 * @property string $slug
 * @property string $title
 * @property string $description
 * @property string $type
 * @property string $default
 * @property string $value
 * @property string $options
 * @property integer $is_required
 * @property integer $is_gui
 * @property string $module
 * @property integer $row_order
 */
class Settings extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Settings the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{settings}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
// NOTE: you should only define rules for those attributes that
// will receive user inputs.
        return array(
            array('slug, title, description, type, default, value, options, is_required, is_gui, module', 'required'),
            array('is_required, is_gui, row_order', 'numerical', 'integerOnly' => true),
            array('slug, title', 'length', 'max' => 100),
            array('module', 'length', 'max' => 50),
// The following rule is used by search().
// Please remove those attributes that should not be searched.
            array('id, slug, title, description, type, default, value, options, is_required, is_gui, module, row_order', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
// NOTE: you may need to adjust the relation name and the related
// class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'slug' => 'Slug',
            'title' => 'Title',
            'description' => 'Description',
            'type' => 'Type',
            'default' => 'Default',
            'value' => 'Value',
            'options' => 'Options',
            'is_required' => 'Is Required',
            'is_gui' => 'Is Gui',
            'module' => 'Module',
            'row_order' => 'Row Order',
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
        $criteria->compare('slug', $this->slug, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('type', $this->type, true);
        $criteria->compare('default', $this->default, true);
        $criteria->compare('value', $this->value, true);
        $criteria->compare('options', $this->options, true);
        $criteria->compare('is_required', $this->is_required);
        $criteria->compare('is_gui', $this->is_gui);
        $criteria->compare('module', $this->module, true);
        $criteria->compare('row_order', $this->row_order);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function mysql_version() {
        $version = Yii::app()->db->createCommand('SELECT VERSION() as version')->queryRow();
        if (is_array($version) && isset($version['version']))
            return $version['version'];
        else
            return 'NA';
    }

}