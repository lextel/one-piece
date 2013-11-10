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
use lithium\action\DispatchException;
use lithium\util\Inflector;

class ProductsController extends \lithium\action\Controller {

    // 商品列表
    public function index() {
        $limit = Page::$page;
        $page  = $this->request->page ? : 1;
        $cats = Cats::cats();
        $data['orderby'] = isset($this->request->query['orderby']) ? $this->request->query['orderby'] : '';
        $data['sort'] = isset($this->request->query['sort']) ? $this->request->query['sort'] : '';

        $total = Products::lists($data)->count();
        $products = Products::lists(compact('limit', 'page', 'data'));

        return compact('products', 'limit', 'page', 'total', 'cats');
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

        $error = [];
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

        // 上传组件IE采用Iframe模式西药返回文件头text/plain
        if(isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false) {
            header('Content-type: application/json');
        } else {
            header('Content-type: text/plain');
        }

        return $this->render(['json' => $result]);
    }

    // 编辑商品
    public function edit() {
        $id = $this->request->args[0];
        $data = $this->request->data;
        $cats = Cats::cats();

        $product = Products::first(['conditions' => ['_id' => $id]]);

        if($this->request->is('put')) {
            $productModel = new Products();
            $rs = $productModel->edit($id, $data);

            $this->redirect('Products::dashboard');
        }

        return compact('product', 'cats');
    }

    // 删除商品
    public function delete() {

    }

}
?>
