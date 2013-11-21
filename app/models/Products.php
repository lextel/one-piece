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

    const LIST_WIDTH    = 213;  // 列表进度条总宽度
    const DETAILS_WIDTH = 447;  // 详情进度条总宽度
    const SHOW_TIME     = 5;    // 到揭晓时间后

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

        if(empty($product)) return [];

        list($period, $periodIds) = Periods::period($product->periods, $periodId);
        
        if(empty($period)) return [];

        $join = $period['person'] - $period['remain'];
        $percent = sprintf('%.2f', $join/$period['person'] * 100);

        $info = [];
        $info['id']           = $product->_id;
        $info['title']        = $product->title;
        $info['feature']      = $product->feature;
        $info['content']      = $product->content;
        $info['images']       = $product->images;
        $info['typeId']       = $period['typeId'];
        $info['orders']       = $period['orders'];
        $info['results']      = $period['results'];
        $info['price']        = $period['price'];
        $info['person']       = $period['person'];
        $info['remain']       = $period['remain'];
        $info['join']         = $join;
        $info['periodId']     = $periodId;
        $info['periodIds']    = $periodIds;
        $info['percent']      = $percent;
        $info['width']        = self::DETAILS_WIDTH * $percent / 100;
        $info['shareTotal']   = count($product->shares);                                        // 晒单数目
        $info['showFeature']  = $this->_showFeature($periodId, count($periodIds));              // 显示特性
        $info['showWinner']   = $this->_showWinner($product->periods, $periodId, $info);        // 上期获奖者
        $info['showLimit']    = $this->_showLimit($period, $info);                              // 限时揭晓
        $info['showFull']     = $this->_showFull($period['remain']);                            // 人次是否已满
        $info['showCounting'] = $this->_showCounting($period['status']);                        // 显示正在计算
        $info['showResult']   = $this->_showResult($period, $info);                             // 显示揭晓结果
        $info['showActive']   = $this->_showActive($product->status, $product->periods, $info); // 获取正在进行的期数
        $info['showSoldOut']  = $this->_showSoldOut($product->status, $info);                   // 是否已经下架
        
        return $info;
    }

    /**
     * 显示特性
     *
     * @param $periodId integer 本期ID
     * @param $total    integer 总期数
     *
     * @return boolean 是否显示
     */
    private function _showFeature($periodId, $total) {

        return ($periodId == $total);
    }

    /**
     * 是否显示上期获奖者
     * 如果不是第一期 且 最后一期是当前期 且 上一期已揭晓
     *
     * @param $periods   object  商品所有期
     * @param $periodId  integer 当前期ID
     * @param &$info     array   附加上期获奖者信息
     *
     * @return boolean
     */
    private function _showWinner($periods, $periodId, &$info) {

        $show = false;
        $total = count($periods);
        if($periodId > 1 && $periodId == $total) {

            list($period, ) = Periods::period($periods, $periodId-1);

            if($period['status'] == 2) {    // 已经揭晓
                $show = true;
                $info['winner'] = [
                    'userId'  => $period['user_id'],
                    'code'    => $period['code'],
                    'ordered' => $period['ordered'],
                ];
            }
        }

        return $show;
    }

    /**
     * 是否是显示揭晓
     *
     * @param $period array 本期信息
     * @param &$info  array 附加揭晓时间
     *
     * @return boolean 是否显示
     */
    private function _showLimit($period, &$info) {
        $show = false;
        if($period['typeId'] == 1) {
            $show = true;
            $leftTime = $period['showed'] - time();
            $hour = floor($leftTime/3600);
            $second = $leftTime%3600;
            $minute = floor($second/60);
            $second = $second%60;
            $info['showed'] = $leftTime > 86400 ? sprintf("揭晓时间：<em>%d</em>月<em>%d</em>日<em>%d</em>时", date('m'), date('d'), date('H')) : sprintf("剩余时间：<em>%02d</em>时<em>%02d</em>分<em>%02d</em>秒", $hour, $minute, $second);
            $info['leftTime'] = $leftTime;
        }

        return $show;
    }

    /**
     * 是否已经满人
     * 
     * @param $remain integer 剩余人数
     *
     * @return boolean 是否显示
     */
    private function _showFull($remain) {

        return empty($remain);
    }

    /**
     * 是否显示计算中
     *
     * @param $status integer 状态
     *
     * @return boolean 是否显示
     */
    private function _showCounting($status) {

        return ($status == 1);
    }

    /**
     * 是否显示开奖结果
     *
     * @param $period array 本期信息
     * @param &$info  array 附加开奖信息
     *
     * @return boolean 是否显示
     */
    private function _showResult($period, &$info) {

        $show = false;
        if($period['status'] == 2) {    // 已经揭晓状态
            $show = true;
            $info['code']    = str_split($period['code']);
            $info['userId']  = $period['user_id'];
            $info['ordered'] = date('Y-m-d H:i:s', $period['ordered']);
            $info['showed']  = date('Y-m-d H:i:s', $period['showed']);
        }

        return $show;
    }

    /**
     * 是否显示正在进行的期信息
     *
     * @param $status  integer 商品上架状态
     * @param $periods object  本商品的所有期对象
     * @param &$info   array   附加正在进行期信息
     * 
     * @return boolean 是否显示
     */
    private function _showActive($status, $periods, &$info) {

        $show = false;
        if($status == 1) { // 上架状态
            $show = true;
            list($period, ) = Periods::period($periods);

            $join = $period['person'] - $period['remain'];
            $info['activePeriod'] = [
                'id'      => $period['id'],
                'person'  => $period['person'],
                'remain'  => $period['remain'],
                'join'    => $join,
                'percent' => sprintf('%.2f', $join / $period['person'] * 100),
            ];
        }

        return $show;
    }

    /**
     * 商品已经下架
     *
     * @param $status integer 商品状态
     * @param &$info  array   
     *
     * @return boolean
     */
    private function _showSoldOut($status, &$info) {

        $show = false;
        if($status == 0) {
            $show = true;
        }

        return $show;
    }


}

// 图片验证规则
Validator::add('array', function($value) {
    return is_array($value);
});
?>
