<?php

namespace TinyF\Models;

use TinyF\Models\ModelWrapper;

class LoginModel extends ModelWrapper
{
    /**
     * @fn countAttempts
     * @param  string $ip
     * @return int
     */
    public function countAttempts(string $ip): int
    {
        $error = $this->db->find("SELECT count(*) AS error FROM InvalidLogin WHERE ip = ? AND DATE_ADD(timerror, INTERVAL 10 MINUTE) > NOW()", [$ip]);

        if(is_int($error['error']))
        {
            return $error['error'];
        }
        else
        {
            return 0;
        }
    }

    /**
     * insertError
     * @param  string $message
     * @param  string $ip
     * @return int
     */
    public function insertError(string $message, string $ip)
    {
        $error = $this->db->run("INSERT INTO invalidlogin (message, ip, timerror) VALUES (?, ?, ?)", [$message, $ip, date("Y-m-d H:i:s")]);

        return $error;
    }
}