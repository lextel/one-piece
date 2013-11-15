<?php
/**
 * 品牌工具
 *
 * @author weelion<weelion@qq.com>
 * @version 1.0
 */
namespace app\extensions\helper;
class Brands {

    /**
     * 品牌与单个分类绑定
     * $brands[1] => [ 1 => [...]]  ID为1的分类的附属品牌
     * (!!! ID一旦固定请勿随便修改，否则URL将有变化)
     *
     * @var array
     */
    static $brands = [
        1 => [
            1 => ['name' => '苹果(Apple)'],
            2 => ['name' => '小米'],
            3 => ['name' => '三星(SAMSUNG)'],
            4 => ['name' => '诺基亚(NOKIA)'],
            5 => ['name' => '索尼(SONY)'],
            6 => ['name' => '魅族(MEIZU)'],
            7 => ['name' => 'OPPO(OPPO)'],
        ],
        2 => [
            8 => ['name' => '尼康(Nikon)'],
            9 => ['name' => '佳能(Canon)'],
            10 => ['name' => 'LG(LG)'],
        ],
        3 => [
            11 => ['name' => '苹果(Apple)'],
        ]
    ];

    /**
     * 根据分类ID获取品牌列表
     *
     * @param $cat_id int 分类ID
     *
     * @return array 品牌数组
     *                [
     *                  1 => ['name' => 'nike'],
     *                  2 => ['name' => '安踏'],
     *                ]
     */
    public static function lists($cat_id) {

        return isset(self::$brands[$cat_id]) ? self::$brands[$cat_id] : [];
    }

}