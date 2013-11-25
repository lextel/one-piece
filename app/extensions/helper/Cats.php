<?php
/**
 * 分类工具
 *
 * @author weelion<weelion@qq.com>
 * @version 1.0
 */
namespace app\extensions\helper;

class Cats {

	/**
	 * 商品分类
	 *
	 * @var array
	 */
	static $cats = [
		'1' => [
            'name' => '手机',
            'children' => [
                '7' => ['name' => '手机'],
            ],
        ],
		'2' => [
            'name' => '数码相机',
            'children' => [
                '8' => ['name' => '单反'],
                '9' => ['name' => '卡片'],
            ]
        ],
		'3' => [
            'name' => '电脑',
            'children' => [
                '10' => ['name' => '台式'],
                '11' => ['name' => '品牌'],
            ]
        ],
		'4' => ['name' => '平板电视'],
		'5' => ['name' => '钟表首饰'],
		'6' => ['name' => '其他商品'],
	];

	/**
	 * 一级分类
	 *
	 * @return array 返回 $array[1] = 手机 形式
	 */
	public static function cats() {

		$array = [];
		foreach(self::$cats as $key => $cat) {
			$array[$key] = $cat['name'];
		}

		return $array;
	}

	/**
	 * 获取一级分类名字
	 *
	 * @param $id integer ID
	 *
	 * @return string
	 */
	public static function name($id) {
		
		return self::$cats[$id]['name'];
	}
}