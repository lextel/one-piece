<?php
/**
 * @author  weelion<weelion@qq.com>
 * @version 1.0
 */

namespace app\models;

class Periods extends \lithium\data\Model {


	public $validates = array();

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