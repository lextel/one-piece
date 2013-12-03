<?php

namespace app\controllers;

use app\models\Orders;
use app\models\Users;
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
        $order = ['_id' => 'desc'];
        $total = Orders::find('all', compact('conditions'))->count();
        $orders = Orders::find('all', compact('limit', 'page', 'conditions', 'order'))->to('array');

        $user = new Users;
        foreach($orders as $k => $order) {
            $orders[$k]['user'] = $user->profile($order['user_id']);
        }

        $this->render(['data' => compact('orders', 'total', 'page', 'limit'),'layout' => false]);
	}

    public function user() {
        echo '编写中。。';
        die;
    }
}

?>