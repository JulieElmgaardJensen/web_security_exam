<?php
header('Content-Type: application/json');
require_once __DIR__.'/../_.php';

try{

    _validate_user_email();
    
    //using $_POST because we get a post request from the user in the form with the HTTP POST 
    $user_email = $_POST['user_email'];

    $db = _db();
    $sql = $db->prepare('SELECT user_email FROM users WHERE user_email = :user_email');
    $sql->bindValue(':user_email', $user_email);
    $sql->execute();
    
    $email = $sql->fetchAll();

    //if the email isent in the system its ok - if it is the email is not availeble
    if( ! $email) {
        http_response_code(200);
        echo json_encode(['info'=>'email available']);
        exit();
    }else {
        http_response_code(400);
        echo json_encode(['info'=>'email not available']);
    }

    echo json_encode(['info' => "$user_email"]);

}catch(Exception $e){
        $status_code = !ctype_digit($e->getCode()) ? 500 : $e->getCode();
        $message = strlen($e->getMessage()) == 0 ? 'error - '.$e->getLine() : $e->getMessage();
        http_response_code($status_code);
        echo json_encode(['info'=>$message]);
}
