<?php
/* 100 ms. */
$time = 0.1;
/* Initial cost. */
$cost = 10;
/* Loop until the time required is more than 100ms. */
do
{
  /* Increase the cost. */
  $cost++;
  
  /* Check how much time we need to create the hash. */
  $start = microtime(true);
  password_hash('test', PASSWORD_BCRYPT, ['cost' => $cost]);
  $end = microtime(true);
}
while (($end - $start) < $time);
echo 'Cost found: ' . $cost;


/* Password. */
$password = 'my secret password';
/* Set the "cost" parameter to 10. */
$options = ['cost' => 10];
/* Create the hash. */
$hash = password_hash($password, PASSWORD_DEFAULT);
/* Now, change the cost. */
$options['cost'] = 11;
/* Check if the hash needs to be created again. */
if (password_needs_rehash($hash, PASSWORD_DEFAULT, $options))
{
  echo 'You need to rehash the password.';
}