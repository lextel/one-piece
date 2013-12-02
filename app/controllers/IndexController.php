<?php

namespace app\controllers;

use app\models\Posts;
use lithium\action\DispatchException;

class IndexController extends \lithium\action\Controller {
    private $_navCurr = 'home';

	public function index() {

        $shares = Posts::shareIndex(['limit' => 4, 'page' => 1, 'status' => 1]);


        print_r($shares);
        //die;

        // 导航
        $navCurr = $this->_navCurr;

        return compact('shares', 'navCurr');
	}

}

?>