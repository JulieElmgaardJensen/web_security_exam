<?php
session_start();

//Tilføjet efter aflevering - removes the current cookie
setcookie(session_name(), '', time() - 3600, '/');

session_destroy();
header('Location: /login');
exit();