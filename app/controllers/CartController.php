<?php

namespace app\controllers;

use app\models\Cart;
use lithium\action\DispatchException;

class CartController extends \lithium\action\Controller {
    public function index() {

    }

	public function add() {
        $request = $this->request;
        $id = $request->id;
        $periodId = $request->periodId;
        $quantity = $request->quantity;


        if(!empty($id) && !empty($periodId) && !empty($quantity)) {
            Carts::add($id, $periodId, $quantity);
        }

        $carts = Carts::get();

        return $this->render('json' => $carts);
	}
}

?>
