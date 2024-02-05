<?php
require_once __DIR__.'/../_.php';

try{
  session_start();

  //_is_logged_in();
  
  // _validate_user_name();
  // _validate_user_last_name();
  // _validate_user_email();
  // _validate_user_password();
  // _validate_user_confirm_password();

  $user_id = $_SESSION['user']['user_id'];

  $db = _db();
  $q = $db->prepare('
    UPDATE users
    SET user_name = :user_name,
    user_last_name = :user_last_name,
    user_username = :user_username,
    user_address = :user_address,
    user_email = :user_email,
    user_password = :user_password,
    user_updated_at = :time
    WHERE user_id = :user_id
  ');

  $q->bindValue(':user_name', $_POST['user_name']);
  $q->bindValue(':user_last_name', $_POST['user_last_name']);
  $q->bindValue(':user_username', $_POST['user_username']);
  $q->bindValue(':user_address', $_POST['user_address']);
  $q->bindValue(':user_email', $_POST['user_email']);
  $q->bindValue(':user_password', password_hash($_POST['user_password'], PASSWORD_DEFAULT));
  $q->bindValue(':time', time());
  $q->bindValue(':user_id', $user_id);
  $q->execute();
  $counter = $q->rowCount();

  if( $counter != 1 ){
    throw new Exception('could not update user', 500);
  }
  http_response_code(204);

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