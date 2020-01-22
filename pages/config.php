<?php
//zápis proměnné echo $promenna
//config.php

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'databaze_filmu');

define('BASE_URL', parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH));

define('CURRENT_URL',
  $_SERVER['SCRIPT_NAME'] . '?' . $_SERVER['QUERY_STRING']);
?>



