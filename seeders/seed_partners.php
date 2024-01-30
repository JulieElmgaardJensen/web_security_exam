<?php
ini_set('display_errors',1);
require_once __DIR__.'/../_.php';
require_once __DIR__.'/Faker/src/autoload.php';

// use the factory to create a Faker\Generator instance
$faker = Faker\Factory::create();
// Get many user id from the databse, from the user's table

//connect to database
$db = _db();
//Tager random user_ids fra users og limiter den til 2 ids
$q = $db->prepare('SELECT user_id FROM users ORDER BY RAND() LIMIT 2');
$q->execute();
//Laver om til en string
$ids = $q->fetchAll(PDO::FETCH_COLUMN);

$q = 'INSERT INTO partners VALUES ';
$values = '';
$array_length = count($ids);
for ($i = 0; $i < $array_length; $i++) {
  $index = array_rand($ids);
  $user_partner_fk = $ids[$index];
  unset($ids[$index]);
  //vi henter forskellige lat og long koordinater og laver dem om til en string da det skal sættes i en varchar
  //Behøves man ikke - man kan bare komme dem direkte 
  //$latitude = strval($faker->latitude);
  //$longitude = strval($faker->longitude);

  $values .= "($user_partner_fk, '$faker->latitude,$faker->longitude'),";
}

$values = rtrim($values, ",");
$q .= $values;

echo $q;

$db = _db();
$sql = $db->prepare($q);
$sql->execute();