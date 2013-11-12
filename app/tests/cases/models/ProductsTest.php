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

    public function test_preList() {

        $data = [
            'cat_id' => 0,
            'brand_id' => 0
        ];
        $options = Products::_perLists($data);
        $this->assertTrue(empty($options['conditions']));

        $data = ['cat_id' => 1];
        $options = Products::_perLists($data);
        $this->assertEqual($data, $options['conditions']);

        $data = ['brand_id' => 1];
        $options = Products::_perLists($data);
        $this->assertEqual($data, $options['conditions']);

        $data = [
            'cat_id' => 1,
            'brand_id' => 2
        ];
        $options = Products::_perLists($data);
        $this->assertEqual($data, $options['conditions']);
    }

    public function testhandleOrderBy() {

        $data = [
            'orderBy' => '',
            'sort'    => '',
        ];
        $options = $this->_product->handleOrderBy($data);
        $this->assertEqual($options['order'], ['showed' => 'asc']);


        $data = [
            'orderBy' => 'clicked',
            'sort'    => 'desc',
        ];
        $options = $this->_product->handleOrderBy($data);
        $this->assertEqual($options['order'], ['showed' => 'asc']);

        $data = [
            'orderBy' => 'remain',
            'sort'    => 'zesc',
        ];
        $options = $this->_product->handleOrderBy($data);
        $this->assertEqual($options['order'], ['remain' => 'desc']);

        $data = [
            'orderBy' => 'hit',
            'sort'    => 'desc',
        ];
        $options = $this->_product->handleOrderBy($data);
        $this->assertEqual($options['order'], ['hit' => 'desc']);

        $data = [
            'orderBy' => 'remain',
            'sort'    => 'asc',
        ];
        $options = $this->_product->handleOrderBy($data);
        $this->assertEqual($options['order'], ['remain' => 'asc']);

        $data = [
            'orderBy' => 'created',
            'sort'    => 'asc',
        ];
        $options = $this->_product->handleOrderBy($data);
        $this->assertEqual($options['order'], ['created' => 'asc']);

        $data = [
            'orderBy' => 'price',
            'sort'    => 'asc',
        ];
        $options = $this->_product->handleOrderBy($data);
        $this->assertEqual($options['order'], ['price' => 'asc']);

        $data = [
            'orderBy' => 'showed',
            'sort'    => 'desc',
        ];
        $options = $this->_product->handleOrderBy($data);
        $this->assertEqual($options['order'], ['showed' => 'desc']);
    }
}

?>
