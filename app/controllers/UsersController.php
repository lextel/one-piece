<?php

namespace app\controllers;

// use app\models\Users;
use lithium\storage\Session;
use lithium\action\DispatchException;

class UsersController extends \lithium\action\Controller {

    const URL = 'http://www.pp.com/user';

	public function register() {
        
        if($this->request->is('post')) {

            $username = $this->request->data['username'];
            $password = $this->request->data['password'];
            $method   = '/register/';
            $api = self::URL.$method.$username.'/'.$password;

            $rs = file_get_contents($api);
            $rs = json_decode($rs);
            if($rs->insert == 1) {
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
            $method   = '/check/';
            $api = self::URL.$method.$username;
            $rs = file_get_contents($api);
            $rs = json_decode($rs);
            $status = $rs->check == 1 ? 'false' : 'true';

            $this->render(['text' => $status]);
        }
    }

	public function login() {
        $username = $this->request->data['username'];
        $password = $this->request->data['password'];

        $method   = '/login/';
        $api = self::URL.$method.$username.'/'.$password;

        $rs = file_get_contents($api);
        $rs = json_decode($rs);



		
		return $this->render();
	}

    public function center() {

        return $this->render(['layout' => 'user']);
    }


}

?>