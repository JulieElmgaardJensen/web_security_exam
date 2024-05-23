<?php 
header('Content-Type: application/json');
require_once __DIR__.'/../_.php';

try{
    session_start();

    $db = _db();
    $q = $db->prepare(' SELECT *
                        FROM orders AS o
                        JOIN users AS u ON o.order_delivered_by_fk = u.user_id
                        JOIN products AS p ON o.order_product_fk = p.product_id
                        WHERE (o.order_id LIKE :order_id
                            OR u.user_name LIKE :user_name
                            OR u.user_last_name LIKE :user_last_name
                            OR p.product_name LIKE :product_name)
                            AND u.user_id = :user_id
                        ');
    //binds the value from the post array in the search form
    // I use a mix of post and get (post-postback) because i want to show the result on the same time as the user write in the form
    $q->bindValue(':order_id', "%{$_POST['query']}%");
    $q->bindValue(':user_name', "%{$_POST['query']}%");
    $q->bindValue(':user_last_name', "%{$_POST['query']}%");
    $q->bindValue(':product_name', "%{$_POST['query']}%");
    $q->bindValue(':user_id', $_SESSION['user']['user_id']);
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
