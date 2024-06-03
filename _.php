<?php
ini_set('display_errors', 1);

// ##############################
function _db(){
	try{
    $user_name = "root";
    $user_password = 'root';
	  $db_connection = "mysql:host=localhost; dbname=company; charset=utf8mb4";
		// $db_connection = 'sqlite:'.__DIR__.'/database/data.sqlite';
	  $db_options = array(
		PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
	  );
	  return new PDO( $db_connection, $user_name, $user_password, $db_options );
	}catch( PDOException $e){
	  throw new Exception('ups... system under maintainance', 500);
	  exit();
	}	
}

// ##############################

define('USER_NAME_MIN', 2);
define('USER_NAME_MAX', 20);
function _validate_user_name(){

  //makes the error message - Concatenation 
  $error = 'user_name min '.USER_NAME_MIN.' max '.USER_NAME_MAX;

  //checks if the user_name is set in the POST - else exception
  if(!isset($_POST['user_name'])){
    throw new Exception($error, 400);
  }
  // remove spaces 
  $_POST['user_name'] = trim($_POST['user_name']);

  //check the lenght of the input - else exception
  if( strlen($_POST['user_name']) < USER_NAME_MIN ){
    throw new Exception($error, 400);
  }

  if( strlen($_POST['user_name']) > USER_NAME_MAX ){
    throw new Exception($error, 400);
  }
}

// ##############################
define('USER_LAST_NAME_MIN', 2);
define('USER_LAST_NAME_MAX', 20);
function _validate_user_last_name(){

  $error = 'user_last_name min '.USER_LAST_NAME_MIN.' max '.USER_LAST_NAME_MAX;

  if(!isset($_POST['user_last_name'])){ 
    throw new Exception($error, 400); 
  }
  $_POST['user_last_name'] = trim($_POST['user_last_name']);

  if( strlen($_POST['user_last_name']) < USER_LAST_NAME_MIN ){
    throw new Exception($error, 400);
  }

  if( strlen($_POST['user_last_name']) > USER_LAST_NAME_MAX ){
    throw new Exception($error, 400);
  }
}

// ##############################
define('USER_USERNAME_MIN', 2);
define('USER_USERNAME_MAX', 30);
function _validate_user_username(){

  $error = 'user_username min '.USER_USERNAME_MIN.' max '.USER_USERNAME_MAX;

  if(!isset($_POST['user_username'])){ 
    throw new Exception($error, 400); 
  }
  $_POST['user_username'] = trim($_POST['user_username']);

  if( strlen($_POST['user_username']) < USER_USERNAME_MIN ){
    throw new Exception($error, 400);
  }

  if( strlen($_POST['user_username']) > USER_USERNAME_MAX ){
    throw new Exception($error, 400);
  }
}

// ##############################
define('USER_ADDRESS_MIN', 2);
define('USER_ADDRESS_MAX', 75);
function _validate_user_address(){
  
  $error = 'user_address min '.USER_ADDRESS_MIN.' max '.USER_ADDRESS_MAX;

  if(!isset($_POST['user_address'])){ 
    throw new Exception($error, 400); 
  }
  $_POST['user_address'] = trim($_POST['user_address']);

  if( strlen($_POST['user_address']) < USER_ADDRESS_MIN ){
    throw new Exception($error, 400);
  }

  if( strlen($_POST['user_address']) > USER_ADDRESS_MAX ){
    throw new Exception($error, 400);
  }
}

// ##############################
//validates the user_email from the post request and trim the input
function _validate_user_email(){
  $error = 'user_email invalid';
  if(!isset($_POST['user_email'])){ 
    throw new Exception($error, 400); 
  }
  $_POST['user_email'] = trim($_POST['user_email']); 
  //validates the email
  if( ! filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL) ){
    throw new Exception($error, 400); 
  }
}

// ##############################
define('USER_PASSWORD_MIN', 6);
define('USER_PASSWORD_MAX', 50);
function _validate_user_password(){

  $error = 'user_password min '.USER_PASSWORD_MIN.' max '.USER_PASSWORD_MAX;

  if(!isset($_POST['user_password'])){ 
    throw new Exception($error, 400); 
  }
  $_POST['user_password'] = trim($_POST['user_password']);

  if( strlen($_POST['user_password']) < USER_PASSWORD_MIN ){
    throw new Exception($error, 400);
  }

  if( strlen($_POST['user_password']) > USER_PASSWORD_MAX ){
    throw new Exception($error, 400);
  }
}

// ##############################
function _validate_user_confirm_password(){
  $error = 'user_confirm_password must match the user_password';
  if(!isset($_POST['user_confirm_password'])){ 
    throw new Exception($error, 400); 
  }
  $_POST['user_confirm_password'] = trim($_POST['user_confirm_password']);
  if( $_POST['user_password'] != $_POST['user_confirm_password']){
    throw new Exception($error, 400); 
  }
}

// ##############################
function _is_partner(){
  if($_SESSION['user']['user_role'] !== 'partner'){
    header('Location: /404');
    exit();
  };
}

// ##############################
function _is_admin(){
  if($_SESSION['user']['user_role'] !== 'admin'){
    header('Location: /404');
    exit();
  };
}

// ##############################
function _is_blocked() {
    if($_SESSION['user']['user_is_blocked'] === '1'){
      session_destroy();
      header('Location: /blocked');
      exit();
    }
}

// ##############################
function _is_deleted() {
    if($_SESSION['user']['user_deleted_at'] !== '0') {
      session_destroy();
      header('Location: /deleted');
      exit();
    }
}


// ##############################
function _is_logged_in() {
  if (!isset($_SESSION['user'])) {
      header('Location: /logout');
      exit();
  }
}

// ##############################
function _check_user_id($user_id) {
  if (!isset($_SESSION['user']['user_id'])) {
      header('Location: /logout');
      exit();
  }

  if ($_SESSION['user']['user_id'] != $user_id) {
      header('Location: /404');
      exit();
  }
}

// ##############################
function _if_logged_in_redirect(){
  if(isset($_SESSION['user'])){
    $user_id = $_SESSION['user']['user_id'];
    header("Location: /profile?user_id=$user_id");
    exit();
  };
}


function _validate_user_image(){
  // Check for errors in uploaded file
  if ($_FILES['user_image']['error'] !== UPLOAD_ERR_OK) {
    throw new Exception('Error uploading image', 400);
  }
}