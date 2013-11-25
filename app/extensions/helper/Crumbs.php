<?php
/**
 * 面包屑工具
 *
 * @author weelion<weelion@qq.com>
 * @version 1.0
 */
namespace app\extensions\helper;

use app\extensions\helper\Cats;

class Crumbs {

	/**
	 * 面包屑
	 *
	 * @param $type    string 类型
	 * @param $options array  参数
	 * 
	 * @return string
	 */
	public static function get($type, $options) {

		switch ($type) {
			case 'productList':
				$crumb = self::_productList($options);
				break;
			
			default:
				$crumb = '';
				break;
		}

		return $crumb;
	}


	/**
	 * 商品列表面包屑
	 *
	 * @param $options array 参数
	 *
	 * @return string
	 */
	private function _productList($options) {

		if(isset($options['catId']) && !empty($options['catId'])) {
			return Cats::name($options['catId']);
		} else {
			return '所有分类';
		}
	}

}