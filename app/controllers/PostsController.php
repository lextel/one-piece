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
        // $postId   = $request->postId;

        $postId = 888;
        // $limit = 2;

        $total = Posts::find('all', ['conditions' => ['parent_id' => $postId]])->count();
        $posts = Posts::find(
        	'all', [
        	'conditions' => ['parent_id' => $postId], 
        	'order' => ['created'=>'desc'], 
        	'limit' => $limit, 
        	'page' => $page]
        	)->to('array');


        return compact('page', 'limit', 'total', 'posts');
	}

	public function add() {

		$data = [
			'user_id' => 1,
			'parent_id' => 888,
			'content' => '9999999ccccc',
			'created' => time(),

		];

		$post = Posts::create($data);
		$post->save();

		exit;
	}

}

?>