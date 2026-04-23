<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity {

    /**
     * Authenticates a user.
     * The example implementation makes sure if the username and password
     * are both 'demo'.
     * In practical applications, this should be changed to authenticate
     * against some persistent user identity storage (e.g. database).
     * @return boolean whether authentication succeeds.
     */
    public $user_id;

    public function authenticate() {

        $model = NatcUsers::model()->find("username=:user_name and password=:user_password", array(':user_name'=>$this->username, ':user_password'=>md5($this->password)));
        if(!$model){
            throw new CHttpException('503: Forbidden or Login Failed!','Username or Password is invalid or you\'re not registered');
            exit;
        }
        if ($model->username !== $this->username)
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        else if ($model->password !== md5($this->password))
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        else
            $this->user_id = $model->user_id;
            $this->errorCode = self::ERROR_NONE;
        return !$this->errorCode;
    }
    public function getId(){
        return $this->user_id;
    }
}