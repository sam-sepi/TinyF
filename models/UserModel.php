<?php

namespace TinyF\Models;

/**
 * Users CRUD
 */
class UserModel extends ModelWrapper
{
    public function readUserById($id)
    {
        $user = $this->db->find('SELECT email FROM users WHERE id = ?', [$id]);

        return $user;
    }
}