<?php
 /**
  * 限时揭晓
  *
  * @author: weelion<weelion@qq.com>
  * @version: 1.0
  */
namespace app\models;

/**
 * schema说明：
 *
 * $limits['id']      // 期数ID
 * $limits['showed']  // 揭晓时间
 */
class Limits extends \lithium\data\Model {

	public $validates = array();

    /**
     * 获取限时的信息
     *
     * @param $productId mongoid 商品ID
     * @param $periodId  integer 期数ID
     *
     * @return intger   0 为不是限时 否则返回揭晓时间戳
     */
    public static function getLimit($productId, $periodId) {


    }

    /**
     * 获取某天的揭晓信息
     *
     * @param $date string 日期 'Y-m-d'
     *
     * return array
     */
    public static function byDate($date) {

    }



}

?>
