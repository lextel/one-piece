<?php

namespace app\controllers;

use lithium\action\DispatchException;
use app\extensions\helper\MongoClient;

class LotterysController extends \lithium\action\Controller {

	private $_navCurr = 'lottery';

	public function index() {

        $mo = new MongoClient;
        $rs = $mo->getConn()->find(['periods' => ['$elemMatch' => ['remain' => 0, 'status' => 2]]]);
        $rs = iterator_to_array($rs);
        // print_r($rs);
		
		// 当前导航
        $navCurr = $this->_navCurr;

		return $this->render(['data' => compact('navCurr')]);
	}

}

?>