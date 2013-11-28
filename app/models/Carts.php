<?php

namespace app\models;

use app\models\Periods;
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

        self::set($carts);
    }

    /**
     * 写入购物车
     *
     * @param $carts array 商品数据
     *
     * @return void
     */
    public static function set($carts) {

        if(USER_ID) {
            Session::write('myCart', $carts);
        }  else {
            Session::write('cart', $carts);
        }
    }

    /**
     * 获取购物车数据
     *
     * @param $more boolean 是否加载更多
     *
     * @return array
     */
    public static function get($more = false) {

        if(USER_ID) {
            $carts = Session::read('myCart');
        }  else {
            $carts = Session::read('cart');
        }

        $data = [];
        if(!is_array($carts)) return $data;


        foreach($carts as $k => $cart) {

            $conditions = ['_id' => $cart['id']];
            $product = Products::find('first', ['conditions' => $conditions])->to('array');
            $addtion = ['title' => $product['title'], 'image' => $product['images'][0]];
            
            if($more) {
                $idx = count($product['periods']) - 1;
                $period = $product['periods'][$idx];

                $addtion += [
                    'price' => $period['price'],
                    'person' => $period['person'],
                    'remain' => $period['remain'],
                ];
            }

            $data[$k] =$addtion + $cart;
        }

        return $data;
    }

    /**
     * 移除商品
     *
     * @param $idx integer 在购物车的索引
     *
     * @return void
     */
    public static function del($idx) {

        $carts = Carts::get();
        unset($carts[$idx-1]);
        $carts = array_values($carts);

        self::set($carts);
    }

    /**
     * 批量删除
     * 
     * @param $idxs array 购物车索引数组
     *
     * @return void
     */
    public static function batchDel($idxs) {

        foreach($idxs as $idx) {
            self::del($idx);
        }
    }

    /**
     * 支付
     *
     * @param $bank 银行代号
     *
     * @return 支付参数
     */
    public static function pay($bank) {

        $order = microtime(true).rand(100,999);
        $carts = self::get();
        $price = 0;
        $titles = [];
        foreach($carts as $cart) {
            $price += $cart['quantity'];
            $titles[] =  $cart['title'];
        }

        Session::write('orderNo', $order);

        $data = [
            'p2_Order' => microtime(true),
            'p3_Amt'   => $price,
            'p4_Cur'   => 'CNY',
            'p5_Pid'   => 'buy',
            'p6_Pcat'  => 'product',
            'p7_Pdesc' => 'code',
            'p8_Url'   => 'http://www.pp.com/cart/payResult',
            'pa_MP'    => base64_encode(serialize($carts)),
            'pd_FrpId' => $bank,
        ];

        return $data;
    }

    /**
     * 清空购物车
     */
    public static function clear() {

        Session::write('myCart', []);
        Session::write('cart', []);
    }

    /**
     * 修改商品数量
     *
     * @param $id       mongoid 商品ID
     * @param $periodId integer 期数
     * @param $quantity integer 数量
     *
     * @return array
     */
    public static function modify($id, $periodId, $quantity) {

        $product = Products::find('first', ['conditions' => ['_id' => $id]])->to('array');
        $period = $product['periods'][$periodId-1];

        // 不是可购买状态
        if($period['status'] > 0) {
            return ['status' => 0, 'remain' => 0];
        }

        $status = 1;
        // 购买数量大于剩余数量
        if($period['remain'] < $quantity) {
            $status = 0;
            $quantity = $period['remain'];
        }

        $carts = self::get();
        foreach($carts as $k => $cart) {
            if($cart['id'] == $id && $cart['periodId'] == $periodId) {
                // 如果被卖完了
                if($period['remain'] == 0) {
                    unset($carts[$k]);
                } else {
                    $carts[$k]['quantity'] = $quantity;
                }
            } 
        }

        $carts = array_values($carts);

        self::set($carts);

        return ['status' => $status, 'quantity' => $quantity, 'remain' => $period['remain']];
    }
}
?>
