<?php

namespace app\controllers;

use lithium\action\DispatchException;
use app\extensions\helper\MongoClient;

class LotterysController extends \lithium\action\Controller {

	private $_navCurr = 'lottery';

	public function index() {

<<<<<<< HEAD
        $mo = new MongoClient;
        $rs = $mo->getConn()->find(['periods' => ['$elemMatch' => ['remain' => 0, 'status' => 2]]]);
        $rs = iterator_to_array($rs);
        // print_r($rs);
		
=======
>>>>>>> 71d1e38ff803eedad3145280fd7ecca53ea61695
		// 当前导航
    $navCurr = $this->_navCurr;

		return $this->render(['data' => compact('navCurr')]);
	}

}

?>
