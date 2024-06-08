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
  // remove spaces and sanitize 
  $_POST['user_name'] = htmlspecialchars(trim($_POST['user_name']), ENT_QUOTES, 'UTF-8');

  //check the length of the input - else exception
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

  $_POST['user_last_name'] = htmlspecialchars(trim($_POST['user_last_name']), ENT_QUOTES, 'UTF-8');

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

  $_POST['user_username'] = htmlspecialchars(trim($_POST['user_username']), ENT_QUOTES, 'UTF-8');

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

  $_POST['user_address'] = htmlspecialchars(trim($_POST['user_address']), ENT_QUOTES, 'UTF-8');

  if( strlen($_POST['user_address']) < USER_ADDRESS_MIN ){
    throw new Exception($error, 400);
  }

  if( strlen($_POST['user_address']) > USER_ADDRESS_MAX ){
    throw new Exception($error, 400);
  }
}

// ##############################
function _validate_user_email(){
  $error = 'user_email invalid';
  if(!isset($_POST['user_email'])){
    throw new Exception($error, 400);
  }

  $_POST['user_email'] = filter_var(trim($_POST['user_email']), FILTER_SANITIZE_EMAIL);
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

  $_POST['user_password'] = htmlspecialchars(trim($_POST['user_password']), ENT_QUOTES, 'UTF-8');

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

  $_POST['user_confirm_password'] = htmlspecialchars(trim($_POST['user_confirm_password']), ENT_QUOTES, 'UTF-8');
  
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


// ###############################
function _validate_user_image(){

$image_path = $_FILES['user_image']['tmp_name'];
$image_size = filesize($image_path);
$image_info = finfo_open(FILEINFO_MIME_TYPE);
$image_type = finfo_file($image_info, $image_path);
$image_error = 'Error adding image';
$default_image_path = '/uploads/default_image.png';

if (!isset($_FILES['user_image']) || $_FILES['user_image']['error'] !== UPLOAD_ERR_OK) {
  // Use default image path if no image is uploaded
  $_FILES['user_image']['tmp_name'] = $default_image_path;
  return;
}

  if ($image_size === 0) {
    throw new Exception($image_error, 400);
  }
  //3 MB
  if ($image_size > 3145728) {
    throw new Exception($image_error, 400);
  }

  $allowed_types = [
    'image/png' => 'png',
    'image/jpeg' => 'jpg'
  ];

  if(!in_array($image_type, array_keys($allowed_types))) {
    throw new Exception($image_error, 400);
  }

  // Check for errors in uploaded file
  if ($_FILES['user_image']['error'] !== UPLOAD_ERR_OK) {
    throw new Exception($image_error, 400);
  }
}


// ##############################
function _check_signup_attempts(){

    if (!isset($_SESSION['signup_attempts'])) {
      $_SESSION['signup_attempts'] = 0;
      $_SESSION['last_signup_time'] = time();
  }

  $_SESSION['signup_attempts']++;
  
  if ($_SESSION['signup_attempts'] > 3 && time() - $_SESSION['last_signup_time'] < 3600) {
    throw new Exception('Too many signup attempts. Please try again later.', 429);

  }
}
    
// #################
define('COMMENT_MIN', 2);
define('COMMENT_MAX', 60);
function _validate_comment(){

  // Error message
  $error = 'Comment min length '.COMMENT_MIN.' max length '.COMMENT_MAX;

  // remove spaces
  $_POST['order_comment'] = htmlspecialchars(trim($_POST['order_comment']), ENT_QUOTES, 'UTF-8');

  //check the lenght of the input - else exception
  if( strlen($_POST['order_comment']) < COMMENT_MIN ){
    throw new Exception($error, 400);
  }

  if( strlen($_POST['order_comment']) > COMMENT_MAX ){
    throw new Exception($error, 400);
  }
}