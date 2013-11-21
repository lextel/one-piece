<?php
/**
 * MongoDb工具
 * 
 * 坑嗲的框架支持不完整
 *
 * @author weelion<weelion@qq.com>
 * @version 1.0
 */
namespace app\extensions\helper;
use lithium\data\Connections;

class Mongo {

    public static function instance() {
        $config = Connections::get('default', array('config' => true));

        $conn = new Mongo($config['host']);
        return $db=$conn->$config['database'];
    }
}