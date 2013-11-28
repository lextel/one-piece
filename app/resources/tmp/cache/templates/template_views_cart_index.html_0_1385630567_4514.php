<?php
$this->title('提交订单');
$this->styles($this->resLoader->css('cartlist.css'));
?>
<div class="shop_process">
    <ul class="process">
        <li class="first_step">第一步：提交订单</li>
        <li class="arrow_1"></li>
        <li class="secend_step">第二步：网银支付</li>
        <li class="arrow_2"></li>
        <li class="third_step">第三步：支付成功 等待揭晓</li>
        <li class="arrow_2"></li>
        <li class="fourth_step">第四步：揭晓获得者</li>
        <li class="arrow_2"></li>
        <li class="fifth_step">第五步：晒单奖励</li>
    </ul>
    <div class="submitted">
        <ul class="order">
            <li class="top">
                <span class="goods">商品</span>
                <span class="name">名称</span>
                <span class="moneys">价值</span>
                <span class="money">云购价</span>
                <span class="num">云购人次</span>
                <span class="xj">小计</span>
                <span class="do">操作</span>
            </li>
            <?php
                $carts = $this->cart->get(true);
                $price = 0;
                $item = 0;
                foreach($carts as $cart) {
                    $price += $cart['quantity'];
                    $item++;
            ?>
                <li class="end">
                    <span class="goods">
                    <input type="checkbox" class="check" checked="checked" name="ids[]" value="<?php echo $item; ?>"/>
                    <a href="/products/view/<?php echo $cart['id'] ?>/<?php echo $cart['periodId']; ?>"> 
                        <img src="<?php echo $cart['image']; ?>" alt="">
                    </a>
                    </span> <span>
                    <span class="name">
                        <a href="/products/view/<?php echo $cart['id'] ?>/<?php echo $cart['periodId']; ?>"><?php echo $cart['title']; ?></a>
                    <p> 总需 <span class="color"><?php echo $cart['person']; ?></span> 人次参与，还剩 <span id="rm<?php echo $cart['id']; ?>"><?php echo $cart['remain']; ?></span> 人次</p>
                    </span></span><span class="moneys">￥<?php echo sprintf('%.2f',$cart['price']); ?></span> <span class="money"> <span class="color">￥1.00</span></span><span class="num">
                    <dl class="add">
                        <dd>
                            <input id="txtNum<?php echo $cart['id']; ?>" productId="<?php echo $cart['id']; ?>" periodId="<?php echo $cart['periodId']; ?>" name="num" type="text" maxlength="7" value="<?php echo $cart['quantity']; ?>" class="amount" onpaste="return false"/>
                        </dd>
                        <dd><a href="javascript:void(0);" class="jia" productId="<?php echo $cart['id']; ?>" periodId="<?php echo $cart['periodId']; ?>"></a><a href="javascript:void(0);" class="jian" productId="<?php echo $cart['id']; ?>" periodId="<?php echo $cart['periodId']; ?>"></a></dd>
                    </dl>
                    <div class="error" style="display: none;">最少需云购1人次</div>
                    </span>
                    <span class="xj xj<?php echo $cart['id']; ?>">￥<?php echo $cart['quantity'];?>.00</span>
                    <span class="do"><a href="javascript:void(0);" index="<?php echo $item; ?>" class="delgood">删除</a></span>
                </li>
            <?php
            }
            ?>
            <?php
            if(empty($carts)) {
            ?>
            <li>
                <div id="cartNO" class="cartno">
                    <p><span></span>购物车中暂时没有商品！<a href="/">返回继续云购&gt;&gt;</a></p>
                </div>
            </li>
            <?php
            }
            ?>
            <li class="ts">
                <p class="left">
                    <input type="checkbox" id="ckAll" checked="checked" />
                    <a href="javascript:void(0);" class="all"><label for="ckAll">全选</label></a>
                    <a href="javascript:void(0);" class="del" id="AllDelete">批量删除</a>
                </p>
                <p class="right"> 云购金额总计:￥<span id="moenyCount"><?php echo sprintf('%.2f',$price);; ?></span></p>
            </li>
        </ul>
    </div>
    <h5> <a href="/" id="but_on"></a>
        <input id="but_ok" type="button" value="" name="submitted" />
    </h5>
</div>