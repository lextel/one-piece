<?php

namespace app\models;

use app\models\Carts;
use app\models\Periods;
use app\models\Products;
use app\extensions\helper\User;
use app\extensions\helper\MongoClient;

class Orders extends \lithium\data\Model {

    const SHOW_TIME = 5;    // 倒计时揭晓时间

    /**
     * mongodb orders数据结构
     *
     * @var array
     */
    protected $_schema = [
        '_id'        => ['type' => 'id'],             // UUID
        'user_id'    => ['type' => 'string'],         // 所属会员ID
        'product_id' => ['type' => 'string'],         // 商品ID
        'period_id'  => ['type' => 'integer'],        // 期数ID
        'ip'         => ['type' => 'string'],         // 云购IP
        'codes'      => ['type' => 'array'],          // 云购码 
        'count'      => ['type' => 'integer'],        // 云购数量
        'created'    => ['type' => 'string'],         // 时间（到毫秒）
    ];


	/**
     * 下订单
     *
     * @return void
     */
    public static function order() {

    	$carts = Carts::get(true);
        $info = new User;
        $userId = $info->id();

        $user = Users::find('first', ['conditions' => ['_id' => $userId]]);

        $total = 0;
        foreach($carts as $cart) {
            $total += $cart['quantity'];
        }

        if($user->credits < $total * CREDITS) {
            die('积分不足请充值');
        }

    	foreach($carts as $cart) {
            $time = microtime(true);

    		$conditions = ['_id' => $cart['id']];
    		$period = Periods::period($cart['id'], $cart['periodId']);

            $idx = $cart['periodId'] - 1;

    		// 不满人直接生成号码
			if($period['remain'] - $cart['quantity'] > 0) {
                $myCodes = array_slice($period['tickets'], 0, $cart['quantity']);
                $quantity = $cart['quantity'];
			} else { // 满人生成号码
                $myCodes = array_slice($period['tickets'], 0, $period['remain']);
                $quantity = $period['remain'];
            }


            // 写入orders表
            $data = [
                'user_id'    => $userId,
                'product_id' => $cart['id'],
                'period_id'  => $cart['periodId'],
                'ordered'    => $time,
                'ip'         => getIp(),
                'codes'      => $myCodes,
                'count'      => $quantity,
            ];
            $order = Orders::create($data);
            $order->save();

            // 更新剩余数量
            $query = [
                '$inc' => [
                    'remain' => -$quantity, 
                    'periods.'.$idx.'.remain' => -$quantity
                    ], 
                '$set' => [
                    'periods.'.$idx.'.tickets' =>  array_slice($period['tickets'], $quantity, $period['remain'])
                    ]
                ];

            Products::update($query, $conditions, ['atomic' => false]);

            $user->credits = $user->credits - $quantity * CREDITS;
            $user->save();

            // 如果超过人数
            if($period['remain'] - $cart['quantity'] <= 0) {

                // 写入揭晓时间
                $query = [
                    '$set' => [
                        'periods.'.$idx.'.showed' => time() + self::SHOW_TIME * 60,
                        'periods.'.$idx.'.ordered' => $time,
                    ]
                ];
                Products::update($query, $conditions, ['atomic' => false]);

                // 结束这一期
                $product = Products::find('first', ['conditions' => $conditions]);
                $product->remain= $product->person;
                $product->save();

                // 开启新一期
                $leave = $cart['quantity'] - $period['remain'];
                if($product->status == 2) {
                    Periods::add($product->_id);
                    
                    // 超额部分购买下一期 
                    if($leave > 0) {

                        $user->credits = $user->credits - $leave * CREDITS;
                        $user->save();

                        $time = microtime(true);
                        $nextPeriod = Periods::period($cart['id'], $cart['periodId']);
                        $myCodes = array_slice($nextPeriod['tickets'], 0, $leave);
                        $idx++;

                        $data = [
                            'user_id'    => $userId,
                            'product_id' => $cart['id'],
                            'period_id'  => $cart['periodId']+1,
                            'ordered'    => $time,
                            'codes'      => $myCodes,
                            'count'      => $leave,
                        ];
                        $order = Orders::create($data);
                        $order->save();

                        // 更新剩余数量
                        $query = [
                            '$inc' => [
                                'remain' => -$leave, 
                                'periods.'.$idx.'.remain' => -$leave
                                ], 
                            '$set' => [
                                'periods.'.$idx.'.tickets' =>  array_slice($nextPeriod['tickets'], $leave, $nextPeriod['remain']),
                                'periods.'.$idx.'.hits' => $product->hits
                                ]
                            ];

                        Products::update($query, $conditions, ['atomic' => false]);
                    }
                }

                // 如果正在下价更新为下架状态
                if($product->status == 1) {
                    $product->status = 0;
                    $product->save();

                    if($leave > 0) {
                        $user->credits = $user->credits + $leave * CREDITS;
                        $user->save();
                    }
                }
            }
    	}

        Carts::clear();
    }

    /**
     * 商品详情页购买调用
     *
     * @return array
     */
    public static function view($productId, $periodId) {

        $page = 1;
        $limit = 6;
        $order = ['_id' => 'desc'];

        $conditions = ['product_id' => (string)$productId, 'period_id' => $periodId];
        $orders = Orders::find('all', compact('limit', 'page', 'conditions', 'order'))->to('array');

        foreach($orders as $k => $order) {
            $orders[$k]['user'] = Users::profile($order['user_id']);
        }

        return $orders;

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

            $userModel = new Users;
            $user = $userModel->profile($order['user_id']);
            $product = Products::find('first', ['conditions' => ['_id' => $order['product_id']]]);

            $results[] = [
                'user_id'    => $order['user_id'],
                'title'       => $product->title,
                'nickname'   => $user['nickname'],
                'avatar'     => $user['avatar'],
                'ordered'    => $order['ordered'],
                'ip'         => $order['ip'],
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
     * @param $productId mongoid 商品ID
     * @param $periodId  integer 期数
     * @param $code      integer 中奖号码
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

    /**
     * 获取某期的云购次数
     *
     * @param $productId mongoid  商品ID
     * @param $periodId  integer  期数
     * @param $userId    mongoid  会员ID
     *
     */
    public function countByPeriod($productId, $periodId, $userId) {
        $mo = new MongoClient('orders');
        $rs = $mo->getConn()->find(['product_id' => $productId, 'period_id' => $periodId, 'user_id' => $userId ]);

        $orders = iterator_to_array($rs);

        $total = 0;
        foreach($orders as $order) {
            $total += $order['count'];
        }

        return $total;
    }

    /**
     * 正在云购
     *
     * @return array
     */
    public function ordering() {

        $mo = new MongoClient('orders');
        $rs = $mo->getConn()->find([], ['user_id', 'period_id', 'product_id', 'ordered'])->limit(12)->sort(['ordered' => 1]);
        $orders = iterator_to_array($rs);

        // 填充附加信息
        $userModel = new Users;
        $productModel = new Products;
        foreach($orders as $k => $order) {
            $user = $userModel->profile($order['user_id']);
            $orders[$k]['nickname'] =  $user['nickname'];
            $orders[$k]['avatar'] =  $user['avatar'];
            $orders[$k]['title'] =  $productModel->getTitleById($order['product_id']);
        }

        return $orders;
    }


}

?>