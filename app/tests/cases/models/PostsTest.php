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

    public function testShare() {

        $shares = Posts::myShare($this->_userId);

        if(count($shares)) {
            $keys = ['productId', 'title', 'periodId', 'userId'];
            $dataKeys = array_keys($shares[0]);
            $this->assertEqual($keys, $dataKeys);
        }



    }


}

?>
