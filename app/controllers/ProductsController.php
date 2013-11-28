<?php
/**
 * @author  weelion<weelion@qq.com>
 * @version 1.0
 */
namespace app\controllers;

use app\models\Periods;
use app\models\Products;
use app\models\Carts;
use lithium\storage\Session;
use app\extensions\helper\Page;
use app\extensions\helper\Cats;
use app\extensions\helper\Sort;
use app\extensions\helper\Tags;
use app\extensions\helper\Brands;
use app\extensions\helper\Crumbs;
use app\extensions\helper\Uploader;

class ProductsController extends \lithium\action\Controller {

    private $_navCurr = 'product';


    // 商品列表
    public function index() {

        $request  = $this->request;
        $limit    = Page::$page;
        $page     = $request->page ? : 1;
        $catId    = $request->catId;
        $brandId  = $request->brandId;
        $sort     = isset($request->query['sort']) ? $request->query['sort'] : '';
        $sortBy   = isset($request->query['sortBy']) ? $request->query['sortBy'] : '';
        $status   = 1;
        $getTotal = true;
        $total = Products::lists(compact('catId', 'brandId', 'status', 'getTotal'));
        $products = Products::lists(compact('limit', 'page', 'catId', 'brandId', 'status', 'sort', 'sortBy'), true);

        // 排序标签
        $sortList = Sort::sort('products', compact('catId', 'brandId', 'sort', 'sortBy'));

        // 分类标签
        $cats = Cats::cats();

        // 品牌标签
        $brands = Brands::lists($catId);

        // 面包屑
        $crumbs = Crumbs::get('productList', compact('catId'));

        // 当前导航
        $navCurr = $this->_navCurr;

        $carts = Carts::get();
        $this->set('carts', $carts);

        return compact('products', 'limit', 'page', 'total', 'cats', 'sortList', 'catId', 'brandId', 'brands', 'crumbs', 'navCurr');
    }

    // 商品管理
    public function dashboard() {
        
        $limit = Page::$page;
        $page  = $this->request->page ? : 1;
        $sort = 'created';
        $sortBy = 'desc';

        $getTotal = true;
        $total = Products::lists(compact('getTotal'));
        $products = Products::lists(compact('limit', 'page','sort', 'sortBy'), true);

        $tags = Tags::$tags;

        // 当前导航
        $navCurr = $this->_navCurr;

        return $this->render(['data' => compact('products', 'limit', 'page', 'total', 'navCurr', 'tags'), 'layout' => 'user']);
    }

    // 开奖结果
    public function lottery() {
        
    }

    // 添加商品
    public function add() {

        $data = $this->request->data;
        $cats = Cats::cats();
        $product = Products::create($data);

        if($this->request->is('post')) {
            $rs = Products::add($data);

            if($rs)
                $message = ['status' => 'success', 'message' => '添加成功！'];
            else 
                $message = ['status' => 'success', 'message' => '添加失败！'];

            Session::write('message', $message);

            return $this->redirect('Products::dashboard');
        }

        $navCurr = $this->_navCurr;

        return $this->render(['data' => compact('product', 'cats', 'navCurr'), 'layout' => 'user']);
    }

    // 编辑商品
    public function edit() {

        $id = $this->request->id;
        if(empty($id)) $this->redirect('Products::index');

        $data = $this->request->data;
        $cats = Cats::cats();

        $product = Products::first(['conditions' => ['_id' => $id]]);
        if(empty($product)) return $this->redirect('Page::notfound');

        $brands = [];
        if($product->brand_id) {
            $brands = Brands::lists($product->cat_id);
        }

        if($this->request->is('put')) {
            $productModel = new Products();
            $rs = $productModel->edit($id, $data);

            return $this->redirect('Products::dashboard');
        }

        $catId   = $product->cat_id;
        $brandId = $product->brand_id;

        return $this->render(['data' => compact('product', 'cats', 'brands', 'catId', 'brandId', 'navCurr'), 'layout' => 'user']);
    }

    // 浏览商品
    public function view() {

        $id = $this->request->id;
        $periodId = $this->request->periodId;
        if(empty($id) || empty($periodId))
            return $this->redirect('Products::index');

        $model = new Products();
        $product = $model->view($id, $periodId, true);

        if(empty($product)) {
            return $this->redirect('Products::notfound');
        }

        // 添加人气

        // @TODO 页面渲染用
        $dump = '';
        // ob_start();
        // var_dump($product);
        // $dump = ob_get_clean();

         // 当前导航
        $navCurr = $this->_navCurr;

        return compact('product', 'dump', 'navCurr');
    }


    // 上传商品图片
    public function upload() {

        $data = $this->request->data;
        if(!empty($data) && isset($data['file'])) {
            $file = $data['file'];

            $uploader = new Uploader();
            $result = $uploader->upload($file, 'products', ['jpg', 'png', 'gif']);

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

    // 分类ID获取品牌
    public function brand() {
        $catId = $this->request->catId;

        $brands = Brands::lists($catId);

        return $this->render(['type' => 'json', 'data' => $brands]);
    }

    // 上下架
    public function listing() {

        $id = $this->request->id;
        $status = (int)$this->request->status;
        $tagId = (int) $this->request->tagId;
        $product = Products::find('first', ['conditions' => ['_id' => $id]]);

        $product->status = $status;
        if($tagId) {
            $product->tag_id = $tagId;
        }
        $rs = $product->save();

        if($rs) {
            $result = ['status' => 1];
        } else {
            $result = ['status' => 0];
        }

        return $this->render(['type' => 'json', 'data' => $result]);
    }

    // 限时计划
    public function plan() {

    }

    // 开奖
    public function count() {

    }

}
?>
