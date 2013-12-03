<?php

namespace app\controllers;

use app\models\Orders;
use app\models\Products;
use app\extensions\helper\Page;
use lithium\action\DispatchException;

class LotterysController extends \lithium\action\Controller {

	const GET_TOTAL = true;

	private $_navCurr = 'lottery';

	public function index() {

		$request  = $this->request;
        $limit    = Page::$page;
        $page     = $request->page ? $request->page : 1;
        $getTotal = self::GET_TOTAL;

		$productModel = new Products();
		$total = $productModel->lottery(compact('getTotal'));
		$lotterys = $productModel->lottery(compact('limit', 'page'));

		$hots = $productModel->hots();

		$orderModel = new Orders();
		$ordering = $orderModel->ordering();

		// 当前导航
        $navCurr = $this->_navCurr;

        return compact('total','lotterys', 'page', 'navCurr', 'limit', 'ordering', 'hots');
	}

}

?>
