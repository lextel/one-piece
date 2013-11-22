<?php

namespace app\tests\cases\models;

use app\models\Posts;
use app\models\Products;
use app\extension\MongoClient;

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

        // 验证我未晒单的总数
        $options = [
            'userId'   => $this->_userId,
            'typeId'   => 2,
            'getTotal' => true,
        ];

        $total = Posts::myShare($options);

        $mo = new MongoClient();
        $count = $mo->count(['periods' => ['$elemMatch' => ['user_id' => $this->_userId]]]);

        $this->assertEqual($total, $count);

        // 验证我已晒单的总数
        $optiosn = [
            'userId'   => $this->_userId,
            'typeId'   => 1,
            'getTotal' => true,
        ];
        $total => Posts::myShare($options);

        $mo = new MongoClient();
        $count = $mo->count(['shares' => ['$elemMatch' => ['user_id' => $this->_userId]]);

        $this->assertEqual($total, $count);


        
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
