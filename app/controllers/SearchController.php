<?php

namespace app\controllers;

use app\models\Products;

class SearchController extends \lithium\action\Controller {

    public function index() {

        $request  = $this->request;
        $limit    = Page::$page;
        $title    = $query->q;
        $page     = $request->page ? : 1;
        $sort     = isset($request->query['sort']) ? $request->query['sort'] : '';
        $sortBy   = isset($request->query['sortBy']) ? $request->query['sortBy'] : '';
        $status   = 1;
        $getTotal = true;
        $total = Products::lists(compact('status', 'title', 'getTotal'));
        $products = Products::lists(compact('limit', 'page', 'title','status', 'sort', 'sortBy'), true);

        // 排序标签
        $sortList = Sort::sort('search', $sort, $sortBy);

        return compact('products', 'limit', 'page', 'total', 'sortList');
    }
}

?>
