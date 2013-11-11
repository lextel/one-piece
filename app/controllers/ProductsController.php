<?php
/**
 * @author  weelion<weelion@qq.com>
 * @version 1.0
 */
namespace app\controllers;

use app\models\Products;
use app\extensions\helper\Uploader;
use app\extensions\helper\Page;
use app\extensions\helper\Cats;
use app\extensions\helper\Sort;

class ProductsController extends \lithium\action\Controller {

    // 商品列表
    public function index() {
        $limit = Page::$page;
        $page  = $this->request->page ? : 1;
        $cats = Cats::cats();
        $orderBy = isset($this->request->query['orderby']) ? $this->request->query['orderby'] : '';
        $sort = isset($this->request->query['sort']) ? $this->request->query['sort'] : '';

        $total = Products::lists()->count();
        $products = Products::lists(compact('limit', 'page', 'orderBy', 'sort'));

        $orderByList = Sort::sort('products', $orderBy, $sort);

        return compact('products', 'limit', 'page', 'total', 'cats', 'orderByList');
    }

    // 商品管理
    public function dashboard() {
        $limit = Page::$page;
        $page  = $this->request->page ? : 1;
        $data = $this->request->data;

        $total = Products::lists($data)->count();
        $products = Products::lists(compact('limit', 'page', 'data'));

        return compact('products', 'limit', 'page', 'total');
    }

    // 添加商品
    public function add() {

        $data = $this->request->data;
        $cats = Cats::cats();
        $product = Products::create($data);

        if($this->request->is('post')) {
            $productModel = new Products();
            $rs = $productModel->add($data);

            $this->redirect('Products::dashboard');
        }

        return compact('product','cats');
    }

    // 上传商品图片
    public function upload() {

        $data = $this->request->data;
        if(!empty($data) && isset($data['file'])) {
            $file = $data['file'];

            $uploader = new Uploader();
            $result = $uploader->upload($file, 'products', ['jpg', 'png']);

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

    // 编辑商品
    public function edit() {

        $id = isset($this->request->query['id']) ? $this->request->query['id'] : 0;
        if(empty($id)) $this->redirect('Products::index');

        $data = $this->request->data;
        $cats = Cats::cats();

        $product = Products::first(['conditions' => ['_id' => $id]]);
        if(empty($product)) $this->redirect('Products::notfound');

        if($this->request->is('put')) {
            $productModel = new Products();
            $rs = $productModel->edit($id, $data);

            $this->redirect('Products::dashboard');
        }

        return compact('product', 'cats');
    }

    // 浏览商品
    public function view() {

        $id = isset($this->request->query['id']) ? $this->request->query['id'] : 0;
        if(empty($id)) $this->redirect('Products::index');

        $product = Products::first(['conditions' => ['_id' => $id]]);

        if(empty($product)) {
            $this->redirect('Products::notfound');
        }

        $this->set(compact('product'));
        $view =  $this->render(['type' => 'html', 'template' => 'view_normal']);

        return $view;
    }

    // 没有商品
    public function notfound() {
        echo '产品没找到';

        return $this->render(['type' => 'text']);
    }

}
?>
