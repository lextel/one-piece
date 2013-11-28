<?php

namespace app\controllers;

use app\models\Carts;
use app\models\Orders;
use app\extensions\helper\Yeepay;
use lithium\action\DispatchException;

class CartController extends \lithium\action\Controller {

    private $_navCurr = 'cart';

    // 购物车页面
    public function index() {

        $carts = Carts::get();

        // 当前导航
        $navCurr = $this->_navCurr;

        return compact('carts', 'navCurr');
    }


    // 添加购物车
	public function add() {
        $request = $this->request;

        if(isset($request->data['productId']) && isset($request->data['periodId']) && isset($request->data['quantity'])) {
            $data = [
                'id' => $request->data['productId'],
                'periodId' => $request->data['periodId'],
                'quantity' => $request->data['quantity'],
            ];
            Carts::add($data);
        }

        $carts = Carts::get();

        return $this->render(['json' => $carts]);
	}

    // 删除购物车商品
    public function del() {

        $idx = $this->request->data['index'];
        if(!empty($idx)) Carts::del($idx);
        $carts = Carts::get();

        return $this->render(['json' => $carts]);
    }

    // 更新购物车数量
    public function modify() {

        $id = $this->request->data['productId'];
        $periodId = $this->request->data['periodId'];
        $quantity = $this->request->data['quantity'];

        $rs = ['status' => 0, 'remain' => 0];
        if(!empty($id) && !empty($periodId)) {
            $rs = Carts::modify($id, $periodId, $quantity);
        }

        return $this->render(['json' => $rs]);
    }

    // 批量删除购物车商品
    public function batchDel() {
        $ids = $this->request->data['ids'];

        if(!empty($ids)) {
            Carts::batchDel($ids);
        }

        return $this->render(['json' => []]);
    }

    // 支付页面
    public function payment() {

        $carts = Carts::get(true);

        // 当前导航
        $navCurr = $this->_navCurr;

        return compact('carts', 'navCurr');
    }

    // 确认支付
    public function doPay() {

        if($this->request->is('post')) {
            $payBank = $this->request->data['payBank'];
            $yeepay = new Yeepay();
            $data = Carts::pay($payBank);
            extract($data);
            $pr_NeedResponse	= "1";
            $p0_Cmd = $yeepay->p0_Cmd;
            $p1_MerId = $yeepay->p1_MerId;
            $p9_SAF = $yeepay->p9_SAF;
            $hmac = $yeepay->getReqHmacString($p2_Order,$p3_Amt,$p4_Cur,$p5_Pid,$p6_Pcat,$p7_Pdesc,$p8_Url,$pa_MP,$pd_FrpId,$pr_NeedResponse);

            echo <<<EOD
<html>
<head>
<title>跳转到银行...</title>
</head>
<body onLoad="document.yeepay.submit();">
<form name='yeepay' action='{$yeepay->url}' method='post'>
<input type='hidden' name='p0_Cmd'			value='{$p0_Cmd}'>
<input type='hidden' name='p1_MerId'		value='{$p1_MerId}'>
<input type='hidden' name='p2_Order'		value='{$p2_Order}'>
<input type='hidden' name='p3_Amt'			value='{$p3_Amt}'>
<input type='hidden' name='p4_Cur'			value='{$p4_Cur}'>
<input type='hidden' name='p5_Pid'			value='{$p5_Pid}'>
<input type='hidden' name='p6_Pcat'			value='{$p6_Pcat}'>
<input type='hidden' name='p7_Pdesc'		value='{$p7_Pdesc}'>
<input type='hidden' name='p8_Url'			value='{$p8_Url}'>
<input type='hidden' name='p9_SAF'			value='{$p9_SAF}'>
<input type='hidden' name='pa_MP'			value='{$pa_MP}'>
<input type='hidden' name='pd_FrpId'		value='{$pd_FrpId}'>
<input type='hidden' name='pr_NeedResponse'	value='{$pr_NeedResponse}'>
<input type='hidden' name='hmac'			value='{$hmac}'>
</form>
</body>
</html>
EOD;
        }
        return $this->render(['type' => '']);

    }

    // 返回
    public function payResult() {

        // 支付成功处理
        Orders::order();

        echo '支付成功！！！（骗你的）<a href="/">返回</a>';
        die;

        if(isset($_REQUEST['r0_Cmd'])) {
            $yeepay = new Yeepay();
            $return = $yeepay->getCallBackValue($r0_Cmd,$r1_Code,$r2_TrxId,$r3_Amt,$r4_Cur,$r5_Pid,$r6_Order,$r7_Uid,$r8_MP,$r9_BType,$hmac);
            $bRet = $yeepay->CheckHmac($r0_Cmd,$r1_Code,$r2_TrxId,$r3_Amt,$r4_Cur,$r5_Pid,$r6_Order,$r7_Uid,$r8_MP,$r9_BType,$hmac);
            if($bRet){
                if($r1_Code=="1"){
                    if($r9_BType == "1"){
                        $result = '支付成功';
                        return compact('result');
                    } else if($r9_BType == "2") {
                        echo "success";
                        die;
                    }
                }
            } else {

                $result = '支付失败';
                return compact('result');
            }
        }

        return $this->render(['type' => 'text']);
    }
}

?>
