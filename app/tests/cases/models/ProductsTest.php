<?php
namespace app\tests\cases\models;
use app\tests\mocks\requests\MockProductsRequest as Request;
use app\models\Products;
use lithium\util\Validator;

class ProductsTest extends \lithium\test\Unit {

    private $_request;
    private $_product;
    private $_rules;

    public function setUp() {
        $this->_request = new Request();
        $this->_product = new Products();
        $this->_rules = $this->_product->validates;

        Validator::add('array', function($value) {
            return is_array($value);
        });

    }

    public function tearDown() {}

    public function test_perAdd() {

        // 数据验证通过
        $data = $this->_request->get('form');
        $rs = Validator::check($data, $this->_rules);
        $this->assertTrue(empty($rs), '一般验证');
        $this->assertTrue(Validator::isArray($data['images']));

        // 数据验证不通过提示
        $data = $this->_request->get('errorForm');

        $rs = Validator::check($data['emptyCatId'], $this->_rules); 
        $this->assertEqual($rs['cat_id'][0], '请选择分类');

        $rs = Validator::check($data['emptyTitle'], $this->_rules);
        $this->assertEqual($rs['title'][0], '请填写商品名');

        $rs = Validator::check($data['errorPrice'], $this->_rules);
        $this->assertEqual($rs['price'][0], '价格格式不正确');

        $rs = Validator::check($data['emptyContent'], $this->_rules);
        $this->assertEqual($rs['content'][0], '请填写商品详情');

        $this->assertFalse(Validator::isArray($data['errorImages']['images']));

    }

}

?>
