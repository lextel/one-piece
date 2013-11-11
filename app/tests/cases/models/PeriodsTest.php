<?php
/**
 *
 *
 * 数据存于products表的periods字段中
 * 数据形式:
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
namespace app\tests\cases\models;

use app\models\Periods;

class PeriodsTest extends \lithium\test\Unit {

	public function setUp() {}

	public function tearDown() {}
}

?>