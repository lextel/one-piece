<?php

namespace app\models;

use lithium\storage\Session;

class Carts extends \lithium\data\Model {

    
    /**
     * 添加到购物车
     *
     * @param $data array 购物车数据
     *                    $data['id']   mongid
     *                    $data['periodId'] 期数
     *                    $data['quantity'] 数目
     *
     * @return void
     */
    public static function add($data) {

        $carts = self::get();
        $isPut = false;
        foreach( $carts as $k => $cart ) {
            if($cart['id'] == $data['id'] && $cart['periodId'] == $data['periodId'] ) {
                $carts[$k]['quantity'] = $carts[$k]['quantity'] + $data['quantity'];
                $isPut = true;;
            }
        }

        if(!$isPut) $carts[] = $data;

        if(USER_ID) {
            Session::write('myCart', $carts);
        }  else {
            Session::write('cart', $carts);
        }
    }

    /**
     * 获取购物车数据
     *
     * @return array
     */
    public static function get() {

        if(USER_ID) {
            $carts = Session::read('myCart');
        }  else {
            $carts = Session::read('cart');
        }

        return $carts;
    }
}


?>
