<?php
$this->styles($this->resLoader->css('cartlist.css'));
?>
<div class="shop_payment">
    <ul class="payment">
        <li class="first_step">第一步：提交订单</li>
        <li class="arrow_1"></li>
        <li class="secend_step orange_Tech">第二步：网银支付</li>
        <li class="arrow_3"></li>
        <li class="third_step">第三步：支付成功 等待揭晓</li>
        <li class="arrow_2"></li>
        <li class="fourth_step">第四步：揭晓获得者</li>
        <li class="arrow_2"></li>
        <li class="fifth_step">第五步：晒单奖励</li>
    </ul>
    <input type="hidden" id="hidBalance" value="0.00"/>
    <input type="hidden" id="hidCountMoney" value="1.00"/>
    <input type="hidden" id="hidPoints" value="10.00"/>
    <input type="hidden" id="hidAvailablePoints" value="0"/>
    <div class="payment_Con">
        <ul class="order_list">
            <li class="top">
                <span class="name">商品名称</span>
                <span class="moneys">价值</span>
                <span class="money">云购价</span>
                <span class="num">云购人次</span>
                <span class="all">小计</span>
            </li>
            <?php
                $price = 0;
                foreach($carts as $cart) {
                    $price += $cart['quantity'];
            ?>
            <li class="end">
                <span class="name">
                    <a class="blue" href="/products/view/<?php echo $cart['id'].'/'.$cart['periodId'];?>"  title="<?php echo $cart['title'];?>"><?php echo $cart['title'];?></a>
                </span>
                <span class="moneys">￥<?php echo sprintf('%.2f',$cart['price']); ?></span>
                <span class="money">￥1.00</span>
                <span class="num orange Fb"><?php echo $cart['quantity'] ?></span>
                <span class="all"><?php echo sprintf('%.2f',$cart['quantity']); ?></span>
            </li>
            <?php
                }
            ?>
            <li class="payment_Total">
                <div class="payment_List_Lc"><a href="/cart/index" class="form_ReturnBut">返回购物车修改订单</a></div>
                <p class="payment_List_Rc">商品合计：<span class="orange F20"><?php echo sprintf('%.2f',$price); ?></span> 元</p>
            </li>
            <li id="liPayByOther" class="point_in point_bank">
                <div class="payment_List_Lc gary01 Fb">您的账户余额不足，请选择以下方式完成支付</div>
                <p class="payment_List_Rc">网银支付：<span class="orange F20"><?php echo sprintf('%.2f',$price); ?></span> 元</p>
            </li>
        </ul>
    </div>
    <div class="pay_bankC" id="divBankList">
        <div class="bank_arrow"><span>◆</span><em>◆</em></div>
        <h2>银行支付：</h2>
        <ul class="bank_logo">
            <li>
                <input type="radio" value="CMBCHINA-NET-B2C" name="account" id="bankType1001" checked="checked" />
                <label for="bankType1001"><span class="zh_bank"></span></label>
            </li>
            <li>
                <input type="radio" value="ICBC-NET-B2C" name="account" id="bankType1002" />
                <label for="bankType1002"><span class="gh_bank"></span></label>
            </li>
            <li>
                <input type="radio" value="CCB-NET-B2C" name="account" id="bankType1003" />
                <label for="bankType1003"><span class="jh_bank"></span></label>
            </li>
            <li>
                <input type="radio" value="ABC-NET-B2C" name="account" id="bankType1005" />
                <label for="bankType1005"><span class="nh_bank"></span></label>
            </li>
            <li>
                <input type="radio" value="SPDB-NET-B2C" name="account" id="bankType1004" />
                <label for="bankType1004"><span class="pf_bank"></span></label>
            </li>
            <li>
                <input type="radio" value="SDB-NET-B2C" name="account" id="bankType1008" />
                <label for="bankType1008"><span class="sf_bank"></span></label>
            </li>
            <li>
                <input type="radio" value="CIB-NET-B2C" name="account" id="bankType1009" />
                <label for="bankType1009"><span class="xy_bank"></span></label>
            </li>
            <li>
                <input type="radio" value="BCCB-NET-B2C" name="account" id="bankType1032" />
                <label for="bankType1032"><span class="bj_bank"></span></label>
            </li>
            <li>
                <input type="radio" value="CEB-NET-B2C" name="account" id="bankType1022" />
                <label for="bankType1022"><span class="gd_bank"></span></label>
            </li>
            <li>
                <input type="radio" value="CMBC-NET-B2C" name="account" id="bankType1006" />
                <label for="bankType1006"><span class="ms_bank"></span></label>
            </li>
            <li>
                <input type="radio" value="ECITIC-NET-B2C" name="account" id="bankType1021" />
                <label for="bankType1021"><span class="zx_bank"></span></label>
            </li>
            <li>
                <input type="radio" value="GDB-NET-B2C" name="account" id="bankType1027" />
                <label for="bankType1027"><span class="gf_bank"></span></label>
            </li>
            <li>
                <input type="radio" value="PINGANBANK-NET" name="account" id="bankType1010" />
                <label for="bankType1010"><span class="pa_bank"></span></label>
            </li>
            <li>
                <input type="radio" value="BOC-NET-B2C" name="account" id="bankType1052" />
                <label for="bankType1052"><span class="zg_bank"></span></label>
            </li>
            <li>
                <input type="radio" value="BOCO-NET-B2C" name="account" id="bankType1020" />
                <label for="bankType1020"><span class="jt_bank"></span></label>
            </li>
        </ul>

        <h3 class="bor"><!--支付平台支付：--></h3>
        <ul>
            <!--li>
                <input type="radio" value="Tenpay" name="account" id="Tenpay" />
                <label for="Tenpay"><span class="cft"></span></label>
            </li>
            <li>
                <input type="radio" value="Chinabank" name="account" id="Chinabank" />
                <label for="Chinabank"><span class="wy"></span></label>
            </li>
            <li>
                <input type="radio" value="QuickMoney" name="account" id="QuickMoney" />
                <label for="QuickMoney"><span class="kq"></span></label>
            </li>
            <li>
                <input type="radio" value="Unionpay" name="account" id="Unionpay"/>
                <label for="Unionpay"><span class="online"></span></label>
            </li>
            <li>
                <input type="radio" value="Alipay" name="account" id="Alipay" />
                <label for="Alipay"><span class="zfb"></span></label>
            </li>
            <li>
                <input type="radio" name="account" id="Unionpay" />
                <span class="yl"></span>
            </li-->
        </ul>

    </div>
    <form id="toPayForm" name="toPayForm" action="/cart/doPay" method="post" target="_blank">
        <!--input type="hidden" id="hidPayName" name="payName" value="" /-->
        <input type="hidden" id="hidPayBank" name="payBank" value="CMBCHINA-NET-B2C" />
        <!--input type="hidden" id="hidUseBalance" name="useBalance" value="" /-->
        <!-- 不使用福分时，值为0；使用福分时，值为使用福分值 2012.4.28-->
        <!--input type="hidden" id="hidIntegral" name="integral" value="0" /-->
        <div class="payment_but">
            <p id="pNewPointNum" class="pay_but_txt">&nbsp;</p>
            <input id="submit_ok" class="shop_pay_but" type="submit" name="submit" value="" />
        </div>
    </form>
    <div class="answer">
        <h6><span></span>付款遇到问题</h6>
        <ul class="answer_list">
            <li>1、如您未开通网上银行，即可以使用储蓄卡快捷支付轻松完成付款；</li>
            <li>2、如果您没有网银，可以使用银联在线支付，银联有支持无需开通网银的快捷支付和储值卡支付；</li>
            <li>3、如果您有财付通或快钱、手机支付账户，可将款项先充入相应账户内，然后使用账户余额进行一次性支付；</li>
            <li>4、如果银行卡已经扣款，但您的账户中没有显示，有可能因为网络原因导致，将在第二个工作日恢复。</li>
            <li class="more"><a href="http://help.1yyg.com/">更多帮助</a>&nbsp;&nbsp;<a href="http://member.1yyg.com/Index.html">进入我的云购中心&gt;&gt;</a></li>
        </ul>
    </div>
</div>
<script type="text/javascript">
    $(function(){
        $('input[name="account"]').click(function(){
            var val = $(this).val();
            $('#hidPayBank').val(val);
        });
    });
</script>