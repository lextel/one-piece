<?php
/**
 * Lithium: the most rad php framework
 *
 * @copyright     Copyright 2013, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

/**
 * This file contains a series of method filters that allow you to intercept different parts of
 * Lithium's dispatch cycle. The filters below are used for on-demand loading of routing
 * configuration, and automatically configuring the correct environment in which the application
 * runs.
 *
 * For more information on in the filters system, see `lithium\util\collection\Filters`.
 *
 * @see lithium\util\collection\Filters
 */

use lithium\core\Libraries;
use lithium\core\Environment;
use lithium\action\Dispatcher;

/**
 * This filter intercepts the `run()` method of the `Dispatcher`, and first passes the `'request'`
 * parameter (an instance of the `Request` object) to the `Environment` class to detect which
 * environment the application is running in. Then, loads all application routes in all plugins,
 * loading the default application routes last.
 *
 * Change this code if plugin routes must be loaded in a specific order (i.e. not the same order as
 * the plugins are added in your bootstrap configuration), or if application routes must be loaded
 * first (in which case the default catch-all routes should be removed).
 *
 * If `Dispatcher::run()` is called multiple times in the course of a single request, change the
 * `include`s to `include_once`.
 *
 * @see lithium\action\Request
 * @see lithium\core\Environment
 * @see lithium\net\http\Router
 */
Dispatcher::applyFilter('run', function($self, $params, $chain) {
	Environment::set($params['request']);

	foreach (array_reverse(Libraries::get()) as $name => $config) {
		if ($name === 'lithium') {
			continue;
		}
		$file = "{$config['path']}/config/routes.php";
		file_exists($file) ? call_user_func(function() use ($file) { include $file; }) : null;
	}
	return $chain->next($self, $params, $chain);
});


// 日志文件
use lithium\analysis\Logger;
Logger::config(array(
    'default' => array('adapter' => 'Syslog'),
    'badnews' => array(
        'adapter' => 'File',
        'priority' => array('user', 'system')
    )
));

function utf_substr($str,$len){
    for($i=0;$i<$len;$i++){
       $temp_str=substr($str,0,1);
       if(ord($temp_str) > 127){
        $i++;
        if($i<$len){
         $new_str[]=substr($str,0,3);
         $str=substr($str,3);
        }
       }
       else{
        $new_str[]=substr($str,0,1);
        $str=substr($str,1);
       }
    }
    return join($new_str);
}


/**
 * 获取用户真实 IP
 */
function getIP() {
    static $realip;

    if (isset($_SERVER)){
        if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
            $realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } else if (isset($_SERVER["HTTP_CLIENT_IP"])) {
            $realip = $_SERVER["HTTP_CLIENT_IP"];
        } else {
            $realip = $_SERVER["REMOTE_ADDR"];
        }
    } else {
        if (getenv("HTTP_X_FORWARDED_FOR")){
            $realip = getenv("HTTP_X_FORWARDED_FOR");
        } else if (getenv("HTTP_CLIENT_IP")) {
            $realip = getenv("HTTP_CLIENT_IP");
        } else {
            $realip = getenv("REMOTE_ADDR");
        }
    }
 
 
    return $realip;
}

/**
 *  获取IP地区
 *
 * Array
 * (
 *     [country] => 中国
 *     [country_id] => CN
 *     [area] => 华南
 *     [area_id] => 800000
 *     [region] => 广东省
 *     [region_id] => 440000
 *     [city_id] => 440300
 *     [county] => 
 *     [county_id] => -1
 *     [isp] => 电信
 *     [isp_id] => 100017
 *     [ip] => 59.40.132.245
 * )
 */
function getCity($ip) {
$url="http://ip.taobao.com/service/getIpInfo.php?ip=".$ip;
$ip=json_decode(file_get_contents($url)); 
if((string)$ip->code=='1'){
    return false;
  }
  
  $data = (array)$ip->data;
  return $data; 
}


// 隐藏用户名
function hidUsername($username) {

   $names = explode('@', $username);
   $len = strlen($names[0])/2;
   $names[0] = substr_replace($names[0],str_repeat('*',$len),ceil(($len)/2),$len);

   return implode('@', $names);
}

?>