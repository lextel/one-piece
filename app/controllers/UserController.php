<?php
/*
 *
 *  废弃的代码
 *
 *
 */


namespace app\controllers;
use app\models\Users;

class UserController extends \lithium\action\Controller {

    public function register(){
        $username = $this->request->args[0];
        $password = $this->request->args[1];

        $user = new Users();
        return $user->register($username, $password);
    }

    public function login(){
        $username = $this->request->args[0];
        $password = $this->request->args[1];

        $user = new Users();
        return $user->login($username, $password);
    }

    public function check(){
        $username = $this->request->args[0];

        $user = new Users();
        return $user->check($username);
    }

    public function avatar(){
        $file = $this->request->args[0];
        $user = new Users();

        if(empty($file)){
          return json_encode(['status'=>0]);
        }

        return $user->avatar($file['file']);
    }
}
