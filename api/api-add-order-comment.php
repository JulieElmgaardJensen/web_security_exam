<!-- Create a comment for the order -->
<?php
header('Content-Type: application/json');
require_once __DIR__.'/../_.php';

try{
  session_start();

  // Check if the session token and POST token are set
  if (!isset($_SESSION['token']) || !isset($_POST['token'])) {
    throw new Exception('Token is not set.', 400);
  }

  // Validate the token
  if ($_POST['token'] !== $_SESSION['token']) {
    throw new Exception('Invalid token.', 400);
  }

  _validate_comment();

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