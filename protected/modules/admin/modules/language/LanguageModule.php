<?php

class LanguageModule extends CWebModule {

    private $_assetsUrl;

    public function init() {
        $this->setImport(array(
            'language.models.*',
            'language.components.*',
        ));
    }

    /**
     * @return string the base URL that contains all published asset files of gii.
     */
    public function getAssetsUrl() {
        if ($this->_assetsUrl === null)
            $this->_assetsUrl = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('language.assets'));
        return $this->_assetsUrl;
    }

    /**
     * @param string $value the base URL that contains all published asset files of gii.
     */
    public function setAssetsUrl($value) {
        $this->_assetsUrl = $value;
    }

    public function beforeControllerAction($controller, $action) {
        if (parent::beforeControllerAction($controller, $action)) {
            return true;
        }
        else
            return false;
    }

}
