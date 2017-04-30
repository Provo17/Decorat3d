<?php

class AdminWebUser extends CWebUser {

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
        $type = $this->getState("type");
        $roles[AdminUserMaster::ROLE_ADMIN] = 'admin';
        return ($operation === $roles[$type]);
    }

    public function role() {
        return $this->getState("type");
    }

}
