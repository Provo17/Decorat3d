<?php

class SourceMessage extends Model {

    /**
     * @return SourceMessage
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string Table name
     */
    public function tableName() {
        return '{{source_message}}';
    }

}