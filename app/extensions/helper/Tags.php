<?php
/**
 * 标签工具
 *
 * @author weelion<weelion@qq.com>
 * @version 1.0
 */
namespace app\extensions\helper;
class Tags {

    static $tags = [
        0 => ['class' => '', 'name' => '默认'],
        1 => ['class' => 'goods_xp', 'name' => '新品'],
        2 => ['class' => 'goods_tj', 'name' => '推荐'],
        3 => ['class' => 'goods_rq', 'name' => '人气'],
    ];

    static $limit = ['class' => 'goods_xs', 'name' => '限时'];

    /**
     * 返回tag名称数组
     *
     * @return array 返回 $array[1] = 推荐 形式
     */
    public static function tags() {

        $array = [];
        foreach(self::$tags as $key => $cat) {
            $array[$key] = $cat['name'];
        }

        return $array;
    }
}
