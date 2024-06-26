<?php
header('Content-Type: application/json');
require_once __DIR__.'/../_.php';


try {

    _check_signup_attempts();
    _validate_user_name();
    _validate_user_last_name();
    _validate_user_username();
    _validate_user_email();
    _validate_user_password();
    _validate_user_confirm_password();
    _validate_user_image();

    $default_image_path = '/uploads/default_image.png';

    $user_image_path = __DIR__ . $default_image_path;
    $upload_dir = '/uploads/';

    // Check if an image is uploaded and update $user_image_path if necessary
    if ($_FILES['user_image']['error'] === UPLOAD_ERR_OK) {
        $filename = basename($_FILES['user_image']['name']);
        $full_path = __DIR__ . $upload_dir . $filename;

        if (!move_uploaded_file($_FILES['user_image']['tmp_name'], $full_path)) {
            throw new Exception('Failed to move uploaded file', 500);
        }

        $user_image_path = $upload_dir . $filename;
    } else {
        // If no image is uploaded, use the default image path
        $user_image_path = $default_image_path;
    }


    $db = _db();
    $q = $db->prepare('INSERT INTO  users 
                                    (user_id, 
                                    user_name, 
                                    user_last_name, 
                                    user_username, 
                                    user_address, 
                                    user_email, 
                                    user_password, 
                                    user_role, 
                                    user_image, 
                                    user_created_at, 
                                    user_updated_at, 
                                    user_deleted_at, 
                                    user_is_blocked)
        VALUES 
        (:user_id, 
        :user_name, 
        :user_last_name,
        :user_username,
        :user_address,
        :user_email, 
        :user_password, 
        :user_role, 
        :user_image, 
        :user_created_at, 
        :user_updated_at, 
        :user_deleted_at, 
        :user_is_blocked)
    ');

    $user_id = null;
    $user_name = $_POST['user_name'];
    $user_last_name = $_POST['user_last_name'];
    $user_username = $_POST['user_username'];
    $user_address = $_POST['user_address'];
    $user_email = $_POST['user_email'];
    $user_password = password_hash($_POST['user_password'], PASSWORD_DEFAULT);
    $user_role = $_POST['user_role'];
    $user_created_at = time();
    $user_updated_at = 0;
    $user_deleted_at = 0;
    $user_is_blocked = 0;

    //we use the placeholders to secure, efficient, and maintain the database queries
    $q->bindParam(':user_id', $user_id);
    $q->bindParam(':user_name', $user_name);
    $q->bindParam(':user_last_name', $user_last_name);
    $q->bindParam(':user_username', $user_username);
    $q->bindParam(':user_address', $user_address);
    $q->bindParam(':user_email', $user_email);
    $q->bindParam(':user_password', $user_password);
    $q->bindParam(':user_role', $user_role);
    $q->bindParam(':user_image', $user_image_path);
    $q->bindParam(':user_created_at', $user_created_at);
    $q->bindParam(':user_updated_at', $user_updated_at);
    $q->bindParam(':user_deleted_at', $user_deleted_at);
    $q->bindParam(':user_is_blocked', $user_is_blocked);

    $q->execute();

    $_SESSION['signup_attempts']++;

    echo 'Signed up';
    $insertedUserId = $db->lastInsertId();

    echo json_encode(['user_id' => $insertedUserId]);

} catch (Exception $e) {
    http_response_code($e->getCode() ?: 500);
    echo json_encode(['info' => $e->getMessage()]);
}