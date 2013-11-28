<?php

namespace app\controllers;

use lithium\action\DispatchException;

class HelpController extends \lithium\action\Controller {

	public function index() {}

    public function newbie() {

        $navCurr = 'newbie';
        
        return compact('navCurr');
    }
}

?>