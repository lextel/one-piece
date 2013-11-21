<?php

namespace app\tests\cases\models;

use app\models\Posts;
use app\models\Products;

class PostsTest extends \lithium\test\Unit {
    private $_userId;
    private $_unsetUserId;
    private $_product;

	public function setUp() {
        $this->_userId = USER_ID;
        $this->_unsetUserId = UNSET_USER_ID;
        $this->_product = new Products();

    }

	public function tearDown() {}

    public function testShares() {

    }

    public function testMyShare() {

        $shares = Posts::myShare($this->_userId);

        if(count($shares)) {
            $keys = ['productId', 'images','title', 'periodId', 'userId'];
            $dataKeys = array_keys($shares[0]);
            $this->assertEqual($keys, $dataKeys);
        }

        // 未晒单
        $shares = Posts::myShare(['userId' => $this->_userId, 'typeId' => 2, 'getTotal' => true]);
        $this->assertEqual(1, $shares);

        // 空用户 已晒单
        $shares = Posts::myShare(['userId' => $this->_unsetUserId, 'typeId' => 1, 'getTotal' => true]);
        $this->assertTrue(empty($shares));

        // 空用户 未晒单
        $shares = Posts::myShare(['userId' => $this->_unsetUserId, 'typeId' => 2, 'getTotal' => true]);
        $this->assertTrue(empty($shares));

    }

    public function testShare() {

        $options = [
            'userId' => $this->_userId,
            'typeId' => 2,
            'page'   => 1,
            'limit'  => 1,
        ];

        $shares = Posts::myShare($options);
        $productId = $shares[0]['productId'];
        $periodId  = $shares[0]['periodId'];

        // 不是自己的返回空
        $share = Posts::share($productId, $periodId, $this->_unsetUserId);
        $this->assertEqual([], $share);

        // 我的晒单
        $keys = ['title', 'periodId'];
        $share = Posts::share( $productId, $periodId, $this->_userId);
        $this->assertEqual($keys, array_keys($share));
    }


}

?>
