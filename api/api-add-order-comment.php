<!-- Create a comment for the order -->
<?php
header('Content-Type: application/json');
require_once __DIR__.'/../_.php';

try{
  $db = _db();
  
  $q = $db->prepare('
      UPDATE orders 
      SET order_comment = :order_comment 
      WHERE order_id = :order_id;
  ');

  $q->bindValue(':order_id', $_POST['order_id']);
  $q->bindValue(':order_comment', $_POST['order_comment']);
  $q->execute();

  echo json_encode(['info' => 'order updated']);

}catch(Exception $e){
  try{
    if( ! $e->getCode() || ! $e->getMessage()){ throw new Exception(); }
    http_response_code($e->getCode());
    echo json_encode(['info'=>$e->getMessage()]);
  }catch(Exception $ex){
    http_response_code(500);
    echo json_encode($ex); 
  }
}