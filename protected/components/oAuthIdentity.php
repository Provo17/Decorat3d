<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class oAuthIdentity extends CBaseUserIdentity {

    public $error_msg;
    public $error_field;
    
    private $_id;
    public $usertype;
    public $username;

    const ERROR_USERNAME_NOT_ACTIVE = 'Active account from email';
    const ERROR_TYPE_USER = 'This is student area';
    const ERROR_USER_NOT_ACTIVE = 'Your account is not activated';

    /**
     * Authenticates a user.
     * The example implementation makes sure if the username and password
     * are both 'demo'.
     * In practical applications, this should be changed to authenticate
     * against some persistent user identity storage (e.g. database).
     * @return boolean whether authentication succeeds.
     * 
     * 
     */
    
    public function __construct($username)
    {
        $this->username = $username;

    }
    
    
    public function authenticate() {
        $user_data = UserMaster::model()->findByAttributes(array("email" => $this->username));
        
        $this->_id = $user_data->id;
            
            $this->setState('id', $user_data->id);
            $this->setState('user_type_id', $user_data->user_type_id);
            $this->errorCode = self::ERROR_NONE;
            
            return !$this->errorCode;
    }
    
    public function authenticate_username() {
        $user_data = UserMaster::model()->findByAttributes(array("username" => $this->username));
        
        $this->_id = $user_data->id;
            
            $this->setState('id', $user_data->id);
            $this->setState('user_type_id', $user_data->user_type_id);
            $this->errorCode = self::ERROR_NONE;
            
            return !$this->errorCode;
    }


    public function getId() {
        return $this->_id;
    }
 
    

}

