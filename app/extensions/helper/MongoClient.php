<?php
/**
 * MongoDb工具
 * 
 * 坑嗲的框架查询支持不完整
 *
 * @author weelion<weelion@qq.com>
 * @version 1.0
 */
namespace app\extensions\helper;

use Mongo;
use MongoId;
use lithium\data\Connections;

class MongoClient {

    private $_query;
    private $_types = [
        '_id' => 'MongoId',
    ];
    

    /**
     * 初始化
     */
    public function __construct() {

        $config = Connections::get('default', ['config' => true]);
        $conn = new Mongo();
        $this->_query = $conn->$config['database']->$config['database'];
    }

    /**
     * 查询
     *
     * @param $conditions array 查询条件
     * @param $fields     array 返回
     *
     * @return array
     */
    public function find($conditions, $fields = []) {

        $this->_conditions($conditions);
        $rows = $this->_query->find($conditions, $fields);

        return iterator_to_array($rows);
    }

    /**
     * 统计
     *
     * @param $conditions array 查询条件
     *
     * @return integer
     */
    public function count($conditions) {

        $this->_conditions($conditions);

        return $this->_query->count($conditions);
    }

    /**
     * 整理条件
     *
     * @param &$conditions array 条件
     *
     * @return void
     */
    private function _conditions(&$conditions) {

        foreach($conditions as $key => $condition) {
            if(in_array($key, array_keys($this->_types))) {
                $conditions[$key] = new $this->_types[$key]($condition);
            }
        }
    }
}
