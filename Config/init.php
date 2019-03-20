<?php

define('DEBUG', 1);
define('ROOT', dirname(__DIR__));
define('WWW', ROOT . '/public');
define('APP', ROOT . '/App');
define('CORE', ROOT . '/vendor/ishop/core');
define('LIBS', ROOT . '/vendor/ishop/core/libs');
define('CACHE', ROOT . '/Tmp/Cache');
define('CONF', ROOT . '/Config');
define('LAYOUT', 'watches');

//http://store.local/public/index.php/ttt/ggg
$app_path = "http://{$_SERVER['HTTP_HOST']}";
//$app_path = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}";
//echo $app_path;
//http://store.local/public/
//$app_path = preg_replace('#[^.php]+$#', '', $app_path);
//$app_path = preg_replace('#[^/]+$#', '', $app_path);
//http://store.local/
$app_path = str_replace('/public/', '', $app_path);

define('PATH', $app_path);
define('ADMIN', PATH . '/admin');

require_once ROOT . '/vendor/autoload.php';