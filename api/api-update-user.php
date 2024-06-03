<?php
header('Content-Type: application/json');
require_once __DIR__.'/../_.php';

try{
  session_start();
  
  //validate the inputs we can update
  _validate_user_name();
  _validate_user_last_name();
  _validate_user_address();
  //uses the session user_id - because we update the logged in user
  $user_id = $_SESSION['user']['user_id'];

  $upload_dir = '/uploads/';

// Check if an image is uploaded and update $user_image_path if necessary
if ($_FILES['user_image']['error'] === UPLOAD_ERR_OK) {
    // Get the basename of the uploaded file
    $filename = basename($_FILES['user_image']['name']);
    // Construct the full path where the file will be moved
    $full_path = __DIR__ . $upload_dir . $filename;

    // Move the uploaded file to the desired directory
    if (!move_uploaded_file($_FILES['user_image']['tmp_name'], $full_path)) {
        throw new Exception('Failed to move uploaded file', 500);
    }

    // Construct the relative path to be stored in the database
    $user_image_path = $upload_dir . $filename;
}

  $db = _db();
  $q = $db->prepare('
    UPDATE users
    SET user_name = :user_name,
    user_last_name = :user_last_name,
    user_address = :user_address,
    user_image = :user_image,
    user_updated_at = :time
    WHERE user_id = :user_id
  ');

  $q->bindValue(':user_name', $_POST['user_name']);
  $q->bindValue(':user_last_name', $_POST['user_last_name']);
  $q->bindValue(':user_address', $_POST['user_address']);
  $q->bindValue(':user_address', $_POST['user_address']);
  $q->bindParam(':user_image', $user_image_path);
  $q->bindValue(':time', time());
  $q->bindValue(':user_id', $user_id);

  $q->execute();
  $counter = $q->rowCount();

  //if there is no rows that are affected the user is not updated
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