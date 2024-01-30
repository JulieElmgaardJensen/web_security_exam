<?php

require_once __DIR__.'/router.php';

// ##################################################
// ##################################################
// ##################################################


get('/', 'views/index');
get('/dk', 'views/index.php?lan=dk');

// JS
get('/app.js', 'js/app.js');


// Page not found
any('/404','views/404');