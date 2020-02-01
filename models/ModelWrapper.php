<?php

/**
 *  Class PdoWrapper
 *  Class inherited from models
 */
namespace TinyF\Models;

use TinyF\Database\DbWrapper;

class ModelWrapper
{
    ///Db property for all models
    protected $db;

    public function __construct(string $dsn = null, string $user = null, string $password = null, array $options = null)
    {
        $this->db = DbWrapper::getInstance($dsn, $user, $password, $options);
    }
}