<?php
/**
 * @author  weelion<weelion@qq.com>
 * @version 1.0
 */

namespace app\models;

class Periods extends \lithium\data\Model {

    /**
     *      period['id']           // 自增ID
     *      period['price']        // 价格
     *      period['person']       // 需要人次
     *      period['remain']       // 剩余人次
     *      period['hit']          // 人气
     *      period['code']         // 中奖号码
     *      period['user_id']      // 中奖会员
     *      period['created']      // 开始时间
     *      period['showed']       // 揭晓时间
     *      period['status']       // 状态 0进行中 1已揭晓
     *      period['results']      // 计算结果记录 详见results
     *      period['orders']       // 参与者记录 详见orders model
     */
    protected $_schema = [
        'id'      => ['type' => 'id', 'length' => 10],
        'price'   => ['type' => 'float', 'length' => 10, 'null' => false, 'default' => 0],
        'person'  => ['type' => 'integer', 'length' => 10, 'null' => false, 'default' => 0],
        'remain'  => ['type' => 'integer', 'length' => 10, 'null' => false, 'default' => 0],
        'hit'     => ['type' => 'integer', 'length' => 10, 'null' => false, 'default' => 0],
        'code'    => ['type' => 'string', 'length' => 20],
        'user_id' => ['type' => 'integer', 'length' => 10],
        'results' => ['type' => 'array'],
        'orders'  => ['type' => 'array'],
        'showed'  => ['type' => 'date'],
        'created' => ['type' => 'date'],
        'status'  => ['type' => 'integer', 'length' => 2],
        ];

    public $validates = array();

    /**
     * 初始化第一期
     *
     * @param $data array 产品数组
     *
     * @return array
     */
    public static function init(&$data) {

        $period = [];
        $period['id']      = 1;
        $period['price']   = $data['price'];
        $period['person']  = $data['person'];
        $period['remain']  = $data['remain'];
        $period['hit']     = $data['hit'];
        //$period['code']    = isset($data['code']) ? $data['code'] : '';
        $period['created'] = $data['created'];
        //$period['showed']  = isset($data['showed']) ? $data['showed'] : '';
        $period['status']  = 0;

        $data['periods'][] = $period;

        return $data;
    }

    /**
     * 获取预插入ID
     *
     * @param $productId string 商品ID
     *
     * @return int 自增的ID
     */
    public static function autoId($productId) {

        $product = Products::first(['conditions' => ['_id' => $productId]]);
        if(empty($product) || empty($product->periods)) {
            $id = 1;
        } else {
            $id = count($product->periods) + 1;
        }

        return $id;
    }

    /**
     * 获取指定产品期数信息
     *
     * @param: $productId init 产品ID
     *
     * @return array
     */
    public static function periods($productId) {

        return Products::find('all',['conditions' => ['id' => $productId], 'fields' => 'periods']);
    }
}

?>
