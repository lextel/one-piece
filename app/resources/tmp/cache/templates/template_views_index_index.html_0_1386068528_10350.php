<?php
$this->title('首页');
$this->scripts($this->resLoader->script('jquery.slides.min.js'));
$this->styles($this->resLoader->css('style.css'));
$this->styles($this->resLoader->css('product_list.css'));
?>
<!-- banner begin -->
<div class="banner_recommend">
    <div class="banner-box">
        <div id="posterTopNav" class="yg-flow"> <a href="/help" target="_blank"><img src="/img/20130716101908506.gif" alt="什么是1元云购，如何1元云购，30秒了解"></a> </div>
        <div class="banner">
            <div id="slideImg">
                <a href="javascript:void(0);" target="_blank"> <img src="/img/1.jpg" alt="商品A" width="740" height="333"></a>
                <a href="javascript:void(0);" target="_blank"> <img src="/img/2.jpg" alt="商品B" width="740" height="333"></a>
                <a href="javascript:void(0);" target="_blank"> <img src="/img/3.jpg" alt="商品C" width="740" height="333"></a>
            </div>
        </div>
    </div>
    <div class="recommend">
        <ul class="Pro">
            <li>
                <div class="pic"> 
                    <a rel="nofollow" href="/products/view/<?php echo $hot['id'];?>/<?php echo $hot['periodId'];?>" target="_blank" title="<?php echo $hot['title'];?>"> 
                        <img alt="<?php echo $hot['title'];?>_积分云购" src="<?php echo $hot['images'][0];?>" style="width: 184px; height: 184px"> 
                    </a> 
                </div>
                <p class="name"> <a href="/products/view/<?php echo $hot['id'];?>/<?php echo $hot['periodId'];?>" target="_blank" title="<?php echo $hot['title'];?>"><?php echo $hot['title'];?></a> </p>
                <p class="money"> 价值：<span class="rmb"><?php echo $hot['price'];?></span></p>
                <div class="Progress-bar" style="">
                    <p title="已完成<?php echo $hot['percent'];?>%"><span style="width: <?php echo $hot['width'];?>px; "></span></p>
                    <ul class="Pro-bar-li">
                        <li class="P-bar01"><em><?php echo $hot['join'];?></em>已参与人次</li>
                        <li class="P-bar02"><em><?php echo $hot['person'];?></em>总需人次</li>
                        <li class="P-bar03"><em><?php echo $hot['remain'];?></em>剩余人次</li>
                    </ul>
                </div>
                <p> 
                    <a rel="nofollow" href="/products/view/<?php echo $hot['id'];?>/<?php echo $hot['periodId'];?>" target="_blank" class="go_buy"></a> 
                </p>
            </li>
        </ul>
    </div>
</div>
<!-- banner end -->
<!-- 商品展示 begin -->
<div class="goods_hot">
    <div class="goods_left">
        <div class="new_lottery">
            <h4><span>最新揭晓</span><a rel="nofollow" href="/lotterys">更多&gt;&gt;</a></h4>
            <ul id="ulNewAwary">
                <!--li class="first_li"> 
                    <a rel="nofollow" href="#" target="_blank" title="TP-LINK TL-WN725N 微型150M无线USB网卡" class="pic">
                        <img alt="TP-LINK TL-WN725N 微型150M无线USB网卡_1元云购" src="#" style=""></a> 
                    <a href="#" target="_blank" title="TP-LINK TL-WN725N 微型150M无线USB网卡" class="name">TP-LINK TL-WN725N 微型150M无线USB网卡</a> 
                    <span class="time_box">倒计时:<i>00</i><b>:</b><i>00</i><b>:</b><i>00</i></span>
                    <div class="time_icon"></div>
                </li-->
                <?php
                    foreach($lotterys as $lottery):
                ?>
                 <li class="new_li"> 
                    <a rel="nofollow" href="/products/view/<?php echo $lottery['productId']; ?>/<?php echo $lottery['periodId']; ?>" target="_blank" title="<?php echo $lottery['title'] ;?>" class="pic">
                        <img alt="<?php echo $lottery['title'] ;?>" src="<?php echo $lottery['images'][0] ;?>" style="">
                    </a> 
                    <a href="/products/view/<?php echo $lottery['productId']; ?>/<?php echo $lottery['periodId']; ?>" target="_blank" title="<?php echo $lottery['title'] ;?>" class="name"><?php echo $lottery['title'] ;?></a> 
                    <span class="winner">获得者：<strong><a rel="nofollow" class="blue" href="javascript:void(0)"><?php echo $lottery['nickname'] ;?></a></strong></span> 
                </li>
                <?php
                    endforeach;
                ?>
            </ul>
        </div>
        <div class="hot">
            <h3><span>最热人气商品</span><a rel="nofollow" href="/products/index/?sort=hits&sortBy=desc">更多&gt;&gt;</a></h3>
            <ul id="hostGoodsItems" class="hot-list">
                <?php 
                    foreach($hots as $hot):
                ?>
                <li class="list-block">
                    <div class="pic"> 
                        <a rel="nofollow" href="/products/view/<?php echo $hot['id']; ?>/<?php echo $hot['periodId'];?>" target="_blank" title="<?php echo $hot['title'];?>">
                            <i class="<?php echo $hot['tagClass'];?>"></i>
                            <img alt="<?php echo $hot['title'];?>_积分云购" src="<?php echo $hot['images'][0];?>" style="">
                        </a> 
                        </div>
                    <p class="name"> <a href="/products/view/<?php echo $hot['id']; ?>/<?php echo $hot['periodId'];?>" target="_blank" title="<?php echo $hot['title'];?>"><?php echo $hot['title'];?></a> </p>
                    <p class="money"> 价值：<span class="rmb"><?php echo $hot['price'];?></span></p>
                    <div class="Progress-bar" style="">
                        <p title="已完成<?php echo $hot['percent'];?>%"><span style="width: <?php echo $hot['width'];?>px; "></span></p>
                        <ul class="Pro-bar-li">
                            <li class="P-bar01"><em><?php echo $hot['join'];?></em>已参与人次</li>
                            <li class="P-bar02"><em><?php echo $hot['person'];?></em>总需人次</li>
                            <li class="P-bar03"><em><?php echo $hot['remain'];?></em>剩余人次</li>
                        </ul>
                    </div>
                    <div class="shop_buttom"><a rel="nofollow" href="/products/view/<?php echo $hot['id']; ?>/<?php echo $hot['periodId'];?>" target="_blank" class="shop_but" title="立即1元云购"></a></div>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <div class="goods_right">
        <div class="news">
            <h3> 云购动态</h3>
            <ul>
                <?php
                    foreach($notices as $notice) :
                ?>
                <li><a href="/posts/notice/<?php echo $notice['_id']; ?>" target="_blank"><?php echo $notice['title']; ?></a></li>
                <?php
                    endforeach;
                ?>
            </ul>
        </div>
        <div class="wait_lottery" id="divLottery"><a href="javascript:void(0);" target="_blank"><img src="#" alt="苹果（Apple）iPad Air平板电脑 16GB WiFi版" width="230" height="200"></a></div>
        <div class="share">
            <h3> TA们正在云购</h3>
            <div class="buyList">
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
    </div>
</div>
<!-- 商品展示 end -->
<!-- 晒单展示 begin -->
<div class="lottery_show">
    <div class="share_show">
        <h3><span>晒单分享</span><a href="/shares" target="_blank">更多&gt;&gt;</a></h3>
        <div class="show">
            <?php
            foreach($shares as $share) {
            ?>
            <dl>
                <dt>
                    <a rel="nofollow" href="/shares/view/<?php echo $share['productId'];?>/<?php echo $share['periodId'];?>" target="_blank">
                        <img alt="" src="<?php echo $share['image'];?>" style="">
                    </a>
                </dt>
                <dd class="bg">
                    <ul>
                        <li class="name">
                            <span>
                                <a href="/shares/view/<?php echo $share['productId'];?>/<?php echo $share['periodId'];?>" target="_blank"><?php echo $share['title'];?></a>
                            </span> 
                            获得者：<a rel="nofollow" class="blue" href="/users/info/<?php echo $share['userId'];?>" target="_blank"><?php echo $share['nickname'];?></a>
                        </li>
                        <li class="content"><?php echo $share['content'];?></li>
                    </ul>
                </dd>
            </dl>
            <?php
            }
            ?>
        </div>
    </div>
</div>
<!-- 晒单展示 end-->

<script type="text/javascript">
    $(function() {
      $('#slideImg').slidesjs({
        width: 760,
        height: 333,
        play: {
            active: false,
            effect: "fade",
            swap: false,
            auto: true,
            pauseOnHover: true
        },
        navigation: {
            active: false,
            
        },
        pagination: {
            active: true,
            effect: "fade"
        }
      });
    });
</script>