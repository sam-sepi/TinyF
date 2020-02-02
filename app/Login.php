<?php

namespace TinyF\App;

use TinyF\Models\UserModel;
use TinyF\Libraries\Request;
use TinyF\Models\LoginModel;
use TinyF\Libraries\Session;
use TinyF\Libraries\Validation;

class Login
{

    protected $model;
    protected $request;
    protected $login_model;
    protected $validation;

    /**
     * __construct
     */
    public function __construct()
    {
        $this->model = new UserModel;
        $this->request = new Request;
        $this->login_model = new LoginModel;
        $this->validation = new Validation;
    }


    /**
     * authenticate
     * @param  string|null $username
     * @param  string|null $credential
     * @return bool
     */
    public function authenticate(string $username = null, string $credential = null): bool
    {
        if($this->login_model->countAttempts($this->request->getIpAddress()) > 10)
        {
            return false;
            exit();
        }

        $username = $this->validation->getFilteredString($username);
        
        $user = $this->model->readByUsername($username);

        if(!empty($user))
        {
            if(password_verify($credential, $user['password']))
            {
                $session = new Session;

                $session->id = $user['id'];
                $session->username = $user['username'];
                $session->fingerprint = hash_hmac('sha256', $this->request->getUserAgent(), hash('sha256', $this->request->getIPAddress(), true));
                $session->last_active = time();
                $session->isadmin = $user['isadmin'];

                return true;

            }
            else
            {
                $error = "Password Error";

                $this->login_model->insertError($error, $this->request->getIPAddress());

                return false;
            }
        }
        else
        {
            $error = "Username error";

            $this->login_model->insertError($error, $this->request->getIPAddress());

            return false;

        }
    
    }
}