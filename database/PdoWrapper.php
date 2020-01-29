<?php

/**
 * PDOWrapper Class for Dependency Injection
 */
namespace TinyF\Database;

use \PDO;

class PdoWrapper extends \PDO implements DbInterface
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
    public static function connect(string $dsn = null, string $user = null, string $password = null, array $options = null)
    {
        $dsn = (isset($dsn)) ? $dsn : "mysql:dbname=tinyf;host=localhost";
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
            //Logger in dev mode
            if($this->dev)
            {
                print($e->getMessage());
            }
        }
    }
    
    /**
     * @fn find 
     * Fetch single row
     * Ex.: $conn->find("SELECT title FROM qutes WHERE id = ?", [43]);
     *
     * @param  string $sql
     * @param  array|null  $where
     * 
     * An array of values with as many elements as there are bound 
     * parameters in the SQL statement being executed. 
     * All values are treated as PDO::PARAM_STR.
     * 
     * @return The return value of this function on success depends on the fetch type.
     */
    public function find(string $sql, array $where = null)
    {
        if($this->pdo instanceof \PDO)
        {
            try {
                
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute($where);
                
                return $stmt->fetch();
            }
            catch (\PDOException $e)
            {
                //Logger in dev. mode
                if($this->dev)
                {
                    print($e->getMessage());
                }
            }        
        }    
    }

    /**
     * @fn run 
     * Run Query
     * 
     * Ex.: $conn->run("SELECT title FROM qutes WHERE id = ?", [43]);
     *  
     * @param  string     $sql
     * @param  array|null $params
     * 
     * @return mixed. Depends on query type
     */
    public function run(string $sql, array $params = null) 
    {
        if($this->pdo instanceof \PDO)
        {
        
            try {
                
                $stmt = $this->pdo->prepare($sql);
                
                $stmt->execute($params);
                
                $query = explode(" ", strtolower($sql));
            
                if ($query[0] === 'select' || $query[0] === 'show') 
                {
                    return $stmt->fetchAll();
                } 
                elseif ($query[0] === 'insert' || $query[0] === 'update' || $query[0] === 'delete') 
                {
                    return $stmt->rowCount();
                } 
                else {

                    return NULL;
                }
            }
            catch (\PDOException $e)
            {
                //Logger in dev. mode
                if($this->dev)
                {
                    print($e->getMessage());
                }
            }
        }    
    }
}

