<?php
$this->title('最新揭晓');
$this->styles($this->resLoader->css('product_list.css'));
?>
<div class="Current_nav"><a href="/">首页</a> &gt; 最新揭晓</div>
<div class="Newpublish">
    <div class="NewpublishL">
        <div id="current" class="publish_Curtit">
            <h1 class="fl">最新揭晓</h1>
            <span id="spTotalCount">(到目前为止共揭晓商品<em class="orange"><?php echo $total; ?></em>件)</span></div>
            <div class="publishBor">
                <div class="publishCen" id="listDivTitle">
                    <ul id="ProductList">
                        <!--li class="lottery">
                            <s class="lottery-tips"></s>
                            <a class="fl goodsimg" href="#" target="_blank" title="(第16期)苹果（Apple）iPad Air平板电脑 16GB WiFi版（预售）">
                                <img src="#" border="0" alt="苹果（Apple）iPad Air平板电脑 16GB WiFi版（预售）" width="140">
                            </a>
                            <div class="publishC-tit">
                                <h3><a href="#" target="_blank" class="gray01">(第16期)苹果（Apple）iPad Air平板电脑 16GB WiFi版（预售）</a></h3>
                                <p class="money">商品价值：<span class="rmb">3988.00</span></p>
                            </div>
                            <div id="jiexiaoTime">
                                <div class="Pour-time jiexiaoTime">
                                    <b><em>揭&nbsp;&nbsp;晓</em>倒计时</b>
                                    <ol>
                                        <li class="Dig"><span class="minute">01</span></li>
                                        <li>:</li>
                                        <li class="Dig"><span class="second">58</span></li>
                                        <li>:</li>
                                        <li class="Dig"><span class="millisecond">3</span><span class="last">0</span></li>
                                    </ol>
                                </div>
                            </div>
                            <div class="details">即将揭晓，敬请期待...</div>
                        </li-->
                        <?php foreach($lotterys as $lottery): ?>
                        <li class="">
                            <a class="fl goodsimg" href="/products/view/<?php echo $lottery['productId']; ?>/<?php echo $lottery['periodId']; ?>" rel="nofollow" target="_blank" title="(第<?php echo $lottery['periodId']; ?>期)<?php echo $lottery['title']; ?>">
                                <img alt="" src="<?php echo $lottery['images'][0]; ?>" style=""></a>
                                <div class="publishC-Member gray02"><a class="fl headimg" rel="nofollow" href="/products/view/<?php echo $lottery['productId']; ?>/<?php echo $lottery['periodId']; ?>" target="_blank" title="<?php echo $lottery['nickname']; ?>">
                                    <img alt="" src="<?php echo $lottery['avatar']; ?>" style=""></a>
                                    <p>获得者：<a class="blue Fb" href="/users/info/<?php echo $lottery['userId']; ?>" title="<?php echo $lottery['nickname']; ?>" target="_blank"><?php echo $lottery['nickname']; ?></a>(编写中)</p>
                                    <?php
                                    $from = getCity($lottery['reg_ip']);
                                    $from = $from['region'].$from['city'];
                                    $from = empty($from) ? '内网' : '';
                                    ?>
                                    <p>来自：<?php echo $from; ?></p>
                                    <p>本期云购：<em class="orange Fb"><?php echo $lottery['total']; ?></em>人次</p>
                                </div>
                                <div class="publishC-tit">
                                    <h3><a href="/products/view/<?php echo $lottery['productId']; ?>/<?php echo $lottery['periodId']; ?>" target="_blank" class="gray01">(第<?php echo $lottery['periodId']; ?>期)<?php echo $lottery['title']; ?></a></h3>
                                    <p class="money">商品价值：<span class="rmb"><?php echo sprintf('%.2f', $lottery['price']); ?></span></p>
                                    <p class="Announced-time gray02">揭晓时间：<?php echo $this->times->friendlyDate($lottery['showed']); ?></p>
                                </div>
                                <div class="details">
                                    <p class="fl details-Code">幸运云购码：<em class="orange Fb"><?php echo $lottery['code']+10000001; ?></em></p>
                                    <a class="fl details-A" href="/products/view/<?php echo $lottery['productId']; ?>/<?php echo $lottery['periodId']; ?>" rel="nofollow" target="_blank">查看详情</a>

                                </div>
                            </li>
                            <?php endforeach;?>
                    </ul>
                    </div>
                    <div class="pages">
                    <?php echo $this->Paginator->paginate(); ?>
                    </div>
                        </div>
                   </div>
                   <div class="NewpublishR">
                    <div class="Newpublishbor">
                        <div class="Rtitle gray01">TA们正在云购 </div>
                        <div class="Rcenter buylistH">
                            <ul id="buyList" style="margin-top: 0px; ">
                                <?php
                                foreach($ordering as $order):
                                ?>
                                <li>
                                    <a href="/users/info/<?php echo $order['user_id']; ?>" class="pic" target="_blank"><img style="width: 56px;height: 56px" src="<?php echo $order['avatar']; ?>" alt="<?php echo $order['nickname']; ?>"></a>
                                    <p class="Rtagou"><a class="blue" href="/users/info/<?php echo $order['user_id']; ?>"><?php echo $order['nickname']; ?></a>(编写中)<?php echo $this->times->friendlyDate($order['ordered']);?>云购了</p>
                                    <p class="Rintro"><a class="gray01" href="/products/view/<?php echo $order['product_id'];?>/<?php echo $order['period_id'];?>" target="_blank"><?php echo $order['title']; ?></a></p>
                                </li>
                                <?php
                                endforeach;
                                ?>
                            </ul>
                            </div>
                        </div>
                        <div class="blank10"></div>
                        <div class="Newpublishbor">
                            <div class="Rtitle gray01">人气排行 </div>
                            <div class="Rcenter RcenterPH">
                                <ul class="RcenterH" id="RcenterH">
                                    <?php 
                                    $i = 1;
                                    foreach($hots as $hot) :
                                    ?>
                                    <li class="<?php echo $i == 1 ? 'list-block' : ''?>">
                                        <div name="detailsinfo" style="display:<?php echo $i == 1 ? 'block' : 'none'?>">
                                            <?php echo $i < 4 ? '<b>'.$i.'</b>' : ''?>
                                            <div class="pic">
                                                <a rel="nofollow" href="##" target="_blank" title="<?php echo $hot['title']; ?>">
                                                <img alt="<?php echo $hot['title']; ?>" src="<?php echo $hot['images'][0]; ?>" style=""></a>
                                            </div>
                                            <p class="name">
                                                <a class="gray01" href="/prodcuts/view/<?php echo $hot['id']; ?>/<?php echo $hot['periodId'];?>" target="_blank" title="<?php echo $hot['title']; ?>"><?php echo $hot['title']; ?></a>
                                            </p>
                                            <p class="money">价值：<span class="rmb"><?php echo $hot['price']; ?></span></p>
                                            <div class="Progress-bar" style="">
                                                <p title="已完成<?php echo $hot['percent']; ?>%"><span style="width:<?php echo $hot['percent']; ?>%;"></span></p>                                            
                                                <ul class="Pro-bar-li">
                                                    <li class="P-bar01"><em><?php echo $hot['join']; ?></em>已参与人次</li>
                                                    <li class="P-bar02"><em><?php echo $hot['person']; ?></em>总需人次</li>
                                                    <li class="P-bar03"><em><?php echo $hot['remain']; ?></em>剩余人次</li>
                                                </ul>
                                            </div>
                                            <div class="shop_buttom"><a class="go_Shopping" title="立即1元云购" productId="<?php echo $hot['id']; ?>" periodId="<?php echo $hot['periodId'];?>" target="_blank" href="javascript:void(0);">立即1元云购</a></div>
                                        </div>
                                        <div name="simpleinfo" style="display: <?php echo $i != 1 ? 'block' : 'none'?>; ">
                                            <?php echo $i < 4 ? '<b>'.$i.'</b>' : ''?>
                                            <span class="pic">
                                                <img style="width:56px; height:56px" alt="<?php echo $hot['title']; ?>" src="<?php echo $hot['images'][0]; ?>" style="">
                                            </span>
                                            <p class="Rintro gray01"><?php echo $hot['title']; ?></p>
                                            <p><i>剩余人次</i><em><?php echo $hot['remain']; ?></em></p>
                                        </div>
                                    </li>
                                    <?php 
                                    $i++;
                                    endforeach;
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
<script>
$(function(){


    $('div[name="simpleinfo"]').hover(function(){
        $('div[name="detailsinfo"]').hide();
        $('div[name="simpleinfo"]').show();
        $('#RcenterH > li').removeClass('list-block');
        $(this).hide();
        $(this).prev().show();
        $(this).parent().addClass('list-block');
    });



});
</script>