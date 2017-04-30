<?php

class UrlManager extends CUrlManager {

    public function createUrl($route, $params = array(), $ampersand = '&') {
     
        //create url without lang for bellow modules
        $module = ['admin','supplier', 'language', 'admin/settings', "admin/language", 'translate', 'gii'];
        //echo Yii::app()->controller->module->id;
        if (isset(Yii::app()->controller->module->id) && in_array(Yii::app()->controller->module->id, $module)) {            
            return parent::createUrl($route, $params, $ampersand);
        }
        if (!isset($params['language'])) {
            if (Yii::app()->user->hasState('language'))
                Yii::app()->language = Yii::app()->user->getState('language');
            else if (isset(Yii::app()->request->cookies['language']))
                Yii::app()->language = Yii::app()->request->cookies['language']->value;
            $params['language'] = Yii::app()->language;
        }
        return parent::createUrl($route, $params, $ampersand);
    }

}