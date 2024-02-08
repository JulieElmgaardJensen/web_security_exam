<?php
require_once __DIR__.'/../_.php';

try {
    _validate_user_name();
    _validate_user_last_name();
    _validate_user_username();
    _validate_user_email();
    _validate_user_password();
    _validate_user_confirm_password();

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

    $q->bindParam(':user_id', $user_id);
    $q->bindParam(':user_name', $user_name);
    $q->bindParam(':user_last_name', $user_last_name);
    $q->bindParam(':user_username', $user_username);
    $q->bindParam(':user_address', $user_address);
    $q->bindParam(':user_email', $user_email);
    $q->bindParam(':user_password', $user_password);
    $q->bindParam(':user_role', $user_role);
    $q->bindParam(':user_created_at', $user_created_at);
    $q->bindParam(':user_updated_at', $user_updated_at);
    $q->bindParam(':user_deleted_at', $user_deleted_at);
    $q->bindParam(':user_is_blocked', $user_is_blocked);

    $q->execute();
    echo 'Signed up';
    $insertedUserId = $db->lastInsertId();

    echo json_encode(['user_id' => $insertedUserId]);

} catch (Exception $e) {
    http_response_code($e->getCode() ?: 500);
    echo json_encode(['info' => $e->getMessage()]);
}