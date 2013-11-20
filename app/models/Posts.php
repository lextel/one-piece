<?php

namespace app\models;

class Posts extends \lithium\data\Model {

    /**
     * _id    
     * from_id          所属会员ID
     * to_id            发送至会员ID
     * parent_id        父级ID
     * product_id       产品ID
     * period_id        期数ID
     * title            标题
     * content          内容
     * images           图片
     * comment          评论
     * good             赞
     */
    protected $_meta = array(
        'connection' => 'posts',
    );

	public $validates = array();

    /**
     * 我的晒单
     *
     * @param $userId integer 会员ID
     * @param $typeId integer 类型 1 已晒单 2未晒单
     *
     * @return array  $data['productId']
     *                $data['title']
     *                $data['periodId']
     *                $data['userId']
     */
    public static function myShare($userId) {

        $products = Products::find('all', ['conditions' => ['periods.user_id' => $userId]])->to('array');

        $shares = [];
        foreach($products as $product) {
            foreach($product['periods'] as $period) {
                if(isset($period['user_id']) && $period['user_id'] == $userId) {
                    $data = [
                        'productId' => $product['_id'],
                        'title'     => $product['title'],
                        'periodId'  => $period['id'],
                        'userId'    => $period['user_id'],
                    ];

                    $shares[] = $data;
                }
            }
        }

        return $shares;
    }
}

?>
