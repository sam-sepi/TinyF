<?php

namespace TinyF\Libraries;

/** 
 *  @class      Session
 */

use Spaghetti\App\Config;

class Session 
{
    ///Session params
    public $session_params = 
        [
            'cookie_httponly' => 1, 
            'cookie_lifetime'  => 0
        ];

    /**
     * @fn construct 
     * 
     */
    public function __construct() 
    {
        $config = new Config;

        if(session_status() == PHP_SESSION_NONE) 
        {
            session_start($this->session_params);
        }
    }
   
    /**
     * @fn __set
     *
     * Ex.: $session->username = $username;
     */
    public function __set(string $name, $value)
    {
        $_SESSION[$name] = $value;
    }
   
   
    /**
     * @fn __get 
     * 
     * Ex.: echo $session->username;
     */
    public function __get(string $name)
    {
        if(isset($_SESSION[$name]))
        {
            return $_SESSION[$name];
        }
    }
   
    /**
     * @fn destroy 
     * 
     * Ex.: $session->destroy();
     */
    public function destroy()
    {
        session_destroy();
    }

    /**
     * @fn regenerate
     * 
     * @Ex.: $session->regenerate();
     */
    public function regenerate()
    {
        session_regenerate_id();
    }
}
