<?php
header('Content-Type: application/json');
require_once __DIR__.'/../_.php';

try{
    //Get info about order
    $order_id = $_GET['order_id'];
    $order_is_private = $_GET['order_is_private'];

    $db = _db();
    $q = $db->prepare('
        UPDATE orders 
        SET order_is_private = !order_is_private 
        WHERE order_id = :order_id;
    ');
    $q->bindValue(':order_id', $order_id);
    $q->execute();

    echo json_encode(['info' => 'order updated']);

    
}catch(Exception $e){
        $status_code = !ctype_digit($e->getCode()) ? 500 : $e->getCode();
        $message = strlen($e->getMessage()) == 0 ? 'error - '.$e->getLine() : $e->getMessage();
        http_response_code($status_code);
        echo json_encode(['info'=>$message]);
    }
?>