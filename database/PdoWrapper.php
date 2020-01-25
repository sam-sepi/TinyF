<?php

/**
 * PDOWrapper Class for Dependency Injections.
 */
namespace TinyF\Database;

use \PDO;

class PdoWrapper
{
    protected $pdo;
    protected $dev = false;

    /**
     * @fn construct
     * 
     * @param  string|null $dsn
     * @param  string|null $user
     * @param  string|null $password
     * @param  array|null  $options
     */
    public function __construct(string $dsn = null, string $user = null, string $password = null, array $options = null)
    {
        $dsn = (isset($dsn)) ? $dsn : "mysql:dbname=dbname;host=localhost";
        $user = (isset($user)) ? $user : 'username';
        $password = (isset($password)) ? $password: 'password';
        
        //Default Opt.
        $default_options = [
            
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
        ];

        $options = (!empty($options)) ? $options : $default_options;
        
        
        try {

            $this->pdo = new \PDO($dsn, $user, $password, $options);
        }
        catch (\PDOException $e)
        {
            //Logger in dev or prod. mode
            if($this->dev)
            {
                print($e->getMessage());
            }
            else
            {
                $f = fopen('db_logger.txt', "a", dirname(__FILE__));
                fwrite($f, $e->getMessage() . "\r\n");
                fclose($f);
            }
        }
    }
}

