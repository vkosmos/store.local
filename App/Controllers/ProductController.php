<?php


namespace App\Controllers;

use App\Models\BreadCrumbs;
use App\Models\Product;

class ProductController extends AppController
{

    public function viewAction()
    {
        $alias = $this->route['alias'];
        $product = \R::findOne('product', "alias = ? AND status = '1'", [$alias]);

        if (!$product){
            throw new \Exception('Страница не найдена. Товар: ' . $alias, 404);
        }

        // Хлебные крошки
        $breadCrumbs = BreadCrumbs::getBreadCrumbs($product->category_id, $product->title);

        // Связанные товары
        $related = \R::getAll('SELECT * FROM related_product 
                                        JOIN product ON product.id = related_product.related_id  
                                        WHERE related_product.product_id = ?', [$product->id]
                                );

        // Запись в куки запрошенного товара
        $p_model = new Product();
        $p_model->setRecentlyViewed($product->id);

        // Просмотренные товары
        $r_viewed = $p_model->getRecentlyViewed();
        $recentlyViewed = null;
        if($r_viewed){
            $recentlyViewed = \R::find('product', 'id IN (' . \R::genSlots($r_viewed) . ') LIMIT 3', $r_viewed);
        }

        // Галлерея
        $gallery = \R::findAll('gallery', 'product_id = ?', [$product->id]);

        // Все модификации данного товара
        $mods = \R::findAll('modification', 'product_id = ?', [$product->id]);
//        debug($mods);

        $this->setMeta($product->title, $product->description, $product->keywords);
        $this->set(compact('product', 'related', 'gallery', 'recentlyViewed', 'breadCrumbs', 'mods'));
    }
}