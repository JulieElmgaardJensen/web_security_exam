<?php
header('Content-Type: application/json');
require_once __DIR__.'/../_.php';

try{
    
    $order_id = $_POST['order_id'];

    $db = _db();
    $sql = $db->prepare('DELETE FROM orders WHERE order_id = :order_id');
    $sql->bindValue(':order_id', $order_id);
    $sql->execute();

    echo json_encode(['info'=>"order deleted with id: $order_id"]);

}catch(Exception $e){
        $status_code = !ctype_digit($e->getCode()) ? 500 : $e->getCode();
        $message = strlen($e->getMessage()) == 0 ? 'error - '.$e->getLine() : $e->getMessage();
        http_response_code($status_code);
        echo json_encode(['info'=>$message]);
}