<?php

namespace ishop;

class App
{
    public static $app;

    public function __construct()
    {
        $query = $_SERVER['PATH_INFO'];
        if ('' !== $_SERVER['QUERY_STRING']){
            $query .= '?' . $_SERVER['QUERY_STRING'];
        };

        $query = substr($query, 1, strlen($query)-1);
        session_start();
        self::$app = Registry::instance();
        $this->getParams();
        new ErrorHandler();
        Router::dispatch($query);
    }

    protected function getParams()
    {
        $params = require_once CONF . '/params.php';
        if (!empty($params)){
            foreach ($params as $k => $v){
                self::$app->setProperty($k, $v);
            }
        }
    }

}