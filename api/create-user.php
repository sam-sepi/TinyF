<?php

include('../vendor/autoload.php');

$request = new TinyF\Libraries\Request;

if($request->getMethod()  == 'post')
{
    $signup = new TinyF\App\Signup;

    $input = json_decode(file_get_contents("php://input"));

    $msg = $signup->signin($input->username, $input->email, $input->password, $input->confpass);

    echo json_encode($msg);
}
else
{
    header("HTTP/1.1 405 Method Not Allowed");
    exit();
}