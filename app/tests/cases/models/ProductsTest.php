<?php
namespace app\tests\cases\models;
use app\tests\mocks\requests\MockProductsRequest as Request;
use app\models\Products;
use lithium\util\Validator;

class ProductsTest extends \lithium\test\Unit {

    private $_request;
    private $_product;
    private $_rules;
    private $_id;

    public function setUp() {
        $this->_request = new Request();
        $this->_product = new Products();
        $this->_rules = $this->_product->validates;
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

    public function testAfterLists() {
        $options = ['limit' => 1]; // 列表只取一个产品
        $rs = Products::all($options);

        // 期数是否处理通过
        $afterData = Products::_afterLists($rs);
        foreach($afterData as $r ) {
            $this->assertTrue(isset($r['id']), '列表UUID没有调用');
            $this->assertTrue(isset($r['period_id']), '列表期数ID没有调用');
            $this->assertTrue(isset($r['title']), '列表标题没有调用');
            $this->assertTrue(isset($r['status']), '列表状态没有调用');
        }
    }

    public function test_afterView() {

        // 创建一条普通商品
        $data = [
            'cat_id'   => 1,
            'brand_id' => 1,
            'tag_id'   => 1,
            'type_id'  => 1,
            'title'    => 'test periods auto id',
            'price'    => '99.00',
            'person'   => '99',
            'remain'   => '99',
            'content'  => 'test content',
            'images'   =>['test.jpg'],
        ];

        $product = $this->_product->add($data);
        $this->_id = $product->_id;

        $info = [];
        $info['title']      = $product->title;
        $info['feature']    = $product->feature;
        $info['price']      = $product->price;
        $info['person']     = $product->person;
        $info['remain']     = $product->remain;
        $info['content']    = $product->content;
        $info['typeId']     = $product->type_id;
        $info['images']     = $product->images;
        $info['orders']     = [];
        $info['results']    = [];
        $info['period_ids'] = ['1'];
        $info['finalAward'] = false;
        $info['isShowed']   = false;
        $info['active']     = false;

        $product = $this->_product->view($this->_id, 1);

        $onlyPeriod = $this->_product->_afterView($product, 1);
        $this->assertEqual($info, $onlyPeriod);

        // 添加第二期
        $addPeriod = [
            [
                'id'      => 1,
                'price'   => '99.00',
                'remain'  => '99',
                'person'  => '99',
                'code'    => '1000010',
                'created' => date('Y-m-d H:i:s', strtotime(date(), '-1 days')),
                'showed'  => date('Y-m-d H:i:s', strtotime(date(), '-1 days')),
                'status'  => 1,
                'result'  => [
                    'user_id' => 1,
                    'product_id' => '',
                    'ordered' => date('Y-m-d H:i:s.u'),
                ],
                'orders'  => [
                    'user_id' => 1,
                    'product_id' => '',
                    'ordered' => date('Y-m-d H:i:s.u'),
                    'ip' => '127.0.0.1',
                    'total' => 1,
                ]
            ],
            [
                'id'      => 2,
                'price'   => '99.00',
                'remain'  => '99',
                'person'  => '99',
                'created' => date('Y-m-d H:i:s'),
                'showed'  => date('Y-m-d H:i:s'),
                'status'  => 1,
                'result'  => [],
                'orders'  => []
            ],
        ];
        $product->periods = $addPeriod;
        $product->save();

        $info = [];
        $info['title']      = $product->title;
        $info['feature']    = $product->feature;
        $info['price']      = $product->price;
        $info['person']     = $product->person;
        $info['remain']     = $product->remain;
        $info['content']    = $product->content;
        $info['typeId']     = $product->type_id;
        $info['images']     = $product->images;
        $info['orders']     = [];
        $info['results']    = [];
        $info['period_ids'] = ['2', '1'];
        $info['finalAward'] = false;
        $info['isShowed']   = false;
        $info['active']     = false;


        $firstPeriod = $this->_product_afterView($this->_id, 2);
        $this->assertEqual($info, $firstPeriod);

    }
}

?>