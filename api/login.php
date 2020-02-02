<?php

include('../vendor/autoload.php');

$request = new TinyF\Libraries\Request;

if($request->getMethod()  == 'post')
{
    $signup = new TinyF\App\Login;
    
    $input = json_decode(file_get_contents("php://input"));

    if(!$signup->authenticate($input->username, $input->password))
    {
        $msg['error'] = 1;
        $msg['message'] = 'Autenticazione non riuscita';
        echo json_encode($msg);
    }
    else
    {

        $msg['error'] = 0;
        $msg['url'] = 'OK!';
        echo json_encode($msg);
    }    
}
else
{
    header("HTTP/1.1 405 Method Not Allowed");
    exit();
}