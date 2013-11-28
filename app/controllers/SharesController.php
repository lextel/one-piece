<?php

namespace app\controllers;

use app\models\Posts;
use app\extensions\helper\Page;
use app\extensions\helper\Uploader;
use lithium\storage\Session;

class SharesController extends \lithium\action\Controller {

    private $_navCurr = 'share';

    // 晒单列表
	public function index() {

        $request = $this->request;
        $typeId  = $request->typeId ? : 1;
        $page    = $request->page ? : 1;
        $limit   = Page::$page;
        $sort    = isset($request->query['sort']) ? $request->query['sort'] : '';
        $sortBy  = isset($request->query['sortBy']) ? $request->query['sortBy'] : '';

        $status = 1;
        $getTotal = true;
        $total = Posts::shareIndex(compact('status', 'getTotal'));
        $shares = Posts::shareIndex(compact('limit', 'page', 'status', 'sort', 'sortBy'));

        // 当前导航
        $navCurr = $this->_navCurr;

        return compact('shares', 'limit', 'page', 'total', 'typeId', 'navCurr');
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

        // 当前导航
        $navCurr = $this->_navCurr;

        return $this->render(['data' => compact('shares', 'limit', 'page', 'total', 'typeId', 'navCurr'), 'layout' => 'user']);
    }

    public function view() {

        $request   = $this->request;
        $productId = $request->productId;
        $periodId  = $request->periodId;
        $page      = $request->page ? : 1;
        $limit     = Page::$page;

        $share = Posts::shareView($productId, $periodId);
        $share['_id'] = 888;
        $total = Posts::find('all', ['conditions' => ['parent_id' => $share['_id']]])->count();

        $posts = Posts::find('all', ['conditions' => ['parent_id' => $share['_id']], 'page' => $page, 'limit' => $limit])->to('array');

        // 当前导航
        $navCurr = $this->_navCurr;

        return compact('navCurr', 'share', 'limit', 'page', 'total', 'posts');
    }

    // 晒单管理
    public function dashboard() {

        $request = $this->request;
        $typeId  = $request->typeId ? : 1;
        $page    = $request->page ? : 1;
        $limit   = Page::$page;

        $total = Posts::listShares(['typeId' => $typeId, 'getTotal' => true]);
        $shares = Posts::listShares(compact('limit', 'page', 'typeId'));

        // 当前导航
        $navCurr = $this->_navCurr;

        return $this->render(['data' =>compact('shares', 'page', 'limit', 'total', 'typeId', 'navCurr') ,'layout' => 'user']);
    }

    // 审核晒单
    public function check() {

        $request = $this->request;
        $productId = $request->data['productId'];
        $periodId = $request->data['periodId'];

        $rs = Posts::checkShare($productId, $periodId);

        if($rs)
            $return = ['status' => 1];
        else
            $return = ['status' => 0];

        return $this->render(['json' => $return]);
    }

    // 删除晒单
    public function delete() {

        $request = $this->request;
        $productId = $request->data['productId'];
        $periodId = $request->data['periodId'];

        $rs = Posts::deleteShare($productId, $periodId);

        if($rs)
            $return = ['status' => 1];
        else
            $return = ['status' => 0];

        return $this->render(['json' => $return]);
    }

    // 发布晒单
    public function add() {

        $request = $this->request;
        $productId = $request->productId;
        $periodId  = $request->periodId;

        if($request->is('post')) {
            $request->data['type_id'] = Posts::$typeIds['share'];
            if(Posts::add($request->data)) {
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

        // 当前导航
        $navCurr = $this->_navCurr;

        return $this->render(['data' => compact('share', 'navCurr'), 'layout' => 'user']);
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
