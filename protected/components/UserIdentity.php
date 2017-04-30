<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
    {

    const ERROR_NOT_CONFIRMED = 404;
    const ERROR_ACCESS_ADMIN = 1;

    /**
     * Authenticates a user.
     * @return boolean whether authentication succeeds.
     */
    public function authenticate() {
//        if (strpos($this->username, '@') != false) {
        $user = UserMaster::model()->findByAttributes(['email' => $this->username, 'status' => '1']);
//        } else {
//            //Otherwise we search using the username
//            $user = UserMaster::model()->findByAttributes(['user_name' => $this->username]);
//        }

        if ($user === null)
            {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
            }
//        else if ($user->user_type_id == 1)
//            {            
//            $this->errorCode = self::ERROR_ACCESS_ADMIN;
//            }
        else if (($this->password) != $user->initialPassword)
            {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
            }
        else
            {
            $this->setState('id', $user->id);
            $this->setState('user_type_id', $user->user_type_id);
            $this->errorCode = self::ERROR_NONE;
            }
        return $this->errorCode == self::ERROR_NONE;
    }

    }
