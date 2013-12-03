<?php

namespace app\controllers;

use app\models\Posts;
use app\models\Orders;
use app\models\Products;
use lithium\action\DispatchException;

class IndexController extends \lithium\action\Controller {
    private $_navCurr = 'home';

	public function index() {

        // $shares = Posts::shareIndex(['limit' => 4, 'page' => 1, 'status' => 1]);
		$shares = [];

		$productModel = new Products();
		$hot = $productModel->hots(1);

		$lotterys = $productModel->lottery(['limit' => 4, 'page' => 1]);

		$hots = $productModel->hots(6);

		$orderModel = new Orders();
		$ordering = $orderModel->ordering();


        // print_r($shares);
        //die;

        // 导航
        $navCurr = $this->_navCurr;

        return compact('shares', 'navCurr', 'hot', 'lotterys', 'hots', 'ordering');
	}

}

?>