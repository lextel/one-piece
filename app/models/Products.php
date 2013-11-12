<?php
/**
 * @author  weelion<weelion@qq.com>
 * @version 1.0
 */
namespace app\models;

class Products extends \lithium\data\Model {

    protected $_schema = [
        '_id' => ['type' => 'id', 'length' => 10, 'null' => false, 'default' => null],
        'cat_id' => ['type' => 'integer', 'length' => 5, 'null' => false, 'default' => 0],
        'title' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null],
        'feature' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null],
        'content' => ['type' => 'string', 'length' => 10000, 'null' => false, 'default' => null],
        'price' => ['type' => 'float', 'length' => 10, 'null' => false, 'default' => 0],
        'person' => ['type' => 'integer', 'length' => 5, 'null' => false, 'default' => 0],
        'remain' => ['type' => 'integer', 'length' => 5, 'null' => false, 'default' => 0],
        'images' => ['type' => 'array', 'length' => null, 'null' => false, 'default' => null],
        'periods' => ['type' => 'array', 'length' => null, 'null' => false, 'default' => null],
        'hit' => ['type' => 'integer', 'length' => 10, 'null' => false, 'default' => 0],
        'status' => ['type' => 'integer', 'length' => 1, 'null' => false, 'default' => 0],
        'showed' => ['type' => 'date'],
        'created' => ['type' => 'date'],
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
            // 'images'      => ['array', 'message' => '商品图片不能为空'],
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
     *                 $data['title']   名称
     *                 $data['feature'] 特性
     *                 $data['cat_id']  分类ID
     *                 $data['brand_id'] 品牌ID
     *                 $data['price']   价格
     *                 $data['person']  人次
     *                 $data['remain']  剩余人次
     *                 $data['images']  图片
     *                 $data['content'] 详情
     *                 $data['status']  上架状态
     *                 $data['periods'] (见Periods Model)
     *                 $data['created'] 添加时间
     */
    public function _perAdd($data) {

        $data['price'] = sprintf('%.2f',$data['price']);
        $data['person'] = intval($data['price']);
        $data['remain'] = intval($data['price']);
        $data['hit'] = 0;
        $data['status'] = 0;
        $data['created'] = date('Y-m-d H:i:s');

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
     * @return array
     **/
    public function add($data) {

        $data = $this->_perAdd($data);
        $product = Products::create($data);
        $rs = $product->save();

        return $rs;
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
     * @return object 结果对象
     */
    public static function lists($options = []) {

        $options = self::_perLists($options);

        return Products::all($options);
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
}

?>
