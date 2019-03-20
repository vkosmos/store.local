<?php

namespace App\Models;

use ishop\App;

class BreadCrumbs
{
    public static function getBreadCrumbs($category_id, $name = '')
    {
        $cats = App::$app->getProperty('cats');
        $breadCrumbsArray = self::getParts($cats, $category_id);
        $breadCrumbs = '<li><a href="' . PATH . '">Главная</a></li>';

        if($breadCrumbsArray){
            foreach($breadCrumbsArray as $alias => $title){
                $breadCrumbs .= "<li><a href='" . PATH . "/category/{$alias}'>{$title}</a></li>";
            }
        }

        if($name){
            $breadCrumbs .= "<li>$name</li>";
        }

        return $breadCrumbs;
    }

    protected static function getParts($cats, $id)
    {
        if(!$id){
            return false;
        }

        $breadCrumbs = [];
        foreach($cats as $v){
            if (isset($cats[$id])){
                $breadCrumbs[$cats[$id]['alias']] = $cats[$id]['title'];
                $id = $cats[$id]['parent_id'];
            }else{
                break;
            }
        }
        return array_reverse($breadCrumbs, true);
    }
}