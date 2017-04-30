<?php

/**
 * This is the model class for table "{{cms}}".
 *
 * The followings are the available columns in table '{{cms}}':
 * @property string $id
 * @property string $slug
 * @property string $content
 * @property string $created_at
 * @property string $updated_at
 */
class Cms extends Model {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Cms the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{cms}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
// NOTE: you should only define rules for those attributes that
// will receive user inputs.
        return array(
            array('slug, content_en,created_at, updated_at', 'required'),
//            array('slug, content_en,content_gr, created_at, updated_at', 'required'),
            array('slug', 'length', 'max' => 100),
// The following rule is used by search().
// Please remove those attributes that should not be searched.
            array('id, slug, content, created_at, updated_at', 'safe', 'on' => 'search'),
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
            'content_en' => 'Content In English',
            'content_gr' => 'Content In Greek',
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
        $criteria->compare('slug', $this->slug, true);
        $criteria->compare('content_en', $this->content_en, true);
        $criteria->compare('content_gr', $this->content_gr, true);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('updated_at', $this->updated_at, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
