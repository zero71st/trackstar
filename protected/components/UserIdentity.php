<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity {

    private $_id;

    /**
     * Authenticates a user.
     * The example implementation makes sure if the username and password
     * are both 'demo'.
     * In practical applications, this should be changed to authenticate
     * against some persistent user identity storage (e.g. database).
     * @return boolean whether authentication succeeds.
     */
    public function authenticate() {
//        $users = array(
//            // username => password
//            //'demo' => 'demo',
//            //'admin' => 'admin',
//        );
//        // if (!isset($users[$this->username]))
//            $this->errorCode = self::ERROR_USERNAME_INVALID;
//        elseif ($users[$this->username] !== $this->password)
//            $this->errorCode = self::ERROR_PASSWORD_INVALID;
//        else
//            $this->errorCode = self::ERROR_NONE;
//        return !$this->errorCode;
//        
        // ค้นหา username ที่ตรงกับ DB
        $user = User::model()->find('LOWER(username)=?', array(strtolower($this->username)));

        if ($user === null)
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        elseif (!$user->validatePassword($this->password)) // ตรงนี้ลืมใส่ not (!) ทำให้ Login ไม่ได้
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        else {
            $this->_id = $user->id;
            $this->username = $user->username;
            $this->setState('lastLogin', date("m/d/y g:i A", strtotime($user->last_login_time)));
            $user->saveAttributes(array(
                'last_login_time' => date("Y-m-d H:i:s", time()),
            ));
            $this->errorCode = self::ERROR_NONE;
        }
        return $this->errorCode == self::ERROR_NONE; //Return true/false
    }

    public function getId() {
        return $this->_id;
    }

}