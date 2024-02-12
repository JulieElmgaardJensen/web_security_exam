<?php

$user = array("Janni", "18");

//echo $user[0];

foreach ($user as $value) {
    echo $value . " ";
}

//var_dump($user);

$myArr = array("John", "Mary", "Peter", "Sally");

$lenArray = count($myArr);

echo $lenArray;

echo $myArr[1];

$asso_array = array("name" => "Helle", "age" => "80");

echo $asso_array["name"];
echo $asso_array["age"];

if 
    (in_array("Peter", $myArr)) {
        echo "Match";
}else {
    echo "no match";
}


// Define an array
$array = array("apple", "banana", "orange");

// Get the length of the array
$length = count($array);

// Print the length of the array
echo "The length of the array is: " . $length;


$a = "Hello";
$b = "World";
$c = $a.$b;

echo " $c \n";

define("PI", 3.14);
echo PI;

const AA = 12;
echo AA;