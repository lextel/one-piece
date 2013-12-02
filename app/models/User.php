<?php
/*
 *
 *  用户数据模型
 *
 */
namespace app\models;
use MongoClient;
use MongoId;
use MongoCursorException;
use app\extensions\helper\Uploader;

class User extends \lithium\data\Model{

    private $mongo;

    public function __construct(){
      $m = new MongoClient("mongodb://localhost");
      $this->mongo = $m->user_center->user;
    }

    public function check($username){
      $checkUser = $this->mongo->findOne(['username'=>$username]);

      if (empty($checkUser)){
          return json_encode(['check'=>1]);
      }

      return json_encode(['check'=>0]);
    }

    public function register($username, $password){
      try{
          $data = ['username'=>$username,'password'=>$this->password($password)];
          $this->mongo->insert($data);
      }catch(MongoCursorException $e){
          return json_encode(['insert'=>0]);
      }

      return json_encode(['insert'=>1, 'id' => (string)$data['_id']]);
    }

    public function login($username, $password){
        $data = $this->mongo->findOne(['username'=>$username,'password'=>$this->password($password)]);

        if(empty($data)){
            return json_encode(['login'=>0]);
        }

        return json_encode(['login'=>1, 'id' => (string)$data['_id'], 'auth' => md5((string)$data['_id'] . $data['password'])]);
    }

    public function auth($id, $auth) {

      $id = new MongoId($id);
      $data = $this->mongo->findOne(['_id'=>$id], ['password' => 1, '_id' => 0]);
      if(md5($id . $data['password']) != $auth) {
          return json_encode(['login' => 0]);
      }

      return json_encode(['login' => 1]);
    }

    private function password($password){
      return sha1(md5($password));
    }

    public function avatar($file){
      $uploader = new Uploader();
      $rs = $uploader->upload($file,'avatar',['jpg','png','gif']);

      if($rs['status']){
        return $this->saveAvatar($rs);
      }

      return json_encode($rs);
    }

    private function saveAvatar($avatar){
      try{
        $data = $this->mongo->update(['username'=>$username],['$set'=>['avatar'=>$avatar['path']]]);
      } catch(MongoCursorException $e){
        return json_encode(['status'=>false]);
      } catch(MongoCursorTimeoutException $time){
        return json_encode(['status'=>false]);
      }

      if(!$data['updatedExisting']){
        return json_encode(['status'=>false]);
      }

      $data = $this->mongo->findOne(['username'=>$username],['avatar']);
      return json_encode($data);
    }

    public function nick($username, $nick){
      try{
        $data = $this->mongo->update(['username'=>$username],['$set'=>['nick'=>$nick]]);
      } catch(MongoCursorException $e){
        return json_encode(['nick'=>0]);
      } catch(MongoCursorTimeoutException $time){
        return json_encode(['nick'=>0]);
      }

      if(!$data['updatedExisting']){
        return json_encode(['nick'=>0]);
      }

      $data = $this->mongo->findOne(['username'=>$username],['nick']);
      return json_encode($data);
    }

    public function info($username){
      $info = $this->mongo->findOne(['username'=>$username]);

      if(empty($info)){
        return json_encode(['info'=>0]);
      }

      return json_encode($info);
    }
}
