<?php

/**
 * This is the model class for table "page".
 *
 * The followings are the available columns in table 'page':
 * @property string $id
 * @property string $slug
 * @property string $title
 * @property string $description
 * @property string $seo_title
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $created_at
 * @property string $updated_at
 */
class Page extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Page the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'page';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('slug, title, seo_title', 'length', 'max' => 100),
            array('description, meta_keywords, meta_description, created_at, updated_at', 'safe'),
            array('id, slug, title, description, seo_title, meta_keywords, meta_description, created_at, updated_at', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        return [];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'slug' => 'Slug',
            'title' => 'Title',
            'content' => 'Content',
            'seo_title' => 'Seo Title',
            'meta_keywords' => 'Meta Keywords',
            'meta_description' => 'Meta Description',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search($columns) {
        $criteria = new CDbCriteria;
        $pagination = new EDTPagination();

        if (isset($_GET['sSearch'])) {
            $criteria->compare('id', $_GET['sSearch'], true, 'OR');
            $criteria->compare('slug', $_GET['sSearch'], true, 'OR');
            $criteria->compare('title', $_GET['sSearch'], true, 'OR');
            $criteria->compare('content', $_GET['sSearch'], true, 'OR');
            $criteria->compare('seo_title', $_GET['sSearch'], true, 'OR');
            $criteria->compare('meta_keywords', $_GET['sSearch'], true, 'OR');
            $criteria->compare('meta_description', $_GET['sSearch'], true, 'OR');
            $criteria->compare('created_at', $_GET['sSearch'], true, 'OR');
            $criteria->compare('updated_at', $_GET['sSearch'], true, 'OR');
        }


        $criteria->compare('id', $this->id, true);
        $criteria->compare('slug', $this->slug, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('seo_title', $this->seo_title, true);
        $criteria->compare('meta_keywords', $this->meta_keywords, true);
        $criteria->compare('meta_description', $this->meta_description, true);
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
