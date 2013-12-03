<?php

namespace app\models;

use MongoId;
use app\extensions\helper\User;
use app\extensions\helper\MongoClient;

class Posts extends \lithium\data\Model {

    const IS_SHARE = 1;
    const IS_NOTICE = 3;

    /**
     * mongodb posts数据结构
     *
     * @var array
     */
    protected $_schema = [
        '_id'        => ['type' => 'id'],             // UUID
        'from_id'    => ['type' => 'string'],        // 所属会员ID
        'to_id'      => ['type' => 'string'],        // 发送至会员ID
        'type_id'    => ['type' => 'integer'],        // 类型 晒单 短信息
        'parent_id'  => ['type' => 'string'],        // 父级ID
        'product_id' => ['type' => 'string'],         // 产品ID
        'period_id'  => ['type' => 'string'],         // 期数ID
        'title'      => ['type' => 'string'],         // 标题
        'content'    => ['type' => 'string'],         // 内容
        'images'     => ['type' => 'array'],          // 图片
        'comment'    => ['type' => 'integer'],        // 评论数目
        'hits'       => ['type' => 'integer'],        // 浏览数目
        'good'       => ['type' => 'integer'],        // 赞
        'status'     => ['type' => 'integer'],        // 状态 0 未审核 1 已审核
        'created'    => ['type' => 'date'],           // 添加时间
    ];

    /**
     * 类型指定
     *
     */
    public static $typeIds = [
        'share' => 1,
        'feeds' => 2,
    ];


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
     * @param $options array 查询条件
     *
     * @return array
     */
    private static function _myShare($options) {

        $userId = $options['userId'];

        $conditions = ['from_id' => $userId, 'type_id' => self::IS_SHARE];
        if(isset($options['getTotal']) && $options['getTotal']) {
            $rs =  Posts::find('all', ['conditions' => $conditions])->count();
        } else {
            $rs = Posts::find('all', ['conditions' => $conditions, 'order' => ['created' => 'desc'], 'limit' => $options['limit'], 'page' =>  $options['page']])->to('array');
        }

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

        // 已经晒单的
        $options['type_id'] = 1;
        $shared = self::_myShare($options);

        // 未晒单数据
        if(isset($options['getTotal']) && $options['getTotal'] == true) {
            $rs = $mo->count(['periods' => ['$elemMatch' => ['user_id' => $userId]]]);
            $rs = $rs - $shared;
        } else {
            $rs = $mo->find(['periods' => ['$elemMatch' => ['user_id' => $userId]]], ['title', 'periods' => ['$elemMatch' => ['user_id' => $userId]]]);

            $shares = self::_formatMyUnShare($rs);

            // 排除已晒单
            foreach($shared as $share) {
                foreach($shares as $k => $r) {
                    if($share['product_id'] == $r['productId'] && $share['period_id'] == $r['periodId']) {
                        unset($shares[$k]);
                    }
                }
            }

            $limit = isset($options['limit']) ? $options['limit'] : 0;
            $page  = isset($options['page']) ? $options['page'] : 1;
            $offset = ($page-1)*$limit;

            $rs = array_slice($shares, $offset, $limit);
        }

        return $rs;
    }

    /**
     * 整理已晒单数据
     *
     * @param $rs array 查询结果
     *
     * @return array 整理过的结果
     */
    private static function _formatMyShare($rs) {

        $newData = [];
        foreach($rs as $value) {
            foreach($value['shares'] as $share) {
                $newData[] = [
                    'productId' => $value['_id'],
                    'periodId' => $share['period_id'],
                    'title'    => $value['title'],
                    'shareTitle' => $share['title'],
                    'status' => $share['status'],
                ];
            }
        }

        return $newData;
    }

    /**
     * 整理未晒单数据
     *
     * @param $rs array 查询结果
     *
     * @return array 整理过的结果
     */
    private static function _formatMyUnShare($rs) {

        $newData = [];
        foreach ($rs as $key => $value) {
            foreach($value['periods'] as $period) {
                $newData[] = [
                    'productId' => $value['_id'],
                    'periodId' => $period['id'],
                    'title' => $value['title'],
                ];
            }
        }

        return $newData;
    }

    /**
     * 获取所有晒单
     *
     * @param $options array 查询参数
     *
     * @return array
     */
    public static function listShares($options) {

        $status = $options['typeId'] == 1 ? 1 : 0;

        if(isset($options['getTotal']) && $options['getTotal']) {
            $rs = Posts::find('all', ['conditions' => ['status' => $status, 'type_id' => self::IS_SHARE]])->count();
        } else {

            $rs = Posts::find('all', ['conditions' => ['type_id' => self::IS_SHARE, 'status' => $status], 'sort' => ['created' => 'desc']], $options['limit'], $options['page'])->to('array');
        }

        return $rs;
    }

    /**
     * 首页获取晒单
     *
     * @param $options array 查询参数
     *
     * @return array
     */
    public static function shareIndex($options) {

        $status = $options['status'];
        $options = self::handleSort($options);
        if(isset($options['getTotal']) && $options['getTotal']) {
            $rs = Posts::find('all', ['conditions' => ['status' => $status, 'type_id' => self::IS_SHARE]])->count();
        } else {
            $rs = Posts::find('all', ['conditions' => ['status' => $status, 'type_id' => self::IS_SHARE], 'order' => $options['order']])->to('array');
            $rs = self::_formatShare($rs);
        }

        return $rs;
    }

    /**
     * 处理排序
     *
     * @param $options array 排序数组 添加排序到$options['order']并删除无关字段
     * @param 默认排序
     *
     * @return viod
     */
    public static function handleSort($options, $default = []) {

        $options['sortBy'] = isset($options['sortBy']) && $options['sortBy'] == 'asc' ? 'asc' : 'desc';
        $default = empty($default) ?  ['created' => 'desc'] : $default;

        if(isset($options['sort'])) {
            switch ($options['sort']) {
                case 'hits':
                    $options['order'] = ['hits' => $options['sortBy']];
                    break;
                case 'comment':
                    $options['order'] = [ 'comment' => $options['sortBy']];
                    break;
                case 'created':
                    $options['order'] = ['created' => $options['sortBy']];
                    break;
                case 'price':
                    $options['order'] = [ 'price' => $options['sortBy']];
                    break;
                default:
                    $options['order'] = $default;
                    break;
            }
        } else {
            $options['order'] = $default;
        }

        unset($options['sortBy'], $options['sort']);

        return $options;
    }


    /**
     * 晒单详情
     *
     * @param $productId integer 商品ID
     * @param $periodId  integer 期数ID
     *
     * @return array
     */
    public static function shareView($productId, $periodId) {

        return Posts::find('first', ['conditions' => ['product_id' => $productId , 'period_id' => $periodId, 'type_id' => self::IS_SHARE]])->to('array');
    }

    /**
     * 晒单瀑布流
     *
     * @param $rs array 查询数据
     *
     * @return array
     */
    private static function _formatShare($rs) {

        $newData = [];
        $i = 0;
        $userModel = new Users;
        foreach($rs as $value) {

            // echo $value['form_id'];

            $user = $userModel->profile($value['from_id']);

            $data = [
                'productId' => $value['product_id'],
                'periodId'  => $value['period_id'],
                'title'     => $value['title'],
                'content'   => $value['content'],
                'image'     => $value['images'][0],
                'userId'    => $value['from_id'],
                'good'      => $value['good'],
                'comment'   => $value['comment'],
                'created'   => $value['created'],
                'avatar'    => $user['avatar'],
                'nickname'  => $user['nickname'],
            ];

            $j = $i % 4;
            $i++;

            if($j == 0 ) {
                $newData[0][] = $data;
            }

            if($j == 1) {
                $newData[1][] = $data;
            }

            if($j == 2) {
                $newData[2][] = $data;
            }

            if($j == 3) {
                $newData[3][] = $data;
            }

        }

        return $newData;
    }


    /**
     * 获取指定晒单信息
     *
     * @param $productId string  产品ID
     * @param $peroidId  integer 期数ID
     * @param $userId    integer 会员ID
     *
     * @return array $data['title']
     *               $data['periodId']
     */
    public static function share($productId, $periodId,  $userId=0) {

        $info = new User;
        $id = $info->id();
        $userId = empty($userId) ? $id : $userId;
        
        $mo = new MongoClient();
        $productId = new MongoId($productId);
        $rs = $mo->getConn()->find(['_id' => $productId, 'periods' => ['$elemMatch' => ['id' => (int)$periodId, 'user_id' => $userId]]]);
        $rs = iterator_to_array($rs, false);

        return empty($rs) ? [] : ['title' => $rs[0]['title'], 'periodId' => $periodId];
    }

    /**
     * 审核晒单
     *
     * @param $productId mongoid 商品ID
     * @param $periodId  integer 期数ID
     *
     * @return boolean
     */
    public static function checkShare($productId, $periodId) {

        $conditions = ['product_id' => $productId, 'period_id' => $periodId, 'type_id' => self::IS_SHARE];

        $query = ['status' => 1];

        return Posts::update($query, $conditions, ['atomic' => false]);
    }

    /**
     * 删除晒单
     *
     * @param $productId mongoid 商品ID
     * @param $periodId  integer 期数ID
     *
     * @return boolean
     */
    public static function deleteShare($productId, $periodId) {

        $conditions = ['product_id' => $productId, 'period_id' => $periodId, 'type_id' => self::IS_SHARE];

        return Posts::remove($conditions);
    }

    /**
     * 获取晒单评论
     *
     */
    public function comment($options) {

        $conditions = ['parent_id' => $options['postId']];
        if(isset($options['getTotal']) && $options['getTotal']) {
            return Posts::find('all', ['conditions' => $conditions])->count();
        } else {
            $posts = Posts::find('all', [ 'conditions' => $conditions, 'order' => ['created'=>'desc'], 'limit' => $options['limit'], 'page' => $options['page']])->to('array');
            $userModel = new Users();
            foreach($posts as $key => $post) {
                $posts[$key]['user'] = $userModel->profile($post['user_id']);
            }

            return $posts;
        }

    }

    /**
     * 保存发布
     *
     * @param $data array 提交数据
     *
     * @return boolean
     */
    public static function add($data) {

        switch ($data['type_id']) {
            case self::IS_SHARE:
                $rs = self::_addShare($data);
                break;

            default:
                # code...
                break;
        }

        return $rs;
    }

    /**
     * 保存晒单
     *
     * @param $data array 提交数据
     *
     * @return boolean
     */
    public static function _addShare($data) {

        $info = new User;
        $userId = $info->id();

        $data['status']    = 0;
        $data['parent_id'] = 0;
        $data['from_id']   = $userId;
        $data['good']      = 0;
        $data['hits']      = 0;
        $data['comment']   = 0;
        $data['comments']  = [];
        $data['created']   = date('Y-m-d H:i:s');

        $share = Posts::create($data);

        return $share->save();
    }

    /**
     * 获取公告
     *
     */
    public function notice() {

        $posts = Posts::find('all', ['conditions' => ['type_id' => self::IS_NOTICE], 'limit' => 5]);
        $notices = [];
        if($posts != null) {
            $notices = $posts->to('array');
        }

        return $notices;
    }

    public function noticeDetails($postId) {
        $post = Posts::find('first', ['conditions' => ['_id' => $postId, 'type_id' => self::IS_NOTICE]]);

        $details = [];
        if($post != null) {
            $details = $post->to('array');
        }

        return $details;
    }


}

?>
