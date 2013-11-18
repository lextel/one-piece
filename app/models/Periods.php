<?php
/**
 * @author  weelion<weelion@qq.com>
 * @version 1.0
 */

namespace app\models;

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
        'ordered' => ['type' => 'date'],                                                                   // 中奖购买时间
        'results' => ['type' => 'array'],                                                                  // 中奖计算条件
        'orders'  => ['type' => 'array'],                                                                  // 本期订单
        'created' => ['type' => 'date'],                                                                   // 开始时间
        'showed'  => ['type' => 'date'],                                                                   // 揭晓时间
        'status'  => ['type' => 'integer', 'length' => 2],                                                 // 本期状态 0进行中，1 计算中， 2已揭晓
        ];

    public $validates = array();

    /**
     * 初始化第一期
     *
     * @param $data array 产品数组
     *
     * @return array
     */
    public static function init($data) {

        $period = [];
        $period['id']      = 1;
        $period['price']   = $data['price'];
        $period['person']  = $data['person'];
        $period['remain']  = $data['remain'];
        $period['hits']    = 0;
        $period['code']    = '';
        $period['created'] = strtotime($data['created']);
        $period['showed']  = '';
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

    /**
     * 获取一期信息
     *
     * @param $periods   object  所有期
     * @param $periodId integer 期数ID
     *
     * @return array
     */
    public static function period($periods, $periodId) {

        $data = [];
        $periodIds = [];
        $total = count($periods);
        foreach($periods as $period) {
            $data[$period->id]['id']      = $period->id;
            $data[$period->id]['price']   = $period->price;
            $data[$period->id]['person']  = $period->person;
            $data[$period->id]['remain']  = $period->remain;
            $data[$period->id]['hits']    = $period->hits;
            $data[$period->id]['code']    = $period->code;
            $data[$period->id]['user_id'] = $period->user_id;
            $data[$period->id]['ordered'] = $period->ordered;
            $data[$period->id]['results'] = $period->results ? $period->results : [];
            $data[$period->id]['orders']  = $period->orders ? $period->orders : [];
            $data[$period->id]['created'] = $period->created;
            $data[$period->id]['showed']  = $period->showed;
            $data[$period->id]['status']  = $period->status;

            // 期数处理
            $ids['id'] = $period->id;

            if($period->id == $periodId) {
                $ids['class'] = 'period_ArrowCur';
                $ids['active'] = false;
            } else if($period->id == $total) {
                $ids['class'] = 'period_Ongoing';
                $ids['active'] = true;
            } else {
                $ids['class'] = false;
                $ids['active'] = false;
            }

            $periodIds[] = $ids;
        }

        $periodIds = array_reverse($periodIds);

        return [$data[$periodId], $periodIds];
    }
}

?>
