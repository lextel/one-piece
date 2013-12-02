<?php

namespace app\extensions\helper;

use app\models\Users;
use lithium\storage\Session;

class User extends \lithium\template\Helper {

	private $_info;
	private $_id;
	private $_nickname;
	private $_role;
	private $_credits;
	private $_exp;
	private $_auth;
	private $_time;
	private $_avatar;

	public function __construct() {

		$userInfo = Session::read('userInfo');

		if(empty($userInfo)) {
			$userInfo = [
				'id'       => 0, 
				'nickname' => '', 
				'role'     => 0,
				'credits'  => 0,
				'exp'      => 0,
				'auth'     => '',
				'time'     => 0
				];
		} else {
			extract($userInfo);

			$this->_info = $userInfo;
			$this->_user     = Users::find('first', ['conditions' => ['_id' => $id]]);
			$this->_id       = $id;
			$this->_nickname = $this->_user->nickname;
			$this->_avatar   = $this->_user->avatar;
			$this->_role     = $this->_user->role;;
			$this->_credits  = $this->_user->credits;
			$this->_exp      = $this->_user->exp;
			$this->_auth     = $auth;
			$this->_time     = $time;
		}
		
	}

	public function info() {

		return $this->_info;
	}

	public function id() {

		return $this->_id;
	}

	public function nickname() {

		return $this->_nickname ? $this->_nickname : '还木有昵称';
	}

	public function credits() {

		return $this->_credits;
	}

	public function role() {

		return $this->_role;
	}

	public function avatar() {
		
		return  $this->_avatar;
	}

	public function level() {

		$levels = [
			'1' => ['range' => '0-10000',           'name' => '云购小将'],
			'2' => ['range' => '10001-50000',       'name' => '云购少将'],
			'3' => ['range' => '50001-200000',      'name' => '云购中将'],
			'4' => ['range' => '200001-500000',     'name' => '云购上将'],
			'5' => ['range' => '500001-1000000',    'name' => '云购大将'],
			'6' => ['range' => '1000001-100000000', 'name' => '云购将军'],
		];

		foreach($levels as $k => $level) {
			$range = explode('-', $level['range']);
			if($range[0] <= $this->_exp && $range[1] <= $this->_exp) {
				return ['id' => $k, 'name' => $level['name']];
			}
		}
	}

	public function exp() {

		return $this->_exp;
	}

	public function auth() {

		return $this->_auth;
	}

	public function time() {

		return $this->_time;
	}



}