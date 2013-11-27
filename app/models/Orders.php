<?php

namespace app\models;

use app\models\Carts;
use app\models\Periods;
use app\models\Products;

class Orders extends \lithium\data\Model {

	/**
     * 下订单
     */
    public static function order() {

    	$carts = Carts::get(true);

    	foreach($carts as $cart) {

    		$conditions = ['_id' => $cart['id']];
    		$product = Products::find('first', ['conditions' => $conditions])->to('array');

    		$period = Periods::period($cart['id'], $cart['periodId']);

    		$orderTotal = 0;
    		$codes = [];
    		foreach($period['orders'] as $order) {
                if(!is_null($order)) {
        			$orderTotal += count($order['count']);
        			$codes = array_merge($codes, $order['codes']);
                }
    		}

    		// 如果未满人
			if($orderTotal <= $period['person']) {
                $myCodes = [];
    			for ($i=0; $i < $cart['quantity']; $i++) { 
    				$myCodes[] = self::code($codes, $period['person']);
    			}

                $time = microtime(true);
                $codeTotal = count($myCodes);
	    		$data = [
	    			'user_id' => USER_ID,
	    			'ordered' => $time,
	    			'codes'   => $myCodes,
	    			'count'   => $codeTotal,
	    		];

	    		$idx = $cart['periodId'] - 1;
                
	    		$query = [
                    '$push' => ['periods.'.$idx.'.orders' => $data], 
                    '$inc' => ['remain' => -$codeTotal, 'periods.'.$idx.'.remain' => -$codeTotal], 
                    ];

	    		Products::update($query, $conditions, ['atomic' => false]);

			}

            // 如果刚满人
            if($orderTotal + $codeTotal == $period['person']) {
                // 写入揭晓时间
                $showed = time() + 5 * 60;
                $product->showed = $showed;
                $product->save();

                self::next($product);

            }
    	}
    }


    /**
     * 进入揭晓状态下一步
     *
     * @param $product object 商品对象
     *
     * @return void
     */
    public static function next($product) {

        // 如果是上架自动新增一期
        if($product->status == 2) {
            Periods::add($cart['id']);
        }

        // 如果正在下价更新为下架状态
        if($product->status == 1) {
            $product->status = 0;
            $product->save();
        }
}

/**
 	 * 生成云购码
 	 *
 	 * @param $codes    array   已经使用
 	 * @param $person   integer 最大数目
     *
     * @return array
     */
    public static function code(&$codes, $person) {

    	$code = rand(1, $person);
    	if(in_array($code, $codes))
    		$code = self::code($codes, $person);

        $codes[] = $code;

    	return $code;
    }
}

?>