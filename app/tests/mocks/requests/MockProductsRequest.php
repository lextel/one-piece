<?php
namespace app\tests\mocks\requests;

class MockProductsRequest extends \lithium\action\Request {


    public function get($name) {

        $data = [
            'form' => [
                'cat_id' => '1',
                'title'       => '添加商品',
                'feature'     => '卖点',
                'type_id'     => '1',
                'price'       => '999.00',
                'images'      => ['images/products/b/d/test11.jpg'],
                'content'     => '详情'
                ],
            'errorForm' => [
                'emptyCatId' => [
                    'title'       => '错误分类商品',
                    'feature'     => '卖点',
                    'type_id'     => '1',
                    'price'       => '999.00',
                    'images'      => ['images/products/b/d/test11.jpg'],
                    'content'     => '详情1'
                    ],
                'emptyTitle' => [
                    'cat_id'      => '1',
                    'feature'     => '卖点错误标题商品',
                    'type_id'     => '1',
                    'price'       => '999.00',
                    'images'      => ['images/products/b/d/test11.jpg'],
                    'content'     => '详情'
                    ],
                'errorPrice' => [
                    'cat_id'      => '1',
                    'title'       => '错误价格商品',
                    'feature'     => '卖点',
                    'type_id'     => '1',
                    'price'       => 'aa',
                    'images'      => ['images/products/b/d/test11.jpg'],
                    'content'     => '详情'
                    ],
                'emptyContent' => [
                    'cat_id'      => '1',
                    'title'       => '错误内容商品',
                    'feature'     => '卖点',
                    'type_id'     => '1',
                    'price'       => '999.00',
                    'images'      => ['images/products/b/d/test11.jpg'],
                    ],
                'errorImages' => [
                    'cat_id'      => '1',
                    'title'       => '错误图片商品',
                    'feature'     => '卖点',
                    'type_id'     => '1',
                    'price'       => '999.00',
                    'images'      => 'images/products/b/d/test11.jpg',
                    'content'     => '详情',
                    ],
                ],
        ];

        return $data[$name];
    }

}
