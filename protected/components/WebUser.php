<?php

class WebUser extends CWebUser {

    /**
     * Overrides a Yii method that is used for roles in controllers (accessRules).
     *
     * @param string $operation Name of the operation required (here, a role).
     * @param mixed $params (opt) Parameters for this operation, usually the object to access.
     * @return bool Permission granted?
     */
    public function checkAccess($operation, $params = array()) {
        /* if (empty($this->id)) {
          // Not identified => no rights
          return false;
          } */        
        $type = $this->getState("roles");
        //$roles[Dentist::ROLE_ADMIN] = 'dentist';
        return ($operation === $type);
    }

    public function role() {
        return $this->getState("type");
    }

    public function getRoles() {
        return $this->getState("roles");
    }

}