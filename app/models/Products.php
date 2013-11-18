<?php
/**
 * @author  weelion<weelion@qq.com>
 * @version 1.0
 */
namespace app\models;

use app\models\Periods;
use app\extensions\helper\Tags;
use lithium\util\Validator;

class Products extends \lithium\data\Model {

    const LIST_WIDTH = 213;
    const DETAILS_WIDTH = 447;

    /**
     * mongodb products数据结构
     *
     * @var array
     */
    protected $_schema = [
        '_id'      => ['type' => 'id', 'length' => 10, 'null' => false, 'default' => null],             // UUID
        'cat_id'   => ['type' => 'integer', 'length' => 5, 'null' => false, 'default' => 0],            // 分类ID
        'brand_id' => ['type' => 'integer', 'length' => 5, 'default' => 0],                             // 品牌ID
        'type_id'  => ['type' => 'integer', 'length' => 5],                                             // 类型
        'tag_id'   => ['type' => 'integer', 'length' => 5],                                             // 标识
        'title'    => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null],        // 标题
        'feature'  => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null],        // 特性
        'price'    => ['type' => 'float', 'length' => 10, 'null' => false, 'default' => 0],             // 当期价格
        'person'   => ['type' => 'integer', 'length' => 10, 'null' => false, 'default' => 0],           // 当期需要人次
        'remain'   => ['type' => 'integer', 'length' => 10, 'null' => false, 'default' => 0],           // 当期剩余人次
        'content'  => ['type' => 'string', 'length' => 10000, 'null' => false, 'default' => null],      // 详情
        'images'   => ['type' => 'array', 'length' => null, 'null' => false, 'default' => null],        // 图片
        'periods'  => ['type' => 'array', 'length' => null, 'null' => false, 'default' => null],        // 期数数据
        'hits'     => ['type' => 'integer', 'length' => 10, 'null' => false, 'default' => 0],           // 当期人气
        'status'   => ['type' => 'integer', 'length' => 1, 'null' => false, 'default' => 0],            // 上下架
        'created'  => ['type' => 'date'],                                                               // 添加时间
    ];

    /**
     * 验证字段
     *
     * @var array
     **/
    public $validates = [
            'cat_id'      => ['notEmpty', 'message' => '请选择分类'],
            'title'       => ['notEmpty', 'message' => '请填写商品名'],
            'price'       => ['decimal', 'message' => '价格格式不正确'],
            //'images'      => ['array', 'message' => '商品图片不能为空'],
            'content'     => ['notEmpty', 'message' => '请填写商品详情'],
           ];

    /**
     * 商品添加前预处理
     *
     * @param $data array 请求数据
     *                     $data['title']    名称
     *                     $data['feature']  特性
     *                     $data['cat_id']   分类ID
     *                     $data['brand_id'] 品牌ID
     *                     $data['price']    价格
     *                     $data['images']   图片
     *                     $data['content']  详情
     *
     * @return array  返回插入数据
     *                     $data['title']   名称
     *                     $data['feature'] 特性
     *                     $data['cat_id']  分类ID
     *                     $data['brand_id'] 品牌ID
     *                     $data['images']  图片
     *                     $data['content'] 详情
     *                     $data['status']  上架状态
     *                     $data['periods'] (见Periods Model)
     *                     $data['created'] 添加时间
     */
    public function _perAdd($data) {

        $data['hits']    = 0;
        $data['status']  = 0;
        $data['tag_id']  = 0;
        $data['created'] = date('Y-m-d H:i:s');
        $data['price']   = sprintf('%.2f',$data['price']);
        $data['person']  = intval($data['price']);
        $data['remain']  = $data['person'];

        $data = Periods::init($data);

        return $data;
    }

    /**
     * 添加商品
     *
     * @param $data array 商品数组
     *                    $data['title']    名称
     *                    $data['feature']  特性
     *                    $data['cat_id']   分类ID
     *                    $data['brand_id'] 品牌ID
     *                    $data['price']    价格
     *                    $data['images']   图片
     *                    $data['content']  详情
     *
     * @return object
     **/
    public function add($data) {

        $data = $this->_perAdd($data);
        $product = Products::create($data);
        $product->save();

        return $product;
    }

    /**
     * 商品列表条件处理
     *
     * @param $options array 排序参数
     *
     * @return array
     */
    public static function _perLists($options) {

        $options = self::handleOrderBy($options);

        $options['conditions'] = [];
        if(isset($options['cat_id']) && !empty($options['cat_id'])) {
            $options['conditions'] = ['cat_id' => $options['cat_id']];
            unset($options['cat_id']);
        };

        if(isset($options['brand_id']) && !empty($options['brand_id'])) {
            $options['conditions'] += ['brand_id' => $options['brand_id']];
            unset($options['brand_id']);
        }

        return $options;
    }

    /**
     * 处理排序
     *
     * @param $options array 排序数组
     *
     * @return array 添加排序到$options['order']并删除无关字段
     */
    public static function handleOrderBy(& $options) {

        $options['sort'] = isset($options['sort']) && $options['sort'] == 'asc' ? 'asc' : 'desc';

        if(isset($options['orderBy'])) {
            switch ($options['orderBy']) {
                case 'showed':
                    $options['order'] = ['showed' => $options['sort']];
                    break;
                case 'hit':
                    $options['order'] = ['hit' => $options['sort']];
                    break;
                case 'remain':
                    $options['order'] = ['remain' => $options['sort']];
                    break;
                case 'created':
                    $options['order'] = ['created' => $options['sort']];
                    break;
                case 'price':
                    $options['order'] = ['price' => $options['sort']];
                    break;
                default:
                    $options['order'] = ['showed' => 'asc'];
                    break;
            }
        }

        unset($options['orderBy'], $options['sort']);

        return $options;
    }

    /**
     * 商品列表
     *
     * @param $options array 过滤条件
     *                        $options['page']      页码
     *                        $options['cat_id']    分类
     *                        $options['brand_id']  品牌
     *                        $options['limit']     条数限制
     *                        $options['orderBy']   排序字段
     *                        $options['sort']      排序方式
     *
     * @param $output boolean 是否是输出
     *
     * @return object 结果对象
     */
    public static function lists($options = [], $output = false) {

        $options = self::_perLists($options);
        $data = Products::all($options);

        return $output ? self::_afterLists($data) : $data;
    }

    /**
     * 列表转成输出数组
     *
     * @param $data object 列表对象
     *
     * @return array
     */
    public static function _afterLists($data) {

        $newData = [];

        foreach($data as $item) {
            $percent = sprintf('%.2f', ($item->person - $item->remain)/$item->person * 100);
            $newData[] = [
                'id'        => $item->_id,
                'title'     => $item->title,
                'images'    => $item->images,
                'price'     => sprintf('%.2f',$item->price),
                'person'    => $item->person,
                'remain'    => $item->remain,
                'percent'   => $percent,
                'width'     => self::LIST_WIDTH *  $percent / 100,
                'join'      => $item->person - $item->remain,
                'periodId'  => count($item->periods),
                'tagClass'  => Tags::$tags[$item->tag_id]['class'],
                'status'    => $item->status == 1 ? true : false,
                'created'   => $item->created,
            ];
        }

        return $newData;
    }

    /**
     * 编辑商品
     *
     * @param $id   int   商品ID
     * @param $data array 商品数组
     *                    $data['title']   名称
     *                    $data['feature'] 特性
     *                    $data['cat_id']  分类ID
     *                    $data['price']   价格
     *                    $data['images']  图片
     *                    $data['content'] 详情
     *
     *
     * @return object
     */
    public function edit($id, $data) {

        $product = Products::find('first', ['conditions' => ['_id' => $id]]);
        $rs = $product->save($data);

        return $rs;
    }

    /**
     * 单个商品详情
     *
     * @param $id        mongoId 商品ID
     * @param $period_id integer 期数ID
     * @param $output    boolean 是否整理输出
     *
     * @return object|array
     */
    public function view($id, $periodId, $output = false) {
        $product = Products::find('first', ['conditions' => ['_id' => $id]]);

        return $output ? $this->_afterView($product, $periodId) : $product;
    }

    /**
     * 商品详情输出处理
     *
     * @param $product object 商品详情
     *
     * @return array
     */
    public function _afterView($product, $periodId) {

        list($period, $periodIds) = Periods::period($product->periods, $periodId);

        $percent = sprintf('%.2f', ($period['person'] - $period['remain'])/$period['person'] * 100);

        $info = [];
        $info['id']          = $product->_id;
        $info['periodId']    = $periodId;
        $info['title']       = $product->title;
        $info['feature']     = $product->feature;
        $info['price']       = $period['price'];
        $info['person']      = $period['person'];
        $info['remain']      = $period['remain'];
        $info['join']        = $period['person'] - $period['remain'];
        $info['content']     = $product->content;
        $info['typeId']      = $product->type_id;
        $info['images']      = $product->images;
        $info['orders']      = isset($period['orders']) ? $period['orders'] : [];
        $info['results']     = isset($period['results']) ? $period['results'] : [];
        $info['periodIds']   = $periodIds;
        $info['percent']     = $percent;
        $info['width']       = self::DETAILS_WIDTH *  $percent / 100;
        $info['showFeature'] = ($periodId == count($periodIds)) ? true : false;


        // 如果是正在进行，显示上期获奖者(商品图片下方)
        $info['showWinner'] = false;
        $total = count($periodIds);
        if($periodId > 1 && $periodId == $total) {

            list($prevPeriod, ) = Periods::period($product->periods, $periodId-1);

            if($prevPeriod['status'] == 2) {
                $info['showWinner'] = true;
                $info['winner'] = [
                    'userId'  => $prevPeriod['user_id'],
                    'code'    => $prevPeriod['code'],
                    'ordered' => $prevPeriod['ordered'],
                ];
            }
        } 

        // 晒单数目
        $info['shareTotal'] = count($product->shares);

        // 如果是限时显示揭晓时间
        $info['showLimitTime'] = false;
        if($product->typeId == 2) {
            $info['showLimitTime'] = true;
            $info['showed'] = $period['showed'];
        }

        // 如果不是正在进行的期数
        if($total != $periodId) {
            // 剩余两分钟显示倒计时 (计算 &&　限时)
            $info['showTimer'] = false;
            if($period['status'] == 1) {
                $info['showTimer'] = true;
                $period['showedTime'] = strtotime($period['showed'] , '+2 minutes');
            }

            // 显示揭晓结果
            $info['showResult'] = false;
            if($period['status'] == 2) {
                $info['showResult'] = true;
                $info['code'] = str_split($period['code']);
                $info['userId'] = $period['user_id'];
                $info['ordered'] = date('Y-m-d H:i:s', $period['ordered']);
                $info['showed'] = date('Y-m-d H:i:s', $period['showed']);
            }

            // 获取正在进行的期数
            $info['showActive'] = false;
            if($product->status == 1) {
                $info['showActive'] = true;
                list($activePeriod, $activeIds) = Periods::period($product->periods, $total);
                $info['activePeriod'] = [
                    'id'      => $activePeriod['id'],
                    'person'  => $activePeriod['person'],
                    'remain'  => $activePeriod['remain'],
                    'join'    => $activePeriod['person'] - $activePeriod['remain'],
                    'percent' => sprintf('%.2f', ($activePeriod['person'] - $activePeriod['remain'])/$activePeriod['person'] * 100),
                ];
            }

        }
        
        return $info;
    }


}

// 图片验证规则
Validator::add('array', function($value) {
    return is_array($value);
});
?>
