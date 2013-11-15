<?php
/**
 * @author  weelion<weelion@qq.com>
 * @version 1.0
 */

namespace app\models;

class Periods extends \lithium\data\Model {

    /**
     *      periods['id']           // 自增ID
     *      periods['price']        // 价格
     *      periods['person']       // 需要人次
     *      periods['remain']       // 剩余人次
     *      periods['hit']          // 人气
     *      periods['code']         // 中奖号码
     *      periods['created']      // 开始时间
     *      periods['showed']       // 揭晓时间
     *      periods['status']       // 状态 0进行中 1已揭晓
     *      periods['result']       // 计算结果记录 详见results
     *      periods['order']        // 参与者记录 详见orders model
     */
    protected $_schema = [
        'id' => ['type' => 'id', 'length' => 10],
        'price' => ['type' => 'float', 'length' => 10, 'null' => false, 'default' => 0],
        'person' => ['type' => 'integer', 'length' => 10, 'null' => false, 'default' => 0],
        'remain' => ['type' => 'integer', 'length' => 10, 'null' => false, 'default' => 0],
        'hit' => ['type' => 'integer', 'length' => 10, 'null' => false, 'default' => 0],
        'code' => ['type' => 'string', 'length' => 20],
        'user_id' => ['type' => 'integer', 'length' => 10],
        'result' => ['type' => 'array'],
        'order' => ['type' => 'array'],
        'showed' => ['type' => 'date'],
        'created' => ['type' => 'date'],
        'status' => ['type' => 'integer', 'length' => 2],
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
        $data['periods']['id'] = 1;
        $data['periods']['price'] = $data['price'];
        $data['periods']['person'] = $data['person'];
        $data['periods']['remain'] = $data['remain'];
        $data['periods']['hit']  = $data['hit'];
        $data['periods']['created'] = $data['created'];
        $data['periods']['status'] = 0;

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