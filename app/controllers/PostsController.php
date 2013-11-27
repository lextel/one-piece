<?php

namespace app\controllers;

use app\models\Posts;
use app\extensions\helper\Page;
use lithium\action\DispatchException;

class PostsController extends \lithium\action\Controller {

	public function comment() {

		$request  = $this->request;
        $limit    = Page::$page;
        $page     = $request->page ? : 1;
        $postId   = $request->postId;

        // $postId = 888;
        // $limit = 2;

        $total = Posts::find('all', ['conditions' => ['parent_id' => $postId]])->count();
        $posts = Posts::find(
        	'all', [
        	'conditions' => ['parent_id' => $postId], 
        	'order' => ['created'=>'desc'], 
        	'limit' => $limit, 
        	'page' => $page]
        	)->to('array');


        return $this->render(['data' => compact('page', 'limit', 'total', 'posts'), 'template' => 'comment', 'layout' => false]);
	}

	public function addComment() {

		$parentId = $this->request->data['id'];
		$content  = $this->request->data['content'];

		$data = [
			'user_id' => USER_ID,
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