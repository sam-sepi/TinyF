<?php

namespace TinyF\App;

use TinyF\Models\UserModel;
use TinyF\Libraries\Validation;

class Signup
{  
    public $message = array();
    protected $model;
    protected $validate;

    public function __construct()
    {
        $this->model = new UserModel;
        $this->validate = new Validation;
    }
    
    /**
     * getHash
     * @param  string $password
     * @return string
     */
    protected function getHash(string $password): string
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }
    

    /**
     * signup
     * @param  string $email
     * @param  string $password
     * @param  string $confirmPassword
     * @return array
     */
    public function signin($username, $email, $password, $confirmPassword): array 
    {

        if($this->validate->getEmail($email, 5, 30) == false) 
        {
            $this->message[] = "The email address must be valid and the domain must not be temporary";
        }

        if(!empty($this->isUnique(filter_var($email, FILTER_SANITIZE_EMAIL), 'email')))
        {
            $this->message[] = "Email address already used";
        } 

        if($this->validate->getPassword($password) == false)
        {
            $this->message[] = "The password must contain a number, at least a capital letter, at least a lowercase letter, at least a special character (Ex .: &, @) and must be between 8 and 16 characters";
        }

        if($this->validate->matches($password, $confirmPassword) == false)
        {
            $this->message[] = "The password and its confirmation are required fields and must coincide";
        }

        if($this->validate->getAlNum($username, 5, 30) == false)
        {
            $this->message[] = 'The Username field must contain only alphabetic or numeric characters. It must also be between 5 and 30 characters long';
        }

        if(!empty($this->isUnique($this->validate->getFilteredString($username), 'username')))
        {
            $this->message[] = "Username already used";
        }

        if(empty($this->message))
        {
            $record = $this->model->create(array($email, $username, password_hash($password, PASSWORD_BCRYPT), date("Y-m-d H:i:s"), 1, 0));

            if($record > 0) {
                
                $this->message[] = 'Record done!';
            }
            else
            {
                $this->message[] = 'DB Server error';
            }
        }
        
        return $this->message;
    }   
    
    /**
     * isUnique
     * @param  $str
     * @param  string  $field
     */
    protected function isUnique($str, string $field)
    {
        switch ($field) 
        {
            case 'email':
                $data = $this->model->readByEmail($str);
                break;

            case 'username': 
                $data = $this->model->readByUsername($str);
                break;   
        }

        if(!empty($data)) return $data;

        return null;
    }

}