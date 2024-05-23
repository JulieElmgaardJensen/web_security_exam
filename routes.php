<?php

require_once __DIR__.'/router.php';

// ##################################################
// ##################################################
// ##################################################
// styrer vores routing


get('/', 'views/index');

// JS
get('/app.js', 'js/app.js');


// Page not found
any('/404','views/404.php');