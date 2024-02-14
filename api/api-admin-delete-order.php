<?php
//Handles the delete order from the database by the HTTP POST request from an admin
//the returned will be json
header('Content-Type: application/json');
require_once __DIR__.'/../_.php';

//use try catch for error handeling
try{
    //defines the order id from the HTTP POST request 
    $order_id = $_POST['order_id'];

    //connect to the database an make the querie for deleting the order - bind it to the order id from the post request, and execute the querie.
    $db = _db();
    $sql = $db->prepare('DELETE FROM orders WHERE order_id = :order_id');
    $sql->bindValue(':order_id', $order_id);
    $sql->execute();

    //if everything is ok, we returns this json string
    echo json_encode(['info'=>"order deleted with id: $order_id"]);

// Catch the errors that might come up and give us an error message
}catch(Exception $e){
        $status_code = !ctype_digit($e->getCode()) ? 500 : $e->getCode();
        $message = strlen($e->getMessage()) == 0 ? 'error - '.$e->getLine() : $e->getMessage();
        http_response_code($status_code);
        echo json_encode(['info'=>$message]);
}