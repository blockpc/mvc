<?php

define('DS', DIRECTORY_SEPARATOR);
define('MVC_START', microtime(true));

define('PRODUCTION', $_ENV['PRODUCTION'] === "true");
define('LOCAL_XAMPP', $_ENV['LOCAL_XAMPP']);

define('APP_NAME', $_ENV['APP_NAME']);
define('ROOT_APP', dirname(__DIR__));

if ( LOCAL_XAMPP ) {
    define('HTTP_HOST', 'localhost/' . LOCAL_XAMPP);
} else {
    define('HTTP_HOST', $_ENV['APP_URL']);
}

if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
    define('URL_BASE', "https://".HTTP_HOST);
} else {
    define('URL_BASE', "http://".HTTP_HOST);
}

define('DB_CONNECTION', $_ENV['DB_CONNECTION']);
define('DB_HOST', $_ENV['DB_HOST']);
define('DB_PORT', $_ENV['DB_PORT']);
define('DB_DATABASE', $_ENV['DB_DATABASE']);
define('DB_USERNAME', $_ENV['DB_USERNAME']);
define('DB_PASSWORD', $_ENV['DB_PASSWORD']);

define('MAX_FILE_SIZE', $_ENV['MAX_FILE_SIZE']);
define('MAX_FILE_TEXT', $_ENV['MAX_FILE_TEXT']);