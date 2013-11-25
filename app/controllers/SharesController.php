<?php

namespace app\controllers;

use app\models\Posts;
use app\extensions\helper\Page;
use app\extensions\helper\Uploader;
use lithium\storage\Session;

class SharesController extends \lithium\action\Controller {

    // 晒单列表
	public function index() {

	}

    // 我的晒单列表
    public function share() {
        $request = $this->request;
        $typeId  = $request->typeId ? : 1;
        $page    = $request->page ? : 1;
        $limit   = Page::$page;

        $userId = USER_ID;
        $total = Posts::myShare(['userId' => $userId, 'typeId' => $typeId, 'getTotal' => true]);
        $shares = Posts::myShare(compact('limit', 'page', 'userId', 'typeId'));

        return $this->render(['data' => compact('shares', 'limit', 'page', 'total', 'typeId'), 'layout' => 'user']);
    }

    // 发布晒单
    public function add() {
        $request = $this->request;
        $productId = $request->productId;
        $periodId  = $request->periodId;

        if($request->is('post')) {
            $postsModel = new Posts();
            if($postsModel->save($request->data)) {
                $message = ['status' => 'success', 'message' => '晒单成功，审核后可以得到1000福分哦！'];
            } else {
                $message = ['status' => 'fail', 'message' => '晒单失败！'];
            }

            Session::write('message', $message);

            return $this->redirect('Shares::share');
        }

        if(empty($productId) || empty($periodId)) {
            return $this->redirect('Shares::share');
        }

        $share = Posts::share($productId, $periodId, USER_ID);
        $share['productId'] = $productId;

        if(empty($share)) {
            return $this->redirect('Shares::share');
        }

        return $this->render(['data' => compact('share'), 'layout' => 'user']);
    }

    // 晒单管理
    public function dashboard() {
        $request = $this->request;
        $page    = $request->page ? : 1;
        $limit   = Page::$page;

        $total = 0;

        return $this->render(['data' =>compact('page', 'limit', 'total') ,'layout' => 'user']);
    }

    // 上传晒单图片
    public function upload() {

        $data = $this->request->data;
        if(!empty($data) && isset($data['file'])) {
            $file = $data['file'];

            $uploader = new Uploader();
            $result = $uploader->upload($file, 'shares', ['jpg', 'png', 'gif']);

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

}

?>
