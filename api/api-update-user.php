<?php
header('Content-Type: application/json');
require_once __DIR__.'/../_.php';

try {
    session_start();

    // Check if the session token and POST token are set
    if (!isset($_SESSION['token']) || !isset($_POST['token'])) {
        throw new Exception('Token is not set.', 400);
    }

    // Validate the token
    if ($_POST['token'] !== $_SESSION['token']) {
        throw new Exception('Invalid token.', 400);
    }

    // Validate the inputs we can update
    _validate_user_name();
    _validate_user_last_name();
    _validate_user_address();

    // Use the session user_id because we update the logged-in user
    $user_id = $_SESSION['user']['user_id'];

    $upload_dir = '/uploads/';
    $user_image_path = null;

    // Check if an image is uploaded and update $user_image_path if necessary
    if (isset($_FILES['user_image']) && $_FILES['user_image']['error'] === UPLOAD_ERR_OK) {
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

    // Prepare the SQL query based on whether an image was uploaded
    if ($user_image_path) {
        $q = $db->prepare('
            UPDATE users
            SET user_name = :user_name,
                user_last_name = :user_last_name,
                user_address = :user_address,
                user_image = :user_image,
                user_updated_at = :time
            WHERE user_id = :user_id
        ');

        $q->bindParam(':user_image', $user_image_path);
    } else {
        $q = $db->prepare('
            UPDATE users
            SET user_name = :user_name,
                user_last_name = :user_last_name,
                user_address = :user_address,
                user_updated_at = :time
            WHERE user_id = :user_id
        ');
    }

    $q->bindValue(':user_name', $_POST['user_name']);
    $q->bindValue(':user_last_name', $_POST['user_last_name']);
    $q->bindValue(':user_address', $_POST['user_address']);
    $q->bindValue(':time', time());
    $q->bindValue(':user_id', $user_id);

    $q->execute();
    $counter = $q->rowCount();

    // If no rows are affected, the user is not updated
    if ($counter != 1) {
        throw new Exception('Could not update user', 500);
    }

    http_response_code(204);

} catch (Exception $e) {
    http_response_code($e->getCode());
    echo json_encode(['error' => $e->getMessage()]);
}