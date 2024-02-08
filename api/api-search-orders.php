<?php 
header('Content-Type: application/json');
require_once __DIR__.'/../_.php';

try{

    $db = _db();
    $q = $db->prepare(' SELECT *
                        FROM orders AS o
                        JOIN users AS u ON o.order_user_fk = u.user_id
                        JOIN products AS p ON o.order_product_fk = p.product_id
                        WHERE o.order_id LIKE :order_id
                            OR u.user_name LIKE :user_name
                            OR u.user_last_name LIKE :user_last_name
                            OR p.product_name LIKE :product_name
                        ');
    $q->bindValue(':order_id', "%{$_POST['query']}%");
    $q->bindValue(':user_name', "%{$_POST['query']}%");
    $q->bindValue(':user_last_name', "%{$_POST['query']}%");
    $q->bindValue(':product_name', "%{$_POST['query']}%");
    $q->execute();
    $orders = $q->fetchAll();
    echo json_encode($orders);

}catch(Exception $e){
        $status_code = !ctype_digit($e->getCode()) ? 500 : $e->getCode();
        $message = strlen($e->getMessage()) == 0 ? 'error - '.$e->getLine() : $e->getMessage();
        http_response_code($status_code);
        echo json_encode(['info'=>$message]);
}


?>
