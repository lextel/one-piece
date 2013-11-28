<?php

/*
 *
 *  废弃的代码
 *
 */
namespace app\models;
use MongoClient;
use MongoCursorException;
use app\extensions\helper\Uploader;

class Users extends \lithium\data\Model{

    private $mongo;

    public function __construct(){
      $m = new MongoClient("mongodb://localhost");
      $this->mongo = $m->user_center->user;
    }

    public function check($username){
      $checkUser = $this->mongo->findOne(['username'=>$username]);

      if (empty($checkUser)){
          return json_encode(['check'=>0]);
      }

      return json_encode(['check'=>1]);
    }

    public function register($username, $password){
      try{
          $this->mongo->insert(['username'=>$username,'password'=>$this->password($password)]);
      }catch(MongoCursorException $e){
          return json_encode(['insert'=>0]);
      }

      return json_encode(['insert'=>1]);
    }

    public function login($username, $password){
        $data = $this->mongo->findOne(['username'=>$username,'password'=>$this->password($password)]);

        if(empty($data)){
            return json_encode(['login'=>0]);
        }

        return json_encode(['login'=>1]);
    }

    private function password($password){
      return sha1(md5($password));
    }

    public function avatar($file){
      $uploader = new Uploader();
      $rs = $uploader->upload($file,'avatar',['jpg','png','gif']);

      return json_encode($rs);
    }
}
