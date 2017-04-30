<?php

class Model extends CActiveRecord {

    const ACTIVE = 1;
    const INACTIVE = 0;

    public $created_at;
    public $updated_at;

    public function beforeSave()
    {
        if ($this->isNewRecord)
        {
            $this->created_at = date('Y-m-d H:i:s');
            $this->updated_at = '0000-00-00 00:00:00';
        }
        else
        {
            $this->updated_at = date('Y-m-d H:i:s');
        }
        return parent::beforeSave();
    }

}
