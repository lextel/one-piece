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

        $cart = [
            'id' => (string)$this->_id,
            'periodId' => $periodId,
            'quantity' => $quantity
        ];

        // 添加此商品进购物车
        Carts::add($cart);
        $carts = Carts::get();
        $this->assertEqual($carts[0], ['title' => $data['title'], 'image' => $data['images'][0]] + $cart);

        // 再添加一次
        Carts::add($cart);
        $carts = Carts::get();
        $this->assertEqual($carts[0], ['title' => $data['title'], 'image' => $data['images'][0], 'id' => $this->_id, 'periodId' => 3, 'quantity' => 2]);

        // 添加一个别的商品
        $data['title'] = '购物车测试新商品';
        $newProduct = Products::create($data);
        $newProduct->save();

        $cart = [
            'id' => (string)$newProduct->_id,
            'periodId' => $periodId,
            'quantity' => 10
        ];
        Carts::add($cart);
        $carts = Carts::get();
        $this->assertEqual($carts[1], ['title' => $data['title'], 'image' => $data['images'][0]] + $cart);

        $this->_product->remove(['_id' => $this->_id]);
        $this->_product->remove(['_id' => $newProduct->_id]);
    }

    public function testModify() {
        

    }


    public function testGet() {

        // 清空购物车
        Session::write('cart', []);
        Session::write('myCart', []);

        // 添加一个商品
        $data = MockProducts::find('first');
        $product = Products::create($data);
        $product->save();
        $this->_id = $product->_id;

        $cart = [
            'id' => (string) $this->_id,
            'periodId' => '2',
            'quantity' => '1',
        ];
        Carts::add($cart);
        $carts = Carts::get();

        $this->assertEqual($carts[0], ['title' => $data['title'], 'image' => $data['images'][0]] + $cart);
    }

    public function testCount() {
        
        $carts = Carts::get();
        $this->assertEqual(count($carts), Carts::count());
    }

    public function testQuantity() {

        $carts = Carts::get();
        $quantity = 0;
        foreach($carts as $cart) {
            $quantity += $cart['quantity'];
        }

        $this->assertEqual($quantity, Carts::quantity());
    }

    /**
     * @depand testGet
     */
    public function testDel() {

        $count = Carts::count();
        Carts::del($this->_id, 2);
        $this->assertEqual($count-1, Carts::count());
        $this->_product->remove(['_id' => $this->_id]);
    }

    public function testPatchDel() {
    
    }



}
