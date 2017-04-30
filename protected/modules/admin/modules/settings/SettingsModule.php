<?php

class SettingsModule extends CWebModule {

    public function init() {
        $this->setImport(array(
            'settings.models.*',
            'settings.components.*',
        ));
    }

    public function beforeControllerAction($controller, $action) {
        if (parent::beforeControllerAction($controller, $action)) {
            return true;
        }
        else
            return false;
    }

}
