<?php

namespace app\controllers;

use app\models\Periods;
use lithium\action\DispatchException;

class PeriodsController extends \lithium\action\Controller {

	public function index() {
		$periods = Periods::all();
		return compact('periods');
	}

	public function view() {
		$period = Periods::first($this->request->id);
		return compact('period');
	}

	public function add() {
		$period = Periods::create();

		if (($this->request->data) && $period->save($this->request->data)) {
			return $this->redirect(array('Periods::view', 'args' => array($period->id)));
		}
		return compact('period');
	}

	public function edit() {
		$period = Periods::find($this->request->id);

		if (!$period) {
			return $this->redirect('Periods::index');
		}
		if (($this->request->data) && $period->save($this->request->data)) {
			return $this->redirect(array('Periods::view', 'args' => array($period->id)));
		}
		return compact('period');
	}

	public function delete() {
		if (!$this->request->is('post') && !$this->request->is('delete')) {
			$msg = "Periods::delete can only be called with http:post or http:delete.";
			throw new DispatchException($msg);
		}
		Periods::find($this->request->id)->delete();
		return $this->redirect('Periods::index');
	}
}

?>