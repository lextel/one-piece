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
use MongoRegex;
use lithium\data\Connections;

class MongoClient {

    private $_query;
    private $_types = [
        '_id' => 'MongoId',
        'title' => 'MongoRegex',
    ];
    private $_ints = [
        'cat_id',
        'brand_id'
    ];
    

    /**
     * 初始化
     */
    public function __construct($collection = '') {

        $config = Connections::get('default', ['config' => true]);
        $conn = new Mongo();
        if(empty($collection)) {
            $collection = $config['database'];
        }

        
        $this->_query = $conn->$config['database']->$collection;
    }

    /**
     * 查询
     *
     * @param $conditions array   查询条件
     * @param $fields     array   返回字段
     * @param $sort       arary   排序
     * @param $limit      integer 显示数目
     * @param $page       integer 页数
     *
     * @return array
     */
    public function find($conditions = [], $fields = [], $sort = [], $limit=0, $page=0) {

        $this->_conditions($conditions);
        if(!empty($limit) && !empty($page)) {
            $offset = ($page-1)*$limit;
            $rows = $this->_query->find($conditions, $fields)->sort($sort)->skip($offset)->limit($limit);
        } else if(!empty($sort)) {
            $rows = $this->_query->find($conditions, $fields)->sort($sort);
        } else {
            $rows = $this->_query->find($conditions, $fields);
        }

        return iterator_to_array($rows);
    }

    /**
     * 统计
     *
     * @param $conditions array 查询条件
     *
     * @return integer
     */
    public function count($conditions=[]) {

        $this->_conditions($conditions);
        //var_dump($conditions);

        return $this->_query->count($conditions);
    }

    /**
     * 更新
     * 
     * @param $conditions array 查询条件
     * @param $query      array 修改器
     * 
     * @return 
     */
    public function update($conditions, $query) {

        return $this->_query->update($conditions, $query);
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

            if(in_array($key, $this->_ints)) {
                $conditions[$key] = (int) $condition;
            }
        }
    }

    public function getConn(){
        return $this->_query;
    }
}
