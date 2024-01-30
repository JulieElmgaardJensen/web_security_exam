<?php
ini_set('display_errors',1);
require_once __DIR__.'/../_.php';
require_once __DIR__.'/Faker/src/autoload.php';

// use the factory to create a Faker\Generator instance
$faker = Faker\Factory::create();

// generate data by accessing properties
// echo $faker->firstName;
  // 'Lucy Cechtelar';
// echo $faker->address;
  // "426 Jordy Lodge
  // Cartwrightshire, SC 88120-6700"
// echo $faker->text;
  // Dolores sit sint laboriosam dolorem culpa et autem. Beatae nam sunt fugit
  // et sit et mollitia sed.
  // Fuga deserunt tempora facere magni omnis. Omnis quia temporibus laudantium
  // sit minima sint.

  $q = 'INSERT INTO users VALUES ';
  $values = '';
  for($i = 0; $i < 10; $i++){
    // $user_id = bin2hex(random_bytes(16));
    $password = password_hash($faker->password, PASSWORD_DEFAULT);
    $blocked  = rand(0,1);
    $created_at = time();
    $values .= "(null,
                '$faker->firstName',
                '$faker->lastName',
                '$faker->userName',
                '$faker->address',
                '$faker->email',
                '$password',
                'user',
                $created_at,
                0,
                0,
                $blocked),"; 
  }
  $values = rtrim($values, ",");
  $q .= $values;

  echo $q;
$db = _db();
$sql = $db->prepare($q);
$sql->execute();