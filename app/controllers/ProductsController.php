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
use app\extensions\helper\Brands;

class ProductsController extends \lithium\action\Controller {

    // 商品列表
    public function index() {
        $request  = $this->request;
        $limit    = Page::$page;
        $cats     = Cats::cats();
        $page     = $request->page ? : 1;
        $cat_id   = $request->cat_id;
        $brand_id = $request->brand_id;
        $orderBy  = isset($request->query['orderby']) ? $request->query['orderby'] : '';
        $sort     = isset($request->query['sort']) ? $request->query['sort'] : '';

        $total = Products::lists(compact('cat_id', 'brand_id'))->count();
        $products = Products::lists(compact('limit', 'page', 'cat_id', 'brand_id', 'orderBy', 'sort'), true);

        // 排序LIST
        $orderByList = Sort::sort('products',$cat_id, $brand_id, $orderBy, $sort);

        // 品牌
        $brands = Brands::lists($cat_id);

        return compact('products', 'limit', 'page', 'total', 'cats', 'orderByList', 'cat_id', 'brand_id', 'brands');
    }

    // 商品管理
    public function dashboard() {
        $limit = Page::$page;
        $page  = $this->request->page ? : 1;
        $orderBy = 'created';
        $sort = 'desc';

        $total = Products::lists()->count();
        $products = Products::lists(compact('limit', 'page','orderBy', 'sort'), true);

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

        $id = $this->request->id;
        if(empty($id)) $this->redirect('Products::index');

        $data = $this->request->data;
        $cats = Cats::cats();

        $product = Products::first(['conditions' => ['_id' => $id]]);
        if(empty($product)) return $this->redirect('Products::notfound');

        if($this->request->is('put')) {
            $productModel = new Products();
            $rs = $productModel->edit($id, $data);

            return $this->redirect('Products::dashboard');
        }

        return compact('product', 'cats');
    }

    // 浏览商品
    public function view() {

        $id = $this->request->id;
        if(empty($id))
            return $this->redirect('Products::index');

        $product = Products::first(['conditions' => ['_id' => $id]]);

        if(empty($product)) {
            return $this->redirect('Products::notfound');
        }

        $this->set(compact('product'));
        $view =  $this->render(['type' => 'html', 'template' => 'view_normal']);

        return $view;
    }

    // 分类ID获取品牌
    public function brand() {
        $cat_id = $this->request->cat_id;

        $brands = Brands::lists($cat_id);

        return $this->render(['type' => 'json', 'data' => $brands]);
    }

    // 没有商品
    public function notfound() {
        echo '产品没找到';

        return $this->render(['type' => 'text']);
    }

}
?>
