<?php

class Message extends Model {

    public $country_flag = '';
    public $lang_name = '';

    /**
     * @return Message
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string Table name
     */
    public function tableName() {
        return '{{message}}';
    }

    public function rules() {
// NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('translation', 'required','on' => 'update'),
            array('id, language', 'unsafe', 'on' => 'update'),
            array('id, language, translation', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'language' => 'Language',
            'translation' => 'Translation',
            'country_flag' => 'Country flag',
        );
    }

    public function search($columns) {
        $criteria = new CDbCriteria;
        $pagination = new EDTPagination();

        if (isset($_GET['sSearch'])) {
            $criteria->compare('translation', $_GET['sSearch'], true, 'OR');
        }
        $criteria->compare('id', $this->id, true);
        $criteria->compare('language', $this->language, true);
        $criteria->compare('translation', $this->translation, true);

        $sort = new EDTSort(__CLASS__, $columns);
        $sort->defaultOrder = 'id';
        return new CActiveDataProvider($this, [
            'criteria' => $criteria,
            'sort' => $sort,
            'pagination' => $pagination,
        ]);
    }

    /*
     * depending on language choose the country flag with HTML img tag
     */

    protected function afterFind() {
        $this->country_flag = 'fdfd';
        $country = ['en' => 'GB', 'da' => 'DK', 'de' => 'DE'];
        //Yii::app()->getModule('modulename')->getAssetsUrl() 
        //var_dump(Yii::app()->getModule('language'));
        if (isset($country[$this->language])) {
            // $src = Yii::app()->getModule('language')->getAssetsUrl() . "/images/{$this->language}_{$country[$this->language]}.png"; //Yii::app()->getModule('language')->getAssetsUrl() .
            $src = Yii::app()->baseUrl . "/images/{$this->language}_{$country[$this->language]}.png";
            $this->country_flag = CHtml::image($src, "logo");
        }
        switch ($this->language) {
            case 'da':$this->lang_name = 'Danish';
                break;
            case 'de':$this->lang_name = 'German';
                break;
            default : $this->lang_name = 'English';
        }
        return parent::afterFind(); //To raise the parent event
    }

}