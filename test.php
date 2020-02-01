<?php

include('vendor\autoload.php');

$user = new TinyF\Models\UserModel();

$u = $user->readUserById(1);

print_r($u);

$string = '<script>alert("Hello!")</script>';

$validation = new TinyF\Libraries\Validation;

echo $validation->getFilteredString($string);

$cookie = new TinyF\Libraries\Cookie;
$cookie->mycookie = 'cookievalue';
//reload
echo $cookie->mycookie; //out.: 'cookievalue'

$session = new TinyF\Libraries\Session;
$session->name = 'sessioname';
echo $_SESSION['name']; //out.: sessioname

$req = new TinyF\Libraries\Request;
echo $req->getMethod(); //out.: get