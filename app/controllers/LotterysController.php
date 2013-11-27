<?php

namespace app\controllers;

use lithium\action\DispatchException;

class LotterysController extends \lithium\action\Controller {

	private $_navCurr = 'lottery';

	public function index() {
		
		// 当前导航
        $navCurr = $this->_navCurr;

		return $this->render(['data' => compact('navCurr')]);
	}

}

?>