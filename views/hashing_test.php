<?php

$time = 0.1;

$cost = 10;

do
{
  $cost++;
  
  $start = microtime(true);
  password_hash('test', PASSWORD_BCRYPT, ['cost' => $cost]);
  $end = microtime(true);
}
while (($end - $start) < $time);
echo 'Cost found: ' . $cost;



$password = 'my secret password';

$options = ['cost' => 10];

$hash = password_hash($password, PASSWORD_DEFAULT);

$options['cost'] = 11;

if (password_needs_rehash($hash, PASSWORD_DEFAULT, $options))
{
  echo 'You need to rehash the password.';
}