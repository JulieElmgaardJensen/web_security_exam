<?php
ini_set('display_errors',1);

require_once __DIR__.'/../_.php';
require_once __DIR__.'/Faker/src/autoload.php';

// use the factory to create a Faker\Generator instance
$faker = Faker\Factory::create();

//$q = 'INSERT INTO roles VALUES ("user","partner","employee","admin")';
//giver mig id og kommer user/partner/employee,admin på

$q = 'INSERT INTO roles VALUES (null, "user"),(null,"partner"),(null, "employee"),(null, "admin")';


echo $q;
$db = _db();
$sql = $db->prepare($q);
$sql->execute();