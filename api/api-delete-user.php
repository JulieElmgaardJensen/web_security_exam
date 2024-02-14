<?php
header('Content-Type: application/json');
require_once __DIR__.'/../_.php';

try{
  //because we need the session to delete the user - we start it
  session_start();

  //for deleting a user, we need to check if the user is logged in
  _is_logged_in();

  //defines our variable with the user_id that are saved from the session
  $user_id = $_SESSION['user']['user_id'];
  
  //we use the placeholders to secure, efficient, and maintain the database queries
  $db = _db();
  $q = $db->prepare('
    UPDATE users
    SET user_deleted_at = :time
    WHERE user_id = :user_id
  ');
  //binds the values to the database
  $q->bindValue(':time', time());
  $q->bindValue(':user_id', $user_id);
  $q->execute();
  $counter = $q->rowCount();

  //If we dident effect one row we have an error
  if( $counter != 1 ){
    throw new Exception('could not delete user', 500);
  }
  // user deleted
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