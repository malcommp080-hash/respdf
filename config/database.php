<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');       
define('DB_PASS', '');           
define('DB_NAME', 'dav');
define('TIMEZONE', 'America/Mexico_City');


$scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
$scriptDir = rtrim($scriptDir, '/');
define('BASE_URL', $scriptDir . '/index.php');
