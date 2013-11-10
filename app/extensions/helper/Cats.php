<?php

namespace app\extensions\helper;

class Cats {

	/**
	 * 商品分类
	 *
	 * @var array
	 */
	static $cats = [
		'1' => ['name' => '手机'],
		'2' => ['name' => '数码相机'],
		'3' => ['name' => '电脑'],
		'4' => ['name' => '平板电视'],
		'5' => ['name' => '钟表首饰'],
		'6' => ['name' => '其他商品'],
	];

	/**
	 * 分类列表
	 *
	 * @return array 返回 $array[1] = 手机 形式
	 */
	static function cats() {

		$array = [];
		foreach(self::$cats as $key => $cat) {
			$array[$key] = $cat['name'];
		}

		return $array;
	}
}