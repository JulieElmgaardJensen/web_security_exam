<?php
header('Content-Type: application/json');
require_once __DIR__.'/../_.php';

try{

  $db = _db();
  $q = $db->prepare('SELECT * FROM users LIMIT :page, 2');
  $q->bindValue(':page', $_GET['page'], PDO::PARAM_INT );
  $q->execute();
  $users = $q->fetchAll();
  echo json_encode($users);

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
