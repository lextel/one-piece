<?php
/**
 * @author  weelion<weelion@qq.com>
 * @version 1.0
 */
namespace app\controllers;

use app\models\Periods;
use app\models\Products;
use app\models\Orders;
use app\models\Carts;
use lithium\storage\Session;
use app\extensions\helper\Page;
use app\extensions\helper\Cats;
use app\extensions\helper\Sort;
use app\extensions\helper\Tags;
use app\extensions\helper\Brands;
use app\extensions\helper\Crumbs;
use app\extensions\helper\Uploader;
use app\extensions\helper\MongoClient;

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

        $productId = $this->request->productId;
        $periodId  = $this->request->periodId;

        $model = new Products();
        $product = $model->view($productId, $periodId);

        $result = ['status' => 0];
        if(
            $product['periods'][0]['remain'] == 0 && 
            $product['periods'][0]['showed'] < time() && 
            $product['periods'][0]['status'] == 2
          )
        {
           $result = [
                    'status' => 1, 
                    'code'   => str_split($product['periods'][0]['code']+10000001), 
                    'userId' => $product['periods'][0]['user_id'],
                    'ordered' => date('Y-m-d H:i:s',$product['periods'][0]['ordered']),
                    'showed' => date('Y-m-d H:i:s',$product['periods'][0]['showed']),
                    ];

        }

        $result = ['status' => 1];

        $this->render(['json' => $result]);
    }

    // 开奖脚本
    public function crontab() {
        set_time_limit(0);
        while (true) {

            // 获得所有可以开奖的商品期数
            $mo = new MongoClient();
            $data = $mo->getConn()->find(['periods' => ['$elemMatch' => ['status' => 0, 'remain' => 0, 'showed' => ['$ne' => 0, '$lte' => time()]]]], ['periods']);
            $products = iterator_to_array($data);

            foreach($products as $id => $product) {
                foreach($product['periods'] as $period) {
                    if($period['showed'] < time() && $period['status'] == 0 && $period['remain'] == 0) {

                        $info = Orders::winnerInfo($period['ordered'], $period['person']);
                        $userId = Orders::winnerUser($id, $period['id'], $info['code']);

                        $idx = $period['id'] - 1;
                        $query = [
                        '$set' => [
                                'periods.'.$idx.'.results' => $info['results'],
                                'periods.'.$idx.'.total'   => $info['total'],
                                'periods.'.$idx.'.code'    => $info['code'],
                                'periods.'.$idx.'.user_id' => $userId,
                                'periods.'.$idx.'.status'  => 2,
                               ]
                        ];

                        $conditions = ['_id' => $id];
                        Products::update($query, $conditions, ['atomic' => false]);
                    }
                }
            }
        

            sleep(1);
        }

        $this->render(['text' => '计划任务']);

    }

    // 添加商品
    public function add() {

        $data = $this->request->data;
        $cats = Cats::cats();
        $tags = Tags::tags();

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

        return $this->render(['data' => compact('product', 'cats', 'tags', 'navCurr'), 'layout' => 'user']);
    }

    // 编辑商品
    public function edit() {

        $id = $this->request->id;
        if(empty($id)) $this->redirect('Products::index');

        $data = $this->request->data;
        $cats = Cats::cats();
        $tags = Tags::tags();

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

        $tagId   = $product->tagId;
        $catId   = $product->cat_id;
        $brandId = $product->brand_id;

        return $this->render(['data' => compact('product', 'cats', 'tags', 'brands', 'tagId','catId', 'brandId', 'navCurr'), 'layout' => 'user']);
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
