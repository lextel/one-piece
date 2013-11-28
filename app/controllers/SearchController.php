<?php

namespace app\controllers;

use app\models\Products;
use app\extensions\helper\Sort;
use app\extensions\helper\Page;

class SearchController extends \lithium\action\Controller {

    public function index() {

        $request  = $this->request;
        $limit    = Page::$page;
        $title    = urldecode($request->title);
        $page     = $request->page ? : 1;
        $sort     = isset($request->query['sort']) ? $request->query['sort'] : '';
        $sortBy   = isset($request->query['sortBy']) ? $request->query['sortBy'] : '';
        $status   = 1;
        $getTotal = true;
        $total = Products::lists(compact('status', 'title', 'getTotal'));
        $products = Products::lists(compact('limit', 'page', 'title', 'status', 'sort', 'sortBy'), true);

        // 面包屑
        $crumbs = '商品搜索';

        // 排序标签
        $sortList = Sort::sort('search', compact('title','sort', 'sortBy'));

        return compact('products', 'limit', 'page', 'total', 'sortList', 'crumbs', 'title');
    }
}

?>
