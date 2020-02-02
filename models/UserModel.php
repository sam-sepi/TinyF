<?php

namespace TinyF\Models;

use TinyF\Models\ModelWrapper;

/** 
 *  @class UserModel
 *  
 */
class UserModel extends ModelWrapper
{
    /**
     * create
     * @param  array  $data
     * @return int
     */
    public function create(array $data)
    {
        $create = $this->db->run("INSERT INTO users (email, username, password, datesign, isbanned, isadmin) VALUES (?, ?, ?, ?, ?, ?)", $data);

        return $create;
    }

    /**
     *  update
     * @param  array  $data
     * @return int
     */
    public function update(array $data)
    {
        $update = $this->db->run('UPDATE users SET email = ?, username = ?, password = ?, isbanned = ? WHERE id = ?', $data);

        return $update;
    }

    /**
     * delete
     * @param  int  User Id
     * @return int
     */
    public function delete($id)
    {
        $delete = $this->db->run('DELETE FROM users WHERE id = ?', [$id]);

        return $delete;
    }

    /**
     * @fn readByUsername
     * @param  string $username
     * @return array
     */
    public function readByUsername($username)
    {
        $read = $this->db->find('SELECT * FROM users WHERE username = ? AND isbanned = 0', [$username]);

        return $read;
    }

    /**
     * @fn readByEmail
     * @param  string $email
     * @return array
     */
    public function readByEmail($email)
    {
        $read = $this->db->find('SELECT * FROM users WHERE email = ?', [$email]);

        return $read;
    }

    /**
     * @fn readAll 
     * @return array
     */
    public function readAll()
    {
        $read = $this->db->run('SELECT * FROM users');

        return $read;
    }

}