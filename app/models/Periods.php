<?php
/**
 * @author  weelion<weelion@qq.com>
 * @version 1.0
 */

namespace app\models;

use app\extensions\helper\MongoClient;

class Periods extends \lithium\data\Model {

    /**
     * periods 数据库结构
     */
    protected $_schema = [
        'id'      => ['type' => 'id', 'length' => 10],                                                     // 自增ID
        'price'   => ['type' => 'float', 'length' => 10, 'null' => false, 'default' => 0],                 // 价格
        'person'  => ['type' => 'integer', 'length' => 10, 'null' => false, 'default' => 0],               // 需要人次
        'remain'  => ['type' => 'integer', 'length' => 10, 'null' => false, 'default' => 0],               // 剩余人次
        'hits'    => ['type' => 'integer', 'length' => 10, 'null' => false, 'default' => 0],               // 人气
        'code'    => ['type' => 'string', 'length' => 20],                                                 // 中奖号码
        'user_id' => ['type' => 'integer', 'length' => 10],                                                // 中奖会员ID
        'ordered' => ['type' => 'string'],                                                                   // 中奖购买时间
        'results' => ['type' => 'array'],                                                                  // 中奖计算条件
        'orders'  => ['type' => 'array'],                                                                  // 本期订单
        'created' => ['type' => 'date'],                                                                   // 开始时间
        'showed'  => ['type' => 'date'],                                                                   // 揭晓时间
        'status'  => ['type' => 'integer', 'length' => 2],                                                 // 本期状态 0进行中，1 计算中， 2已揭晓
        ];

    public $validates = array();


    /**
     * 添加新一期
     *
     * @param $id mongoid 商品ID
     *
     * @return boolean
     */
    public static function add($id) {

        $fields = ['price' ,'person', 'remain'];
        $conditions = ['_id' => $id];
        $product = Products::find('first', ['conditions' => $conditions, 'fields' => $fields])->to('array');

        $period = [];
        $period['id'] = self::autoId($id);
        $period['price'] = $product['price'];
        $period['person'] = $product['person'];
        $period['remain'] = $product['remain'];
        // $period['orders'] = [];
        $period['results'] = [];
        $period['hits']  = 0;
        $period['code'] = '';
        $period['user_id'] = 0;
        $period['ordered'] = 0;
        $period['created'] = time();
        $period['showed'] = 0;
        $period['status'] = 0;

        $query = ['$push' => ['periods' => $period]];
        $conditions = ['_id' => $id];

        return Products::update($query, $conditions, ['atomic' => false]);
    }

    /**
     * 更新期数内容
     *
     * @param $id        mongoid 商品ID
     * @param $periodId  integer 期数ID
     * @param $data      array   更新的数据
     *
     * @return boolean
     */
    public static function update($id, $periodId, $data) {

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

        $mo = new MongoClient();
        $periods = $mo->find(['_id' => $productId], ['periods', '_id' => 0]);
        $periods = array_shift($periods);

        return $periods['periods'];
    }

    /**
     * 获取期数列表
     *
     * @param $periods array   期数列表
     * @param $periodId integer 当前ID
     * @param $output  boolean 是否是输出
     *
     * @return array
     */
    public static function periodIds($periods, $periodId, $output = false) {

        $periodIds = [];
        $total = count($periods);
        foreach ($periods as $k => $period) {
            $periodIds[$k]['id'] = $period['id'];

            if($output) {
                if($period['id'] == $periodId) {
                    $periodIds[$k]['class'] = 'period_ArrowCur';
                    $periodIds[$k]['active'] = false;
                } else if($period['id'] == $total) {
                    $periodIds[$k]['class'] = 'period_Ongoing';
                    $periodIds[$k]['active'] = true;
                } else {
                    $periodIds[$k]['class'] = false;
                    $periodIds[$k]['active'] = false;
                }
            }
        }

        if($output) {
            $periodIds = array_reverse($periodIds);

            foreach($periodIds as $k => $v) {
                if(($k+1)%9 == 0) {
                    $periodIds[$k]['separator'] = true;
                } else {
                    $periodIds[$k]['separator'] = false;
                }
            }
        }


        return $periodIds;
    }


    /**
     * 获取一期信息
     *
     * @param $productId mongoid  商品ID
     * @param $periodId integer   期数ID
     *
     * @return array
     */
    public static function period($productId, $periodId = 0) {

        $mo = new MongoClient();
        $offset = $periodId - 1;
        $period = $mo->find(['_id' => $productId], ['periods' => ['$slice' => [$offset, 1]]]);
        $period = array_shift($period);

        return $period['periods'][0];
    }
}
?>
