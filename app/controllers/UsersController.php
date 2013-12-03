<?php

namespace app\controllers;

use app\models\Users;
use lithium\storage\Session;
use app\extensions\helper\User;
use app\extensions\helper\Uploader;
use lithium\action\DispatchException;

class UsersController extends \lithium\action\Controller {

	public function register() {
        
        if($this->request->is('post')) {

            $username = $this->request->data['username'];
            $password = $this->request->data['password'];

            $user = new Users;
            $rs = $user->register($username, $password);

            if($rs) {
                return $this->redirect('/users/center');
            } else {
                $message = ['status' => 'fail', 'message' => '注册失败'];
                Session::write('message', $message);
                return $this->redirect('/users/register');
            }
        }
	}

    public function check() {

        if($this->request->is('get')) {
            $username = $this->request->query['username'];
            
            $user = new Users;
            $rs = $user->check($username);

            $status = $rs ? 'true' : 'false';

            $this->render(['text' => $status]);
        }
    }

	public function login() {

        if($this->request->is('post')) {

            $username = $this->request->data['username'];
            $password = $this->request->data['password'];

            $user = new Users;
            $rs = $user->login($username, $password);

            if($rs) {
                return $this->redirect('/users/center');

            } else {
                $message = ['status' => 'fail', 'message' => '登录失败'];
                Session::write('message', $message);
                return $this->redirect('/users/login');
            }
        }

	}

    public function center() {

        $user = new Users;
        if(!$user->auth()) {
            return $this->redirect('Users::login');
        }

        return $this->render(['layout' => 'user']);
    }

    public function profile() {

        $userModel = new Users;
        if($this->request->is('post')) {
            $rs = $userModel->saveProfile($this->request->data);
            if($rs) {
                $message = ['status' => 'success', 'message' => '修改成功'];
                
                return $this->redirect('users::center');
            } else {
                $message = ['status' => 'fail', 'message' => '修改失败'];
            }

            Session::write('message', $message);
        }

        $user = $userModel->profile();

        return compact('user');
    }

    public function info() {

        $userId = $this->request->userId;
        if(empty($userId)) {
            $info = new User();
            $userId = $info->id();
        }

        $userModel = new Users();
        $user = $userModel->profile($userId);

        return compact('user');
    }

    public function message() {
        echo '编写中...';
        die;
    }

    // 上传商品图片
    public function upload() {

        $data = $this->request->data;
        if(!empty($data) && isset($data['file'])) {
            $file = $data['file'];

            // 替换成会员ID
            $info = new User;
            $id = $info->id();
            $name = substr($file['name'], 0, -4);
            $file['name'] = str_replace($name, $id, $file['name']);

            $uploader = new Uploader();
            $result = $uploader->upload($file, 'avatar', ['jpg', 'png', 'gif']);

        }else{

            $result = ['status' => false];
        }

        // 上传组件IE采用Iframe模式需要返回文件头text/plain
        if(isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false) {
            header('Content-type: application/json');
        } else {
            header('Content-type: text/plain');
        }

        return $this->render(['json' => $result]);
    }

    public function oldPassword() {

        $password = $this->request->query['password'];

        $user = new Users;
        $rs = $user->oldPassword($password);

        $this->render(['text' => $rs ? 'true' : 'false']);
    }

    public function logout() {

        $user = new Users;
        $user->logout();

        return $this->redirect('/');
    }

    public function recharge() {

        return $this->render(['layout' => 'user']);
    }

    public function doRecharge() {
        $money = $this->request->data['money'];
        $info = new User;
        $id = $info->id();

        $user =  Users::find('first', ['conditions' => ['_id' => $id]]);
        $user->credits = $user->credits + $money * CREDITS;
        $user->save();
        die('充值成功');

    }
}

?>