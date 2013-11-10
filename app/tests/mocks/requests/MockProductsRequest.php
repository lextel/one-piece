<?php
namespace app\tests\mocks\requests;

class MockProductsRequest extends \lithium\action\Request {


    public function get($name) {

        $data = [
            'form' => [
                'cat_id' => '1',
                'title'       => '商品1',
                'feature'     => '卖点1',
                'type_id'     => '1',
                'price'       => '999.00',
                'images'      => ['images/products/b/d/test11.jpg'],
                'content'     => '详情1'
                ],
            'errorForm' => [
                'emptyCatId' => [
                    'title'       => '商品1',
                    'feature'     => '卖点1',
                    'type_id'     => '1',
                    'price'       => '999.00',
                    'images'      => ['images/products/b/d/test11.jpg'],
                    'content'     => '详情1'
                    ],
                'emptyTitle' => [
                    'cat_id' => '1',
                    'feature'     => '卖点1',
                    'type_id'     => '1',
                    'price'       => '999.00',
                    'images'      => ['images/products/b/d/test11.jpg'],
                    'content'     => '详情1'
                    ],
                'errorPrice' => [
                    'cat_id' => '1',
                    'title'       => '商品1',
                    'feature'     => '卖点1',
                    'type_id'     => '1',
                    'price'       => 'aa',
                    'images'      => ['images/products/b/d/test11.jpg'],
                    'content'     => '详情1'
                    ],
                'emptyContent' => [
                    'cat_id' => '1',
                    'title'       => '商品1',
                    'feature'     => '卖点1',
                    'type_id'     => '1',
                    'price'       => '999.00',
                    'images'      => ['images/products/b/d/test11.jpg'],
                    ],
                'errorImages' => [
                    'cat_id' => '1',
                    'title'       => '商品1',
                    'feature'     => '卖点1',
                    'type_id'     => '1',
                    'price'       => '999.00',
                    'images'      => 'images/products/b/d/test11.jpg',
                    'content'     => '详情1',
                    ],
                ]
        ];

        return $data[$name];
    }

}
