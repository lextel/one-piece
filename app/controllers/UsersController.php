<?php

namespace app\controllers;

use app\models\Users;
use lithium\action\DispatchException;

class UsersController extends \lithium\action\Controller {

	public function register() {
		
		return $this->render();
	}

	public function login() {
		
		return $this->render();
	}

    public function center() {

        return $this->render(['layout' => 'user']);
    }


}

?>