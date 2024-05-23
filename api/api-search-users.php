<?php 
header('Content-Type: application/json');
require_once __DIR__.'/../_.php';

try{

    $db = _db();
    $q = $db->prepare(' SELECT user_name, user_last_name, user_id 
                        FROM users
                        WHERE user_name LIKE :user_name 
                        OR user_last_name LIKE :user_last_name
                        OR user_id LIKE :user_id
                        ');
    //binds the value from the post array in the search form
    // I use a mix of post and get (post-postback) because i want to show the result on the same time as the user write in the form
    //%{$_POST['query']}% is a like operator - used to match string from the input field in the form
    //query --> værdien af inputfeltet
    $q->bindValue(':user_name', "%{$_POST['query']}%");
    $q->bindValue(':user_last_name', "%{$_POST['query']}%");
    $q->bindValue(':user_id', "%{$_POST['query']}%");
    $q->execute();
    $users = $q->fetchAll();
    echo json_encode($users);

}catch(Exception $e){
        $status_code = !ctype_digit($e->getCode()) ? 500 : $e->getCode();
        $message = strlen($e->getMessage()) == 0 ? 'error - '.$e->getLine() : $e->getMessage();
        http_response_code($status_code);
        echo json_encode(['info'=>$message]);
}


?>
