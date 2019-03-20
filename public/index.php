<?php

require __DIR__ . '/../Config/init.php';
require LIBS . '/functions.php';
require CONF . '/routes.php';

new \ishop\App();

//debug(\ishop\Router::getRoutes());
//throw new Exception('Страница не найдена', 404);