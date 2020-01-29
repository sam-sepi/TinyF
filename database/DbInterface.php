<?php

namespace TinyF\Database;

interface DbInterface
{
    public function find(string $sql, array $where = null);

    public function run(string $sql, array $params = null);
}