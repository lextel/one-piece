<?php

namespace app\models;

use app\models\Carts;
use app\models\Periods;
use app\models\Products;
use app\extensions\helper\MongoClient;

class Orders extends \lithium\data\Model {

    const SHOW_TIME     = 5;    // 倒计时揭晓时间

    /**
     * mongodb orders数据结构
     *
     * @var array
     */
    protected $_schema = [
        '_id'        => ['type' => 'id'],             // UUID
        'user_id'    => ['type' => 'integer'],        // 所属会员ID
        'product_id' => ['type' => 'string'],         // 商品ID
        'period_id'  => ['type' => 'integer'],        // 期数ID
        'codes'      => ['type' => 'array'],          // 云购码 
        'count'      => ['type' => 'integer'],        // 云购数量
        'created'    => ['type' => 'string'],         // 时间（到毫秒）
    ];


	/**
     * 下订单
     */
    public static function order() {

    	$carts = Carts::get(true);

    	foreach($carts as $cart) {
            $time = microtime(true);

    		$conditions = ['_id' => $cart['id']];
    		$product = Products::find('first', ['conditions' => $conditions])->to('array');
    		$period = Periods::period($cart['id'], $cart['periodId']);

    		$orderTotal = 0;
    		$codes = [];

            $orders = Orders::find('all', ['conditions' => ['product_id' => $cart['id'], 'period_id' => $cart['periodId']]])->to('array');
    		foreach($orders as $order) {
    			$orderTotal += count($order['count']);
    			$codes = array_merge($codes, $order['codes']);
    		}

            $idx = $cart['periodId'] - 1;

    		// 如果未满人
			if($orderTotal <= $period['person']) {
                $myCodes = [];
                
    			for ($i=0; $i < $cart['quantity']; $i++) { 
    				$myCodes[] = self::code($codes, $period['person']);
    			}
                
                $codeTotal = count($myCodes);
	    		$data = [
	    			'user_id'    => USER_ID,
                    'product_id' => $cart['id'],
                    'period_id'  => $cart['periodId'],
	    			'ordered'    => $time,
	    			'codes'      => $myCodes,
	    			'count'      => $codeTotal,
	    		];

                // 写入orders表
                $order = Orders::create($data);
                $order->save();

                // 更新剩余数量
	    		$query = [
                    '$inc' => [
                        'remain' => -$codeTotal, 
                        'periods.'.$idx.'.remain' => -$codeTotal
                        ], 
                     
                    ];

	    		Products::update($query, $conditions, ['atomic' => false]);
			}

            // 如果刚满人
            if($orderTotal + $codeTotal == $period['person']) {
                // 写入揭晓时间
                $query = [
                    '$set' => [
                            'periods.'.$idx.'.showed' => time() + self::SHOW_TIME * 60,
                            'periods.'.$idx.'.ordered' => $time,
                           ]
                    ];
                Products::update($query, $conditions, ['atomic' => false]);

                self::next($cart['id']);
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
    public static function next($id) {

        $product = Products::find('first', ['conditions' => ['_id' => $id]]);
        $product->remain= $product->person;
        $product->save();

        // 如果是上架自动新增一期
        if($product->status == 2) {
            Periods::add($product->_id);
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
     * @return string   返回单个云购码
     */
    public static function code(&$codes, $person) {

    	$code = rand(1, $person);

        // time()

    	if(in_array($code, $codes))
    		$code = self::code($codes, $person);

        $codes[] = $code;

    	return $code;
    }

    /**
     * 获奖信息
     *
     * @param $time    string 最后购买时间
     * @param $$person integer 所需参与人数
     *
     * @return array   $data['code']    得奖号码
     *                 $data['results'] 计算结果
     *                 $data['total']   求和
     */
    public static function winnerInfo($time, $person) {

        $orders = Orders::find('all', ['conditions' => ['ordered' => ['$lte' => $time]], 'limit' => 100])->to('array');

        $total = 0;
        $results = [];
        foreach($orders as $order) {
            $time = $order['ordered'];
            $times = explode('.', $time);

            $total += date('His', $times[0]) . $times[1];
            $results[] = [
                'user_id'    => $order['user_id'],
                'ordered'    => $order['ordered'],
                'period_id'  => $order['period_id'],
                'product_id' => $order['product_id'],
                'count'      => $order['count'],
                ];
        }

        $totalFloat = floatval($total);
        $data = [
            'code'    => fmod($totalFloat,$person),
            'total'   => $total,
            'results' => $results
        ];

        return $data;
    }

    /**
     * 获得得奖的会员信息
     *
     * @param $productId mongoid 
     * @param $periodId  integer
     * @param $code      integer 
     *
     * @return user_id
     */
    public static function winnerUser($productId, $periodId, $code) {

        // 获奖的订单
        $mo = new MongoClient('orders');
        $rs = $mo->getConn()->find(['product_id' => $productId, 'period_id' => $periodId, 'codes' => $code ]);
        $order = iterator_to_array($rs);

        $order = array_shift($order);

        return $order['user_id'];
    }

}

?>