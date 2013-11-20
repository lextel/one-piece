<?php
/**
 * @author  weelion<weelion@qq.com>
 * @version 1.0
 */
namespace app\controllers;

use app\models\Products;
use app\models\Periods;
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
        $catId    = $request->catId;
        $brandId  = $request->brandId;
        $orderBy  = isset($request->query['orderby']) ? $request->query['orderby'] : '';
        $sort     = isset($request->query['sort']) ? $request->query['sort'] : '';

        $total = Products::lists(compact('catId', 'brand_id'))->count();
        $products = Products::lists(compact('limit', 'page', 'catId', 'brandId', 'orderBy', 'sort'), true);

        // 排序LIST
        $orderByList = Sort::sort('products',$catId, $brandId, $orderBy, $sort);

        // 品牌
        $brands = Brands::lists($catId);

        return compact('products', 'limit', 'page', 'total', 'cats', 'orderByList', 'catId', 'brandId', 'brands');
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
        $periodId = $this->request->periodId;
        if(empty($id) || empty($periodId))
            return $this->redirect('Products::index');

        $model = new Products();
        $product = $model->view($id, $periodId, true);

        if(empty($product)) {
            return $this->redirect('Products::notfound');
        }

        // @TODO 页面渲染用
        $dump = '';
        // ob_start();
        // var_dump($product);
        // $dump = ob_get_clean();

        return compact('product', 'dump');
    }

    // 分类ID获取品牌
    public function brand() {
        $catId = $this->request->catId;

        $brands = Brands::lists($catId);

        return $this->render(['type' => 'json', 'data' => $brands]);
    }

    // 新增一期
    public function newPeriod() {

        $id = '5289e84eb8fbc3881500003f';
        $periodId = Periods::autoId($id);
        $query = [
                 '$push'=> ['periods'=>[
                     'id' => $periodId,
                     'price' => '5388.00',
                     'person' => '5388',
                     'remain' => '5388',
                     'hits' => '1',
                     'code' => '',
                     'created' => time(),
                     'showed'=> '',
                     'status' => 0,
                    ]
                 ]
            ];
        $conditions = ['_id'=> $id];
        $rs = Products::update($query, $conditions,['atomic' => false]);
        var_dump($rs);

        exit;
    }

    // 没有商品
    public function notfound() {
        echo '产品没找到';

        return $this->render(['type' => 'text']);
    }

}
?>
