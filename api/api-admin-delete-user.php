<?php
//Handles the delete user from the database by the HTTP POST request from an admin
//the returned will be json
header('Content-Type: application/json');
require_once __DIR__.'/../_.php';

try{
    //defines the user id from the HTTP POST request
    $user_id = $_POST['user_id'];

    //uses the db function to connect to the database
    $db = _db();
    $sql = $db->prepare('DELETE FROM users WHERE user_id = :user_id');
    $sql->bindValue(':user_id', $user_id);
    $sql->execute();

    echo json_encode(['info'=>"user deleted with id: $user_id"]);

}catch(Exception $e){
        $status_code = !ctype_digit($e->getCode()) ? 500 : $e->getCode();
        $message = strlen($e->getMessage()) == 0 ? 'error - '.$e->getLine() : $e->getMessage();
        http_response_code($status_code);
        echo json_encode(['info'=>$message]);
}