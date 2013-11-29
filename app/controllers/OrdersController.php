<?php

namespace app\controllers;

use app\models\Orders;
use app\extensions\helper\Page;
use lithium\action\DispatchException;

class OrdersController extends \lithium\action\Controller {

	public function index() {

	}

	// 商品详情页ajax加载
	public function product() {

        $request = $this->request;
        $page    = $request->page ? : 1;
        $limit   = Page::$page;
        $productId = $request->productId;
        $periodId = $request->periodId;

        $conditions = ['product_id' => $productId, 'period_id' => $periodId];
        $total = Orders::find('all', compact('conditions'))->count();
        $orders = Orders::find('all', compact('limit', 'page', 'conditions'))->to('array');

        $this->render(['data' => compact('orders', 'total', 'page', 'limit'),'layout' => false]);
	}
}

?>