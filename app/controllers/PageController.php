<?php
namespace app\controllers;

class PageController extends \lithium\action\Controller {

	public function index() {

		return $this->redirect('Page::notfound');
	}

	public function notfound() {

		return $this->render(['template' => '../_errors/404']);
	}
	
}