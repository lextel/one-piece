<?php

namespace app\models;

use app\models\Carts;
use lithium\storage\Session;
use app\extensions\helper\User;

class Users extends \lithium\data\Model {

    const TIME = 30;    // 无操作

	/**
     * mongodb orders数据结构
     *
     * @var array
     */
    protected $_schema = [
        '_id'        => ['type' => 'id'],            // UUID
        'username'   => ['type' => 'string'],
        'password'   => ['type' => 'string'],
        'nickname'   => ['type' => 'string'],
        'avatar'     => ['type' => 'string'],
        'credits'    => ['type' => 'integer'],       // 积分
        'exp'        => ['type' => 'integer'],       // 经验
        'reg_ip'     => ['type' => 'string'],        // 注册IP 
        'role'       => ['type' => 'integer'],       // 角色
        'cart'       => ['type' => 'array'],         // 购物车
        'address'    => ['type' => 'string'],
        'mobile'     => ['type' => 'string'],
        'realname'   => ['type' => 'string'],
        'zipcode'    => ['type' => 'string'],
        'last_ip'    => ['type' => 'string'],        // 最后登录IP
        'lasted'     => ['type' => 'date'], 		 // 最后登录时间
        'created'    => ['type' => 'date'],          // 注册时间
    ];

	public $validates = array();

    public function register($username, $password){

        $password = $this->_password($password);

        $data = [
            'username' => $username,
            'password' => $password,
            'nickname' => '',
            'realname' => '',
            'address'  => '',
            'zipcode'  => '',
            'mobile'   => '',
            'avatar'   => '',
            'credits'  => 0,
            'exp'      => 0,
            'reg_ip'   => getIP(),
            'role'     => 1,
            'cart'     => Carts::get(),
            'last_ip'  => getIP(),
            'lasted'   => date('Y-m-d H:i:s'),
            'created'  => date('Y-m-d H:i:s'),
        ];

        $user = Users::create($data);
        $rs = $user->save();

        if($rs) {
            $userInfo = [
                'id'       => (string)$user->_id,
                'role'     => 1,
                'username' => $user->username,
                'nickname' => $user->nickname,
                'avatar'   => $user->avatar,
                'time'     => time(),
                'credits'  => 0,
                'exp'      => 0,
                'auth'     => md5((string)$user->_id . $password)
            ];

            Session::write('userInfo', $userInfo);
        }
      
        return $rs;
    }

    public function login($username, $password) {

        $password = $this->_password($password);
        $user = Users::find('first', ['conditions' => ['username' => $username, 'password' => $password]]);

        if(!empty($user)) {

            $user->last_ip = getIp();
            $user->lasted = date('Y-m-d H:i:s');
            $user->save();

            $carts = Carts::get();
            Session::write('cart', []);

            $info = $user->to('array');

            $userInfo = [
                'id'       => (string)$user->_id,
                'role'     => $user->role,
                'nickname' => $user->nickname,
                'avatar'   => $user->avatar,
                'time'     => time(),
                'credits'  => $user->credits,
                'exp'      => $user->exp,
                'auth'     => md5((string)$user->_id . $password),
            ];

            Session::write('userInfo', $userInfo);

            foreach($carts as $cart) {
                Carts::add($cart);
            }
        }

        return $user;
    }

    public function check($username) {

        $rs = Users::find('first', ['conditions' => ['username' => $username]]);

        return !$rs;
    }

    public function auth() {

        $info = new User;
        $id = $info->id();

        if($info->time() < time() - self::TIME * 60) {
            Session::write('userInfo', []);
            return false;
        }

        $userInfo = $info->info();
        $userInfo['time'] = time();
        Session::write('userInfo', $userInfo);

        $user = Users::find('first', ['conditions' => ['_id' => $id], 'fields' => ['password']]);
        $password = $user->password;

        return $info->auth() == md5($id . $password);
    }

    public function logout() {
        Session::write('userInfo', []);
    }

    private function _password($password){
      return sha1(md5($password));
    }

    public function profile($id = 0) {

        if(empty($id)) {
            $info = new User;
            $id = $info->id();
        }

        $userModel = Users::find('first', ['conditions' => ['_id' => $id]]);

        $user = [];
        if($userModel != null) {
            $user = $userModel->to('array');
            $user['avatar']   = !empty($user['avatar']) ? $user['avatar'] : '/images/avatar/5/d/529af03b7572a79415000029.jpg';
            $user['nickname'] = !empty($user['nickname']) ? $user['nickname'] : hidUsername($user['username']);
        }

        return $user;
    }

    public function saveProfile($data) {

        $info = new User;
        $id = $info->id();

        $user = Users::find('first', ['conditions' => ['_id' => $id]]);

        if($data['newpassword'] != $data['repassword']) {
            return false;
        }

        if(!empty($data['password'])) {
            $password = $this->_password($data['password']);
            if($password != $user->password) {
                return false;
            }

            if(!empty($data['newpassword'])) {
                $data['password'] = $this->_password($data['newpassword']);
            }
        } else {
            unset($data['password']);
        }

        if(!empty($data['nickname'])){
            $userInfo = $info->info();
            $userInfo['nickname'] = $data['nickname'];
            Session::write('userInfo', $userInfo);
        }

        unset($data['newpassword'], $data['repassword']);

        return $user->save($data);
    }

    public function oldPassword($password) {

        $info = new User;
        $id = $info->id();

        $password = $this->_password($password);
        $user = Users::find('first', ['conditions' => ['_id' => $id , 'password' => $password]]);

        return $user;

    } 
}

?>