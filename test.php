<?php

include('vendor\autoload.php');

$pdo = new TinyF\Database\PdoWrapper;
$user = new TinyF\Models\UserModel($pdo);

$u = $user->readUserById(1);

print_r($u);