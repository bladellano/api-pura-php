<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ERROR);

define('HOST', '127.0.0.1');
define('BANCO', 'api_puro');
define('USUARIO', 'root');
define('SENHA', '');

define('DS', DIRECTORY_SEPARATOR);
define('DIR_APP', __DIR__);
define('DIR_PROJETO', 'api_puro');

if (file_exists('autoload.php')) {
    include 'autoload.php';
} else {
    die('Erro ao incluir bootstrap');
}
