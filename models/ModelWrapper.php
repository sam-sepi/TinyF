<?php

/**
 *  Class PdoWrapper
 *  Class inherited from models
 */
namespace TinyF\Models;

use TinyF\Database\PdoWrapper;

class ModelWrapper
{
    ///Db property for all models
    protected $db;

    public function __construct(PdoWrapper $pdo)
    {
        $this->db = $pdo;
    }
}