<?php
ini_set('display_errors',1);
require_once __DIR__ . '/../_.php';
require_once __DIR__ . '/Faker/src/autoload.php';

// use the factory to create a Faker\Generator instance
$faker = Faker\Factory::create();
// Get many user id from the databse, from the user's table

//connect to database
$db = _db();
//Tager random user_ids fra users og limiter den til 2 ids
$q = $db->prepare('SELECT user_id FROM users ORDER BY RAND() LIMIT 2');
$q->execute();
//Laver om til en string for
$ids = $q->fetchAll(PDO::FETCH_COLUMN); // [5,10]

$q = 'INSERT INTO employees VALUES ';
$values = '';
$array_length = count($ids);
for ($i = 0; $i < $array_length; $i++) {
  $salary = rand(10000, 99999);
  $index = array_rand($ids);
  $user_employee_fk = $ids[$index];
  unset($ids[$index]);
  $values .= "($user_employee_fk, $salary),";
}
$values = rtrim($values, ",");
$q .= $values;

echo $q;
$db = _db();
$sql = $db->prepare($q);
$sql->execute();










