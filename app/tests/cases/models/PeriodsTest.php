<?php
/**
 *
 *
 * 数据存于products表的periods字段中
 * 数据形式:
 *      periods['id']           // 自增ID
 *      periods['price']        // 价格
 *      periods['person']       // 需要人次
 *      periods['remain']       // 剩余人次
 *      periods['code']         // 中奖号码
 *      periods['created']      // 开始时间
 *      periods['showed']       // 揭晓时间
 *      periods['status']       // 状态 0进行中 1已揭晓
 *      periods['results']       // 计算结果记录 详见results
 *      periods['orders']        // 参与者记录 详见orders model
 */
namespace app\tests\cases\models;

use app\models\Products;
use app\models\Periods;

class PeriodsTest extends \lithium\test\Unit {
    private $_id;

	public function setUp() {}

	public function tearDown() {

        Products::remove(['_id' => $this->_id]);
    }

    public function testAutoId() {

        // 新建一条产品
        $data = ['cat_id' => 1, 'title' => 'test periods auto id', 'price' => '99.99', 'content' => 'test content', 'images'=>['test.jpg']];
        $product = Products::create($data);
        $product->save();
        $this->_id = $product->_id;

        // 获得一个期数ID
        $firstId = Periods::autoId($this->_id);

        // 写入一期并获得第二个期数ID
        $product->periods = [['id' => $firstId]];
        $product->save();
        $secondId = Periods::autoId($this->_id);
        $this->assertEqual($firstId+1, $secondId);

        // 写入二期获得第三个期数ID
        $product->periods = [['id' => $firstId],['id' => $secondId]];
        $product->save();
        $thirdId = Periods::autoId($this->_id);
        $this->assertEqual($secondId+1, $thirdId);

        $this->assertEqual($thirdId,Periods::autoId($this->_id));
    }
}

?>