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

    public function sample(){
        $username = $this->request->args[0];
        $password = $this->request->args[1];

        return $this->sampleLogin($username, $password);
    }

    const URL = 'http://localhost:8000/user';
    public function sampleLogin($username,$password){
      $method = '/login/';

      $api = self::URL.$method.$username.'/'.$password;
      $api = http_parse_message(http_get($api));
      return $api->body;
    }
}
