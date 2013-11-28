<?php

namespace app\controllers;

use app\models\Posts;
use app\extensions\helper\Page;
use lithium\action\DispatchException;

class PostsController extends \lithium\action\Controller {

    public function feed() {
        $request  = $this->request;
        $limit    = Page::$page;
        $page     = $request->page ? : 1;
        
        $userId = USER_ID;

        $conditions = ['from_id' => $userId, 'type_id' => 2];
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

        $data = [
            'from_id'   => USER_ID,
            'type_id'   => 2,
            'parent_id' => 0,
            'content'   => $content,
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


		$post = Posts::find('first', ['conditions' => ['_id' => $parentId]]);
		$post->comment++;
		$post->save();

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