<?php

namespace app\controllers;

use app\models\Posts;
use app\models\Orders;
use app\models\Products;
use lithium\action\DispatchException;

class IndexController extends \lithium\action\Controller {
    private $_navCurr = 'home';

	public function index() {

        // 晒单
        $postModel = new Posts();
        $shares = $postModel->shareIndex(['limit' => 4, 'page' => 1, 'status' => 1]);

		$productModel = new Products();
        // 人气单品
		$hot = $productModel->hots(1);

        // 最新揭晓
		$lotterys = $productModel->lottery(['limit' => 4, 'page' => 1]);

        // 人气商品列表
		$hots = $productModel->hots(6);

        // 正在云购
		$orderModel = new Orders();
		$ordering = $orderModel->ordering();

        // 公告调用
        $notices = $postModel->notice();

        // 导航
        $navCurr = $this->_navCurr;

        return compact('shares', 'navCurr', 'hot', 'lotterys', 'hots', 'ordering','notices');
	}

}

?>