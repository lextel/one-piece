<?php
/**
 * 排序工具
 */
namespace app\extensions\helper;

class Sort {

    static $orderBy = [
        'products' => [
            'showed'  => '揭晓时间',
            'hit'     => '人气',
            'remain'  => '剩余人次',
            'created' => '最新',
            'price'   => '价格'
        ],
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
     * @param $index  string self::$sorts索引
     * @param $order string 排序字段
     * @param $sort  string 排序方式
     *
     * @return array
     */
    public static function sort($index, $order = '', $sort = '') {

        $orderByList = [];

        $orderBys = self::field($index);
        $first = reset($orderBys);
        foreach($orderBys as $idx => $name) {
            $class = '';
            $htmlSort = 'desc';
            if($order == $idx || ($order == '' && $name == $first) ) {
                $class = 'SortCur';
                $htmlSort = 'asc';
            }

            $orderByList[] = '<a href="/'.$index.'/index/?orderby='.$idx.'&sort='.$htmlSort.'" class="'.$class.'">'.$name.'</a>';
        }

        return $orderByList;
    }
}