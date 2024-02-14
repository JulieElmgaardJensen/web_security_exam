<?php

// $user = array("Janni", "18");

// //echo $user[0];

// foreach ($user as $value) {
//     echo $value . " ";
// }

// //var_dump($user);

// $myArr = array("John", "Mary", "Peter", "Sally");

// $myJSON = json_encode($myArr);

// echo $myJSON;

// $myNew = json_decode($myJSON);

// echo $myNew[0];

// $lenArray = count($myArr);

// echo $lenArray;

// echo $myArr[1];

// $asso_array = array("name" => "Helle", "age" => "80");

// echo $asso_array["name"];
// echo $asso_array["age"];

// if 
//     (in_array("Peter", $myArr)) {
//         echo "Match";
// }else {
//     echo "no match";
// }


// // Define an array
// $array = array("apple", "banana", "orange");

// // Get the length of the array
// $length = count($array);

// // Print the length of the array
// echo "The length of the array is: " . $length;


// $a = "Hello";
// $b = "World";
// $c = $a.$b;

// echo " $c \n";

// define("PI", 3.14);
// echo PI;

// const AA = 12;
// echo AA;


// foreach($user as $users){
//     echo $user['user_name'] . '<br>';
// }
// require_once __DIR__.'/_.php';

// $db = _db();
// $q = $db->prepare('SELECT * FROM users');
// $q->execute();

// $users = $q->fetchAll();

// foreach($users as $user){
//     echo $user['user_name'] . ' ';}

//     $db = _db();
//     $sql = $db->prepare('SELECT * FROM orders');
//     $sql->execute();

//     $orders = $sql->fetchAll();

//     foreach($orders as $order){
//         echo $order['order_user_fk'] . ' ';
//     }




// require_once __DIR__.'/_.php';

// $db = _db();
// $q = $db->prepare('SELECT * FROM products');
// $q->execute();

// $products = $q->fetchAll();

// foreach($products as $product){
//     echo $product['product_name'] . ' ';
// }

// $array = array('name' => 'Julie', 'age' => '26');

// var_dump($array);

// $JSONarray = json_encode($array);

// echo $JSONarray;







// require_once __DIR__.'/_.php';

// $db = _db();
// $q = $db->prepare('SELECT * FROM orders');
// $q->execute();

// $orders = $q->fetchAll();

// foreach($orders as $order){
//     echo 'Ordered at:'. $order['order_ordered_at']. ' ';
// }

// echo strlen('xx');

// $array = array('a', 'b', 'c');
// echo $array[0];
// echo count($array);
// var_dump($array);
// print_r($array);

// $jsonarray = json_encode($array);
// echo $jsonarray;

// if('a' == 'a'){
//     echo 'true';
// }else {
//     echo 'false';
// }


// if(in_array('a', $array)){
//     echo 'yes';
// }else{
//     echo 'no';
// }





// $user = array('name' => 'Julie', 'age' => '26', 'city' => 'Copenhagen' );

// // echo $user['name'];

// echo implode(', ', $user);




// if(2 != 2){
//     echo 'true';
// }else{
// echo 'false';
// }

// $users = array('Julie', 'Jens', 'Børge');

// foreach($users as $value){
//     echo "<div>$value</div>";
   
// }

// $names = array("Alice", "Bob", "Charlie");

// foreach($names as $name){
//     echo "<div>$name</div>";
// }

// // First String 
// $a = 'Hello'; 
 
// // Second String 
// $b = 'World!'; 
 
// // Concatenation Of String 
// $c = $a.$b; 
 
// // print Concatenate String 
// echo "$c"; 

// $a .= 'julie';

// echo "$a";




$user = array('name' => 'Julie', 'city' => 'Copenhagen');

echo implode(', ', $user);

print_r($user);


$users = array('julie', 'niels', 'harry');

foreach($users as $user){
    if($user != 'janni'){
        echo "<div>$user</div>";
    }else{
        echo "janni user";
    }
}


$x = 5;
$y = 10;

echo $x + $y;