<?php
$this->title('账户充值');
$this->styles($this->resLoader->css('recharge.css'));
$this->styles($this->resLoader->css('cartlist.css'));
?>

<form action="/users/doRecharge" method="post">
<div class="R-content">
            <div class="member-t"><h2>账户充值</h2></div>
            <div class="select">
        	    <b class="gray01">请您选择充值金额</b>
                <ul id="ulMoneyList">
            	    <li class="" style="margin-left:0;"><input onfocus="this.blur()" type="radio" id="rd10" name="money" value="10" checked="checked"> <label for="rd10">充值 <strong>￥</strong><b>10</b></label></li>
                    <li class=""><input onfocus="this.blur()" type="radio" name="money" value="50" id="rd50"> <label for="rd50">充值 <strong>￥</strong><b>50</b></label></li>
                    <li class=""><input onfocus="this.blur()" type="radio" name="money" value="100" id="rd100"> <label for="rd100">充值 <strong>￥</strong><b>100</b></label></li>
                    <li class=""><input onfocus="this.blur()" type="radio" name="money" value="200" id="rd200"> <label for="rd200">充值 <strong>￥</strong><b>200</b></label></li>
                    <!--li class="custom"><input onfocus="this.blur()" type="radio" value="0" name="money" id="rdOther"> <label for="rdOther">其它金额</label><input id="txtOtherMoney" type="text" class="enter" maxlength="7" onpaste="return false;" onkeypress="if(event.keyCode&lt;48 || event.keyCode&gt;57)event.returnValue=false;"></li-->
                </ul>
            </div>

                 <div class="pay_bankC" id="divBankList">
        <div class="bank_arrow"><span>◆</span><em>◆</em></div>
        <h2>银行支付：</h2>
        <ul class="bank_logo">
            <li>
                <input type="radio" value="CMBCHINA-NET-B2C" name="account" id="bankType1001" checked="checked">
                <label for="bankType1001"><span class="zh_bank"></span></label>
            </li>
            <li>
                <input type="radio" value="ICBC-NET-B2C" name="account" id="bankType1002">
                <label for="bankType1002"><span class="gh_bank"></span></label>
            </li>
            <li>
                <input type="radio" value="CCB-NET-B2C" name="account" id="bankType1003">
                <label for="bankType1003"><span class="jh_bank"></span></label>
            </li>
            <li>
                <input type="radio" value="ABC-NET-B2C" name="account" id="bankType1005">
                <label for="bankType1005"><span class="nh_bank"></span></label>
            </li>
            <li>
                <input type="radio" value="SPDB-NET-B2C" name="account" id="bankType1004">
                <label for="bankType1004"><span class="pf_bank"></span></label>
            </li>
            <li>
                <input type="radio" value="SDB-NET-B2C" name="account" id="bankType1008">
                <label for="bankType1008"><span class="sf_bank"></span></label>
            </li>
            <li>
                <input type="radio" value="CIB-NET-B2C" name="account" id="bankType1009">
                <label for="bankType1009"><span class="xy_bank"></span></label>
            </li>
            <li>
                <input type="radio" value="BCCB-NET-B2C" name="account" id="bankType1032">
                <label for="bankType1032"><span class="bj_bank"></span></label>
            </li>
            <li>
                <input type="radio" value="CEB-NET-B2C" name="account" id="bankType1022">
                <label for="bankType1022"><span class="gd_bank"></span></label>
            </li>
            <li>
                <input type="radio" value="CMBC-NET-B2C" name="account" id="bankType1006">
                <label for="bankType1006"><span class="ms_bank"></span></label>
            </li>
            <li>
                <input type="radio" value="ECITIC-NET-B2C" name="account" id="bankType1021">
                <label for="bankType1021"><span class="zx_bank"></span></label>
            </li>
            <li>
                <input type="radio" value="GDB-NET-B2C" name="account" id="bankType1027">
                <label for="bankType1027"><span class="gf_bank"></span></label>
            </li>
            <li>
                <input type="radio" value="PINGANBANK-NET" name="account" id="bankType1010">
                <label for="bankType1010"><span class="pa_bank"></span></label>
            </li>
            <li>
                <input type="radio" value="BOC-NET-B2C" name="account" id="bankType1052">
                <label for="bankType1052"><span class="zg_bank"></span></label>
            </li>
            <li>
                <input type="radio" value="BOCO-NET-B2C" name="account" id="bankType1020">
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
            <div class="payment_but">
            <p id="pNewPointNum" class="pay_but_txt">&nbsp;</p>
            <input id="submit_ok" class="shop_pay_but" type="submit" name="submit" value="">
        </div>
 </div>
</form>