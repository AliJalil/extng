<?php

// DB Params
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "extngDb");

// App Root
define('APPROOT', dirname(dirname(__FILE__)));

// URL Root
//define('URLROOT', 'https://imamali.tech:50032/extng');
define('URLROOT', 'http://localhost/extng');

// Site Name
define('SITENAME', 'معلومات المطافئ');

define('PERMISSION_COLUMN', 'pName');
ini_set('display_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('Asia/Baghdad');

