<?php
namespace app\tests\mocks\models;

class MockProductsModel extends \lithium\data\Model {

    public static function find($name, array $options= []) {
        switch ($name) {
            case 'first':
                return [
                    'title' => '在售商品',
                    'feature' => '特性',
                    'cat_id' => 1,
                    'brand_id' => 1,
                    'tag_id' => 1,
                    'price' => '100.00',
                    'person' => 100,
                    'remain' => 50,
                    'content' => '内容 创建时间是2013/11/20',
                    'showed' => '1384876800',
                    'created' => '2013-11-20',
                    'hits' => 100,
                    'status' => 1,
                    'images' => [
                        'images/products/b/d/test11.jpg',
                        'images/products/b/d/test11.jpg'
                    ],
                    'periods' => [
                        [
                            'id' => 1, 
                            'code' => '100000', 
                            'user_id' => 1, 
                            'price' => '100.00', 
                            'person' => 100, 
                            'remain' => 0, 
                            'hits' => 1000,
                            'created' => '1384876800', 
                            'showed' => '1384963200', 
                            'orders' => [],
                            'results' => [],
                            'status' => 2,
                        ],
                        [
                            'id' => 2, 
                            'code' => '', 
                            'user_id' => '', 
                            'price' => '100.00', 
                            'person' => 100, 
                            'remain' => 0, 
                            'hits' => 1000,
                            'created' => '1384876800', 
                            'showed' => '1384963200', 
                            'orders' => [],
                            'results' => [],
                            'status' => 1,
                        ],
                        [
                            'id' => 3, 
                            'code' => '', 
                            'user_id' => '', 
                            'price' => '100.00', 
                            'person' => 100, 
                            'remain' => 50, 
                            'hits' => 100,
                            'created' => '1384876800', 
                            'showed' => '', 
                            'orders' => [],
                            'results' => [],
                            'status' => 0,
                        ]
                    ],
                    'shares' => [],
                ];
                break;
            
            default:
                # code...
                break;
        }

    }

}