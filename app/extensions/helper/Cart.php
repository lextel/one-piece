<?php
 
namespace app\extensions\helper;
 
use app\models\Carts;

class Cart extends \lithium\template\Helper {

    public function get($more = false) {

        return Carts::get($more);
    }

}