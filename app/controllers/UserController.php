<?php
/**
 *  会员中心
 *
 */
namespace app\controllers;
use app\models\User;

class UserController extends \lithium\action\Controller {

    public function register(){
        $username = $this->request->args[0];
        $password = $this->request->args[1];

        $user = new User();
        return $user->register($username, $password);
    }

    public function login(){
        $username = $this->request->args[0];
        $password = $this->request->args[1];

        $user = new User();
        return $user->login($username, $password);
    }

    public function auth() {
        $id = $this->request->args[0];
        $auth = $this->request->args[1];

        $user = new User();
        return $user->auth($id, $auth);
    }

    public function check(){
        $username = $this->request->args[0];

        $user = new User();
        return $user->check($username);
    }

    public function avatar(){
        $file = $this->request->args[0];
        $user = new User();

        if(empty($file)){
          return json_encode(['status'=>0]);
        }

        return $user->avatar($file['file']);
    }

    public function nick(){
      $username = $this->request->args[0];
      $nick = $this->request->args[1];

      $user = new User();
      return $user->nick($username, $nick);
    }

    public function info(){
      $username = $this->request->args[0];
      $user = new User();

      return $user->info($username);
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
