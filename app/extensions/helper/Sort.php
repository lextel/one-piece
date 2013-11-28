<?php
/**
 * 前端排序工具
 *
 * @author weelion<weelion@qq.com>
 * @version 1.0
 */
namespace app\extensions\helper;

class Sort {

    static $orderBy = [
        'products' => [
            'remain'  => '揭晓时间',
            'hits'    => '人气',
            'remain'  => '剩余人次',
            'created' => '最新',
            'price'   => '价格'
        ],
        'search' => [
            'showed'  => '揭晓时间',
            'hits'    => '人气',
            'remain'  => '剩余人次',
            'created' => '最新',
            'price'   => '价格'
        ],
        'shares' => [
            'created' => '最新晒单',
            'hits' => '人气晒单',
            'comment' => '评论最多',
        ]
    ];

    /**
     * 获取排序字段
     *
     * @param $index string self::$sorts索引
     *
     * @return array
     */
    public static function field($index) {

        return isset(self::$orderBy[$index]) ? self::$orderBy[$index] : [];
    }

    /**
     * 获取排序title
     *
     * @param $index   string self::$sorts索引
     * @param $options array  参数
     *                 $options['catId']
     *                 $options['brandId']
     *                 $options['sort']
     *                 $options['sortBy']
     *
     * @return array 排序方式列表
     */
    public static function sort($index, $options) {

        $orderByList = [];

        $orderBys = self::field($index);
        $first = reset($orderBys);
        foreach($orderBys as $idx => $name) {
            $class = '';
            $htmlSort = 'desc';
            $sortTag = '<s></s>';
            if($options['sort'] == $idx || ($options['sort'] == '' && $name == $first) ) {
                $class = 'SortCur';
                $htmlSort = ($options['sortBy'] == 'asc') ? 'desc' : 'asc';
                $sortTag = ($options['sortBy'] == 'asc') ? '<i></i>' : '<s></s>';
            }

            $keys = ['sort', 'sortBy'];
            $params = '';
            foreach($options as $k => $v) {
                if(!in_array($k, $keys) && !empty($v)) {
                    $params .= '/' . $v;
                }
            } 

            $orderByList[] = '<a href="/'.$index.'/index'.$params.'/?sort='.$idx.'&sortBy='.$htmlSort.'" class="'.$class.'">'.$name.$sortTag.'</a>';
        }

        return $orderByList;
    }
}
