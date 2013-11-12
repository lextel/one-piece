<?php
/**
 * @author  weelion<weelion@qq.com>
 * @version 1.0
 *      periods['_id']          // mongo 自带 id
 *      periods['id']           // 自增ID
 *      periods['price']        // 价格
 *      periods['person']       // 需要人次
 *      periods['remain']       // 剩余人次
 *      periods['code']         // 中奖号码
 *      periods['created']      // 开始时间
 *      periods['showed']       // 揭晓时间
 *      periods['status']       // 状态 0进行中 1已揭晓
 *      periods['result']       // 计算结果记录 详见results
 *      periods['order']        // 参与者记录 详见orders model 
 */

namespace app\models;

class Periods extends \lithium\data\Model {

    protected $_schema = [
        'id' => ['type' => 'id', 'length' => 10],
        'price' => ['type' => 'float', 'length' => 10, 'null' => false, 'default' => 0],
        'person' => ['type' => 'integer', 'length' => 10, 'null' => false, 'default' => 0],
        'remain' => ['type' => 'integer', 'length' => 10, 'null' => false, 'default' => 0],
        'hit' => ['type' => 'integer', 'length' => 10, 'null' => false, 'default' => 0],
        'code' => ['type' => 'string', 'length' => 20],
        'user_id' => ['type' => 'integer', 'length' => 10],
        'showed' => ['type' => 'integer', 'length' => 10, 'null' => false, 'default' => 0],
        'created' => ['type' => 'integer', 'length' => 10, 'null' => false, 'default' => 0],
        'status' => ['type' => 'integer', 'length' => 2],
        ];

	public $validates = array();

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