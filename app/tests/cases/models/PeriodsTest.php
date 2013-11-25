<?php
/**
 * 数据存于products表的periods字段中
 * 数据形式:
 *      periods['id']           // 自增ID
 *      periods['price']        // 价格
 *      periods['person']       // 需要人次
 *      periods['remain']       // 剩余人次
 *      periods['code']         // 中奖号码
 *      periods['created']      // 开始时间
 *      periods['showed']       // 揭晓时间
 *      periods['status']       // 状态 0进行中 1计算中 2已揭晓
 *      periods['results']      // 计算结果记录 详见results
 *      periods['type_id']      // 类型
 *      periods['orders']       // 参与者记录 详见orders model
 */
namespace app\tests\cases\models;

use app\models\Products;
use app\models\Periods;
use app\tests\mocks\models\MockProductsModel as MockProducts;

class PeriodsTest extends \lithium\test\Unit {
    private $_id;

	public function setUp() {}

	public function tearDown() {

        Products::remove(['_id' => $this->_id]);
    }

    public function testAdd() {

        $info = MockProducts::find('first');
        $data=[];
        $data['title'] = $info['title'];
        $data['feature'] = $info['feature'];
        $data['cat_id'] = $info['cat_id'];
        $data['brand_id'] = $info['brand_id'];
        $data['price']   = $info['price'];
        $data['images'] = $info['images'];
        $data['content'] = $info['content'];

        $product = Products::add($data);

        // 已经添加
        $this->assertEqual(1, count($product->periods));

        $this->_id = $product->_id;
    }

    /**
     * @depends testAdd
     */
    public function testAutoId() {

        // 获得下个期数ID
        $periodId = Periods::autoId($this->_id);
        $this->assertEqual(2, $periodId);

        // 添加两期
        $periodModel = new Periods();
        $periodModel->add($this->_id);
        $periodModel->add($this->_id);

        $periodId = Periods::autoId($this->_id);
        $this->assertEqual(4, $periodId);
    }
}

?>
