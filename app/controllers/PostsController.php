<?php

namespace app\controllers;

use app\models\Posts;
use app\extensions\helper\Page;
use app\extensions\helper\User;
use lithium\action\DispatchException;

class PostsController extends \lithium\action\Controller {

    const IS_FEED = 2;
    const IS_NOTICE = 3;
    const GET_TOTAL = true;

    public function notice() {
        $postId = $this->request->postId;

        $postModel = new Posts;
        $details = $postModel->noticeDetails($postId);

        return compact('details');
    }

    public function feed() {
        $request  = $this->request;
        $limit    = Page::$page;
        $page     = $request->page ? : 1;
        
        $info = new User;
        $userId = $info->id();

        $conditions = ['from_id' => $userId, 'type_id' => self::IS_FEED];
        $order = ['created' => 'desc'];
        $total = Posts::find('all', compact('conditions'))->count();
        $posts = Posts::find('all', compact('conditions', 'order', 'limit', 'page'))->to('array');

        return $this->render(
                [
                    'data'     => compact('page', 'limit', 'total', 'posts'), 
                    'template' => 'feed', 
                    'layout'   => false
                ]
            );
    }

    public function addFeed() {

        $content  = $this->request->data['content'];

        $info = new User;
        $userId = $info->id();

        $title = '';
        $type_id = self::IS_FEED;
        if($info->role() == 100) {
            $contents = explode("#", $content);
            if(isset($contents[1])) {
                $title = $contents[0];
                $content = $contents[1];
                $type_id = self::IS_NOTICE;
            } 
        }

        $data = [
            'from_id'   => $userId,
            'type_id'   => $type_id,
            'title'     => $title,
            'content'   => $content,
            'parent_id' => 0,
            'status'    => 1,
            'comment'   => 0,
            'created'   => time()
        ]; 

        $post = Posts::create($data);
        $rs = $post->save();

        if($rs) {
            $result = ['status' => 1];
        } else {
            $result = ['status' => 0];
        }

        $this->render(['json' => $result]);
    }

	public function comment() {

		$request  = $this->request;
        $limit    = Page::$page;
        $page     = $request->page ? : 1;
        $postId   = $request->postId;
        $getTotal = self::GET_TOTAL;

        $total = Posts::comment(compact('postId', 'getTotal'));
        $comments = Posts::comment(compact('postId', 'page', 'limit'));

        return $this->render(['data' => compact('page', 'limit', 'total', 'comments'), 'template' => 'comment', 'layout' => false]);
	}

	public function addComment() {

		$parentId = $this->request->data['id'];
		$content  = $this->request->data['content'];


		$post = Posts::find('first', ['conditions' => ['_id' => $parentId]]);
		$post->comment = $post->comment + 1;
		$post->save();

        $info = new User;
        $userId = $info->id();

		$data = [
			'user_id' => $userId,
			'parent_id' => $parentId,
			'content' => $content,
			'created' => time(),
		];

		$post = Posts::create($data);
		$rs = $post->save();

		if($rs) {
			$result = ['status' => 1];
		} else {
			$result = ['status' => 0];
		}

		$this->render(['json' => $result]);
	}
}

?>