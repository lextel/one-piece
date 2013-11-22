<?php

namespace app\models;

use app\extensions\helper\MongoClient;

class Posts extends \lithium\data\Model {

    /**
     * _id    
     * from_id          所属会员ID
     * to_id            发送至会员ID
     * parent_id        父级ID
     * product_id       产品ID
     * period_id        期数ID
     * title            标题
     * content          内容
     * images           图片
     * comment          评论数目
     * comments         评论
     * hits             浏览数目
     * good             赞
     * status           状态 0 未审核 1 已审核
     * created          创建时间
     */

	public $validates = array();

    /**
     * 我的晒单
     *
     * @param $options['useId']     integer  会员ID
     *        $options['typeId']    integer  1 已晒单 2未晒单
     *        $options['getTotal']  boolean  是否是统计总数
     *        $options['page']      integer     
     *        $options['limit']     integer  条数
     *
     * @return intger|array  $data['productId']
     *                       $data['title']
     *                       $data['periodId']
     *                       $data['userId']
     */
    public static function myShare($options) {

        $typeId = $options['typeId'];

        switch ($typeId) {
            case '2':
                $shares = self::_myUnShare($options);
                break;
            default:
                $shares = self::_myShare($options);
                break;
        }

        return $shares;


    }

    /**
     * 已晒单
     *
     */
    private static function _myShare($options) {
        $userId = $options['userId'];

        $mo = new MongoClient();
        $rs = $mo->find([], ['shares' => ['$elemMatch' => ['user_id' => $userId]]]);

        return $rs;
    }


    /**
     * 未晒单
     *
     * @param $options 条件
     *
     * @return array
     */
    private static function _myUnShare($options) {

        $userId = $options['userId'];
    
        $mo = new MongoClient();
        // 所有中奖的
        $rs = $mo->find([], ['periods' => ['$elemMatch' => ['user_id' => $userId]]]);

        // @TODO: 排除已经晒单的

        /*

        $conditions = ['periods.user_id' => $userId];
        $products = Products::find('all', ['conditions' => $conditions])->to('array');

        $shares = [];
        foreach($products as $product) {
            foreach($product['periods'] as $period) {
                if(isset($period['user_id']) && $period['user_id'] == $userId) {
                    $data = [
                        'productId' => $product['_id'],
                        'title'     => $product['title'],
                        'images'    => $product['images'],
                        'periodId'  => $period['id'],
                        'userId'    => $period['user_id'],
                    ];

                    $rs = Posts::first([
                                        'conditions' => [
                                            'from_id' => $userId, 
                                            'product_id' => $product['_id'], 
                                            'period_id' => $period['id']
                                            ]
                                        ]);
                    if(($rs && $typeId == 1) || (!$rs && $typeId == 2)) {
                        $shares[] = $data;
                    }
                }
            }
        }

        $limit = isset($options['limit']) ? $options['limit'] : 0;
        $page  = isset($options['page']) ? $options['page'] : 1;
        $offset = ($page-1)*$limit;

        return isset($options['getTotal']) && $options['getTotal'] ? count($shares) : array_slice($shares, $offset, $limit);
        */
    }


    /**
     * 获取当前会员可以晒单的信息
     *
     * @param $productId string  产品ID
     * @param $peroidId  integer 期数ID
     * @param $userId    integer 会员ID
     *
     * @return array $data['title']
     *               $data['periodId']
     */
    public static function share($productId, $periodId,  $userId=0) {
        $userId = empty($userId) ? USER_ID : $userId;

        $conditions = ['_id' => $productId, 'periods.id' => (int)$periodId, 'periods.user_id' => (int)$userId];
        $shares = Products::find('all', ['conditions' => $conditions, 'fields' => ['title']])->to('array');

        return empty($shares) ? [] : ['title' => $shares[$productId]['title'], 'periodId' => $periodId];
    }

    /**
     * 保存晒单
     *
     * @param $data array 提交数据
     *
     * @return boolean 
     */
    public function insert($data) {

        $data['status']    = 0;
        $data['parent_id'] = 0;
        $data['from_id']   = USER_ID;
        $data['created']   = time();

        $conditions = ['_id'=> $data['productId']];
        unset($data['productId']);

        $query = ['$push' => ['shares' => $data]];

        return Products::update($query, $conditions,['atomic' => false]);
    }

    
}

?>
