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

        $data = [];
        foreach($carts as $k => $cart) {
            $product = Products::find('first', ['conditions' => ['_id' => $cart['id']]])->to('array');
            $data[$k] = ['title' => $product['title'], 'image' => $product['images'][0]] + $cart;
        }

        return $data;
    }

    /**
     * 购物车商品数量
     *
     * @return integer
     */
    public static function count() {

        return count(self::get());
    }

    /**
     * 购物车总件数
     *
     * @return integer
     */
    public static function quantity() {

        $carts = Carts::get();
        $quantity = 0;
        foreach($carts as $cart) {
            $quantity += $cart['quantity'];
        }

        return $quantity;
    }

    /**
     * 移除商品
     *
     * @param $id mongoid 
     * @param $periodId 
     *
     * @return void
     */
    public static function del($id, $periodId) {

        $carts = Carts::get();
        foreach($carts as $k => $cart) {
            if($cart['id'] == $id && $cart['periodId'] == $periodId) {
                unset($carts[$k]);
            }
        }

        if(USER_ID) {
            Session::write('myCart', $carts);
        } else {
            Session::write('cart', $carts);
        }
    }
}


?>
