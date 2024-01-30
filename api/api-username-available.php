<?php
header('Content-Type: application/json');
require_once __DIR__.'/../_.php';
try{
    _validate_user_username();
    
    $user_username = $_POST['user_username'];

    $db = _db();
    $sql = $db->prepare('SELECT user_username FROM users WHERE user_username = :user_username');
    $sql->bindValue(':user_username', $user_username);
    $sql->execute();
    
    $username = $sql->fetchAll();

    if( ! $username) {
        http_response_code(200);
        echo json_encode(['info'=>"username available"]);
        exit();
    }else {
        http_response_code(400);
        echo json_encode(['info'=>"username not available"]);
    }

    echo json_encode(['info' => "$user_username"]);

}catch(Exception $e){
        $status_code = !ctype_digit($e->getCode()) ? 500 : $e->getCode();
        $message = strlen($e->getMessage()) == 0 ? 'error - '.$e->getLine() : $e->getMessage();
        http_response_code($status_code);
        echo json_encode(['info'=>$message]);
}