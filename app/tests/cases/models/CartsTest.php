<?php
namespace app\tests\cases\models;

use app\models\Carts;
use app\models\Products;
use lithium\storage\Session;
use app\extensions\helper\MongoClient;
use app\tests\mocks\models\MockProductsModel as MockProducts;

class CartsTest extends \lithium\test\Unit {

    private $_product;
    private $_id;

    public function setUp() {

        $this->_product = new Products();
    }

	public function tearDown() {}

    public function testAdd() {
        // 清空购物车
        Session::write('cart', []);
        Session::write('myCart', []);

        // 添加一个商品
        $data = MockProducts::find('first');
        $product = Products::create($data);
        $product->save();

        $this->_id = (string)$product->_id;
        $periodId = 3;
        $quantity = 1;

        $data = [
            'id' => (string)$this->_id,
            'periodId' => $periodId,
            'quantity' => $quantity
        ];

        // 添加此商品进购物车
        Carts::add($data);
        $carts = Carts::get();
        $this->assertEqual($carts[0], $data);

        // 再添加一次
        Carts::add($data);
        $carts = Carts::get();
        $this->assertEqual($carts[0], ['id' => $this->_id, 'periodId' => 3, 'quantity' => 2]);

        // 添加一个别的商品
        $data['id'] = 'xxxx';
        $data['quantity'] = 10;
        Carts::add($data);
        $carts = Carts::get();
        $this->assertEqual($carts[1], ['id' => 'xxxx', 'periodId' => 3, 'quantity' => 10]);

        $this->_product->remove(['_id' => $this->_id]);
    }


    public function testGet() {
        // 清空购物车
        Session::write('cart', []);
        Session::write('myCart', []);

        $data = [
            'id' => 'xxxxx',
            'periodId' => '2',
            'quantity' => '1',
        ];
        Carts::add($data);
        $carts = Carts::get();

        $this->assertEqual($carts[0], $data);
    }

    public function testClear() {}

}
