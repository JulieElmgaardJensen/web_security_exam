<?php
ini_set('display_errors', 1);
require_once __DIR__.'/../_.php';

try{

  _validate_user_name();
  _validate_user_last_name();
  _validate_user_email();
  _validate_user_password();
  _validate_user_confirm_password();

  //ensures that the site is only being accessed through a POST
  if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    exit('Method not allowed');
}

  session_start();
  if( ! isset($_SESSION['user']['user_id']) ){
    throw new Exception('user not logged in', 400);
  }

  $user_id = $_SESSION['user']['user_id'];

    $db = _db();

    $q = $db->prepare(
        'UPDATE users 
        SET user_name = :user_name, 
        user_last_name = :user_last_name, 
        user_username = :user_username, 
        user_address = :user_address, 
        user_email = :user_email, 
        user_password = :user_password, 
        user_updated_at = :user_updated_at 
        WHERE user_id = :user_id'
        );

    // binder værdien fra user_id til _user_id i databasen
    $q->bindValue(':user_id', $user_id);
    $q->bindValue(':user_name', $_POST['user_name']);
    $q->bindValue(':user_last_name', $_POST['user_last_name']);
    $q->bindValue(':user_username', $_POST['user_username']);
    $q->bindValue(':user_address', $_POST['user_address']);
    $q->bindValue(':user_email', $_POST['user_email']);
    $q->bindValue(':user_password', password_hash($_POST['user_password'], PASSWORD_DEFAULT));
    $q->bindValue(':user_updated_at', time());

    $q->execute();
    $counter = $q->rowCount();
    if( $counter != 1 ){
      throw new Exception('could not update user', 500);
    }
    http_response_code(200);


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


// try{

  // session_start();

  // if(isset($_POST['update'])){
  //   $updated_user_name = $_POST['user_name'];
  //   $updated_user_last_name = $_POST['user_last_name'];
  //   $updated_user_username = $_POST['user_username'];
  //   $updated_user_address = $_POST['user_address'];
  //   $updated_user_email = $_POST['user_email'];
  //   $updated_user_password = $_POST['user_password'];

  //   if(!empty($updated_user_name) && !empty($updated_user_email)){
  //     if()

  //   }else{
  //     header('Location:/profile?error=emptyNameAndEmail');
  //     exit;
  //   }

  //   echo "Profile updated!";
  //   echo "$updated_user_name";
  //   print_r($updated_user_name);
  // }

  // _validate_user_name();
  // _validate_user_last_name();
  // _validate_user_email();
  // _validate_user_password();
  // _validate_user_confirm_password();

  // $db = _db();
  // $q = $db->prepare(' UPDATE users 
  //                     SET user_name = :user_name,
  //                     user_last_name = :user_last_name,
  //                     user_username = :user_username,
  //                     user_address = :user_address,
  //                     user_email = :user_email,
  //                     user_password = :user_password,
  //                     user_updated_at = :user_updated_at
  //                     WHERE user_id = :user_id
  //                     ');


  // $user_name = $_POST['user_name'];
  // $user_last_name = $_POST['user_last_name'];
  // $user_username = $_POST['user_username'];
  // $user_address = $_POST['user_address'];
  // $user_email = $_POST['user_email'];
  // $user_password = password_hash($_POST['user_password'], PASSWORD_DEFAULT);
  // $user_updated_at = time();

  // $q->bindParam(':user_name', $user_name);
  // $q->bindParam(':user_last_name', $user_last_name);
  // $q->bindParam(':user_username', $user_username);
  // $q->bindParam(':user_address', $user_address);
  // $q->bindParam(':user_email', $user_email);
  // $q->bindParam(':user_password', $user_password);
  // $q->bindParam(':user_updated_at', $user_updated_at);

  // $q->execute();
//   echo "Profile updated2!";

// }catch(Exception $e){
//   try{
//     if( ! $e->getCode() || ! $e->getMessage()){ throw new Exception(); }
//     http_response_code($e->getCode());
//     echo json_encode(['info'=>$e->getMessage()]);
//   }catch(Exception $ex){
//     http_response_code(500);
//     echo json_encode($ex); 
//   }
// }

