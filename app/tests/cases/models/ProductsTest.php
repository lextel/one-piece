<?php
namespace app\tests\cases\models;

use MongoRegex;
use app\models\Products;
use app\models\Periods;
use lithium\util\Validator;
use app\extensions\helper\MongoClient;
use app\tests\mocks\requests\MockProductsRequest as Request;
use app\tests\mocks\models\MockProductsModel as MockProducts;

class ProductsTest extends \lithium\test\Unit {

    private $_request;
    private $_product;
    private $_mockProduct;
    private $_rules;
    private $_id;

    public function setUp() {
        $this->_request = new Request();
        $this->_product = new Products();
        $this->_mockProduct = new MockProducts();
        $this->_rules = $this->_product->validates;
    }

    public function tearDown() {

        //$this->_product->remove(['_id' => $this->_id]);
    }

    public function test_beforeAdd() {

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


        // 交给beforeAdd处理
        $data = $this->_request->get('form');
        $newData = Products::_beforeAdd($data);
        $keys = ['cat_id', 'brand_id', 'title', 'feature', 'price', 'images', 'content', 'hits', 'status', 'showed', 'tag_id', 'created', 'person', 'remain', 'periods', 'shares', 'limits'];

        $this->assertEqual($keys, array_keys($newData));
    }


    /**
     * @depend test_beforeAdd
     */
    public function testAdd() {

        // 添加一条记录
        $data = $this->_request->get('form');
        $product = Products::add($data, true);
        $this->_id = $product->_id;

        // 查询这条记录是否存在
        $mo = new MongoClient();
        $count = $mo->count(['_id' => $this->_id]);
        $this->assertEqual(1, $count);

    }

    public function testHandleConditions() {

        // 测试状态条件
        $options = [];
        $options['status'] = 1;
        $newOptions = Products::handleConditions($options);
        $this->assertEqual(array_keys($options), array_keys($newOptions['conditions']));

        // 测试分类条件
        $options = [];
        $options['catId'] = 1;
        $newOptions = Products::handleConditions($options);
        $this->assertTrue(in_array('cat_id', array_keys($newOptions['conditions'])));

        // 测试品牌条件
        $options = [];
        $options['brandId'] = 1;
        $newOptions = Products::handleConditions($options);
        $this->assertTrue(in_array('brand_id', array_keys($newOptions['conditions'])));

        // 测试标题
        $options = [];
        $options['title'] = '商品标题';
        $newOptions = Products::handleConditions($options);
        $this->assertEqual(array_keys($options), array_keys($newOptions['conditions']));
    }

    public function testHandleSort() {

        // 为空
        $data = [
            'sort'    => '',
            'sortBy' => '',
        ];
        $options = Products::handleSort($data);
        $this->assertEqual($options['order'], ['sort' =>'showed', 'sortBy' => 'asc']);


        // 非排序字段
        $data = [
            'sort' => 'clicked',
            'sortBy'    => 'desc',
        ];
        $options = Products::handleSort($data);
        $this->assertEqual($options['order'], ['sort' => 'showed', 'sortBy' => 'asc']);

        // 揭晓时间顺序
        $data = [
            'sort' => 'showed',
            'sortBy'    => 'asc',
        ];
        $options = Products::handleSort($data);
        $this->assertEqual($options['order'], ['sort' => 'showed', 'sortBy' => 'asc']);

        // 揭晓时间倒序
        $data = [
            'sort'    => 'showed',
            'sortBy'  => 'desc',
        ];
        $options = Products::handleSort($data);
        $this->assertEqual($options['order'], ['sort' => 'showed', 'sortBy' => 'desc']);

        // 剩余人数顺序
        $data = [
            'sort' => 'remain',
            'sortBy'    => 'asc',
        ];
        $options = Products::handleSort($data);
        $this->assertEqual($options['order'], ['sort' => 'remain', 'sortBy' => 'asc']);

        // 剩余人数倒序
        $data = [
            'sort' => 'remain',
            'sortBy'    => 'desc',
        ];
        $options = Products::handleSort($data);
        $this->assertEqual($options['order'], ['sort' => 'remain', 'sortBy' => 'desc']);

        // 人气顺序
        $data = [
            'sort' => 'hits',
            'sortBy'    => 'asc',
        ];
        $options = Products::handleSort($data);
        $this->assertEqual($options['order'], ['sort' => 'hits', 'sortBy' => 'asc']);

        // 人气倒序
        $data = [
            'sort' => 'hits',
            'sortBy'    => 'desc',
        ];
        $options = Products::handleSort($data);
        $this->assertEqual($options['order'], ['sort' => 'hits', 'sortBy' => 'desc']);


        // 创建时间顺序
        $data = [
            'sort' => 'created',
            'sortBy'    => 'asc',
        ];
        $options = Products::handleSort($data);
        $this->assertEqual($options['order'], ['sort' => 'created', 'sortBy' => 'asc']);

        // 创建时间倒序
        $data = [
            'sort' => 'created',
            'sortBy'    => 'desc',
        ];
        $options = Products::handleSort($data);
        $this->assertEqual($options['order'], ['sort' => 'created', 'sortBy' => 'desc']);

        // 价格顺序
        $data = [
            'sort' => 'price',
            'sortBy'    => 'asc',
        ];
        $options = Products::handleSort($data);
        $this->assertEqual($options['order'], ['sort' => 'price', 'sortBy' => 'asc']);

        // 价格倒序
        $data = [
            'sort' => 'price',
            'sortBy'    => 'desc',
        ];
        $options = Products::handleSort($data);
        $this->assertEqual($options['order'], ['sort' => 'price', 'sortBy' => 'desc']);
    }

    public function testLists() {

        // 测试统计
        $options = ['getTotal' => true, 'title' => '测试商品'];
        $count = Products::lists($options);
        $this->assertEqual(1, $count);

        // 测试状态条件
        $options = ['status' => 0, 'title' => '测试商品', 'getTotal' => true];
        $count = Products::lists($options);
        $this->assertEqual(1, $count);

        // 测试分类条件
        $options = ['catId' => 99, 'title' => '测试商品', 'getTotal' => true];
        $count = Products::lists($options);
        $this->assertEqual(1, $count);

        // 测试品牌条件
        $options = ['brandId' => 99, 'title' => '测试商品', 'getTotal' => true];
        $count = Products::lists($options);
        $this->assertEqual(1, $count);

        // 测试排序
        $firstProduct = $this->_product;
        $firstId = $this->_id;

        // 添加两条商品
        $data = $this->_request->get('form');
        $secondProduct = Products::add($data, true);
        $secondId = $secondProduct->_id;

        $data = $this->_request->get('form');
        $thirdProduct = Products::add($data, true);
        $thirdId = $thirdProduct->_id;

        // 揭晓时间顺序排序
        $secondProduct->title = '测试商品2';
        $secondProduct->showed = time() + 100;
        $secondProduct->save();
        $base = [
            'limit' => 3,
            'title' => '测试商品',
            'page'  => 1,
        ];

        $options = [];
        $options = $base + $options;
        $list = Products::lists($options);
        $keys = array_keys($list);
        $this->assertEqual($secondId, end($keys));

        // 揭晓时间倒序
        $options = [
            'sort'   => 'showed',
            'sortBy' => 'desc',
        ];
        $options = $base + $options;
        $list = Products::lists($options);
        $keys = array_keys($list);
        $this->assertEqual($secondId, array_shift($keys));

        // 人气顺序排序
        $thirdProduct->hits = 1000;
        $thirdProduct->save();
        $secondProduct->hits = 500;
        $secondProduct->save();
        $options = [
            'sort' => 'hits',
            'sortBy' => 'asc',
        ];
        $options = $base + $options;
        $list = Products::lists($options);
        $keys = array_keys($list);
        $this->assertEqual($firstId, array_shift($keys));

        // 人气倒序排序
        $options = [
            'sort' => 'hits',
            'sortBy' => 'desc',
        ];
        $options = $base + $options;
        $list = Products::lists($options);
        $keys = array_shift($list);
        $this->assertEqual($thirdId, array_shift($keys));

        // 创建时间顺序排序
        $secondProduct->created = '2011-11-11 11:11:11';
        $secondProduct->save();
        $thirdProduct->created = '2012-12-12 12:12:12';
        $thirdProduct->save();
        $options = [
            'sort' => 'created',
            'sortBy' => 'asc',
        ];
        $options = $base + $options;
        $list = Products::lists($options);
        $keys = array_keys($list);
        $this->assertEqual($secondId, array_shift($keys));

        // 创建时间倒序排序
        $options = [
            'sort' => 'created',
            'sortBy' => 'desc',
        ];
        $options = $base + $options;
        $list = Products::lists($options);
        $keys = array_keys($list);
        $this->assertEqual($firstId, array_shift($keys));

        // 价格顺序排序
        $secondProduct->price = 1;
        $secondProduct->save();
        $thirdProduct->price = 9999;
        $thirdProduct->save();

        $options = [
            'sort' => 'price',
            'sortBy' => 'asc',
        ];
        $options = $base + $options;
        $list = Products::lists($options);
        $keys = array_keys($list);
        $this->assertEqual($secondId, array_shift($keys));

        // 价格倒序排序
        $options = [
            'sort' => 'price',
            'sortBy' => 'desc',
        ];
        $options = $base + $options;
        $list = Products::lists($options);
        $keys = array_keys($list);
        $this->assertEqual($thirdId, array_shift($keys));

        // 删除产品
        $this->_product->remove(['_id' => $this->_id]);
        $this->_product->remove(['_id' => $secondId]);
        $this->_product->remove(['_id' => $thirdId]);
    }

    public function test_afterLists() {
        $options = [
            'limit' => 1,
            'page'  => 1,
        ];

        $data = Products::lists($options);
        $products = Products::_afterLists($data);

        foreach($products as $r ) {
            $this->assertTrue(isset($r['id']), '列表UUID没有调用');
            $this->assertTrue(isset($r['periodId']), '列表期数ID没有调用');
            $this->assertTrue(isset($r['title']), '列表标题没有调用');
            $this->assertTrue(isset($r['price']), '价格没有调用');
            $this->assertTrue(isset($r['person']), '需要人次没有调用');
            $this->assertTrue(isset($r['remain']), '剩余人次没有调用');
            $this->assertTrue(isset($r['join']), '参与人次没有调用');
            $this->assertTrue(isset($r['width']), '宽度没有调用');
            $this->assertTrue(isset($r['percent']), '百分比没有调用');
            $this->assertTrue(isset($r['images']), '图片没有调用');
            $this->assertTrue(isset($r['tagClass']), '标签样式没有调用');
            $this->assertTrue( (isset($r['isUp']) && isset($r['isDown']) && isset($r['isDowning']) ), '列表状态没有调用');
        }
    }

    public function testEdit() {

        // 添加一条记录
        $data = $this->_request->get('form');
        $product = Products::add($data, true);
        $this->_id = $product->_id;

        // 编辑标题
        $title = '测试编辑标题';
        $product = Products::edit($this->_id, compact('title'));
        $this->assertEqual($title, $product->title);

        // 编辑特性
        $feature = '测试编辑特性';
        $product = Products::edit($this->_id, compact('feature'));
        $this->assertEqual($feature, $product->feature);

        // 编辑内容
        $content = '测试编辑内容';
        $product = Products::edit($this->_id, compact('content'));
        $this->assertEqual($content, $product->content);

        // 编辑分类
        $cat_id = 2;
        $product = Products::edit($this->_id, compact('cat_id'));
        $this->assertEqual($cat_id, $product->cat_id);

        // 编辑品牌
        $brand_id = 2;
        $product = Products::edit($this->_id, compact('brand_id'));
        $this->assertEqual($brand_id, $product->brand_id);

        // 编辑价格
        $price = 888;
        $product = Products::edit($this->_id, compact('price'));
        $this->assertEqual($price, $product->price);
        $this->assertEqual($price, $product->person);
        $this->assertEqual($price, $product->remain);

        // 编辑图片
        $images = ['/xxx/xxx/xxx.jpg'];
        $product = Products::edit($this->_id, compact('images'));
        foreach($product->images as $k => $v) {
            $this->assertEqual($images[$k], $v);
        }

        $this->_product->remove(['_id' => $this->_id]);
    }

    public function test_afterView() {

        // 添加一条记录
        $data = $this->_request->get('form');
        $product = Products::add($data, true);
        $this->_id = $product->_id;

        $this->_product->remove(['_id' => $this->_id]);
    }

    /*

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

        $keys = [
            'id', 'title', 'feature', 'content', 'images', 'tyepId',
            'orders', 'results', 'price', 'person', 'remain', 'join',
            'periodId', 'periodIds', 'percent', 'width', 'shareTotal',
            'showFeature', 'showWinner', 'showLimit', 'showFull',
            'showCounting', 'showResult', 'showActive', 'showSoldOut'
        ];

        $product = $this->_product->view($this->_id, 1);
        $onlyPeriod = $this->_product->_afterView($product, 1);
        $this->assertEqual($keys, array_keys($onlyPeriod));

        // 不显示上期获奖者
        $this->assertTrue(!$onlyPeriod['showWinner']);

        // 获得晒单数目
        $this->assertTrue(isset($onlyPeriod['shareTotal']));

        // 添加第二期揭晓第一期
        $data = [
            [
                'id'      => 1,
                'price'   => '99.00',
                'remain'  => '99',
                'person'  => '99',
                'code'    => '1000010',
                'user_id' => 1,
                'created' => time() - 84600,
                'showed'  => time() - 84600,
                'status'  => 2,
                'result'  => [
                    'user_id' => 1,
                    'product_id' => '',
                    'period_id' => '',
                    'ordered' => date('Y-m-d H:i:s.u'),
                ],
                'orders'  => [
                    'user_id' => 1,
                    'ip' => '127.0.0.1',
                    'codes' => ['100010'],
                    'ordered' => date('Y-m-d H:i:s.u'),
                ]
            ],
            [
                'id'      => 2,
                'price'   => '99.00',
                'remain'  => '99',
                'person'  => '99',
                'created' => time(),
                'showed'  => time(),
                'status'  => 1,
                'result'  => [],
                'orders'  => []
            ],
        ];
        $product->periods = $data;
        $product->status = 1;
        //$product->save();


        // 产品正在上架已经揭晓的期数
        $keys = [
            'id', 'periodId', 'title', 'feature', 'price', 'person', 'remain',
            'join', 'content', 'typeId', 'images', 'orders', 'results', 'periodIds',
            'percent', 'width', 'showFeature', 'showWinner', 'shareTotal',
            'showLimitTime', 'showTimer', 'soldOut', 'showResult', 'code', 'userId', 'ordered',
            'showed', 'showActive', 'activePeriod'
        ];

        $firstPeriod = $this->_product->_afterView($product, 1);
        $this->assertEqual($keys, array_keys($firstPeriod));
        $this->assertTrue($firstPeriod['showActive']);


        Products::remove(['_id' => $this->_id]);
    }
     */
}


?>
