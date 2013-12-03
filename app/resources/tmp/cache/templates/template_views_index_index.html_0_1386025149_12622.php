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
                <a href="javascript:void(0);" target="_blank"> <img src="http://img.1yyg.com/Poster/20130827155002578.jpg" alt="小米（MIUI） 小米3 智能手机(16G)" width="740" height="333"></a>
                <a href="javascript:void(0);" target="_blank"> <img src="http://img.1yyg.com/Poster/20130827155002578.jpg" alt="小米（MIUI） 小米3 智能手机(16G)" width="740" height="333"></a>
                <a href="javascript:void(0);" target="_blank"> <img src="http://img.1yyg.com/Poster/20130827155002578.jpg" alt="小米（MIUI） 小米3 智能手机(16G)" width="740" height="333"></a>
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
                        <a rel="nofollow" href="/prodcuts/view/<?php echo $hot['id']; ?>/<?php echo $hot['periodId'];?>" target="_blank" title="<?php echo $hot['title'];?>">
                            <i class="goods_xp"></i>
                            <img alt="<?php echo $hot['title'];?>_积分云购" src="<?php echo $hot['images'][0];?>" style="">
                        </a> 
                        </div>
                    <p class="name"> <a href="/prodcuts/view/<?php echo $hot['id']; ?>/<?php echo $hot['periodId'];?>" target="_blank" title="<?php echo $hot['title'];?>"><?php echo $hot['title'];?></a> </p>
                    <p class="money"> 价值：<span class="rmb">5599.00</span></p>
                    <div class="Progress-bar" style="">
                        <p title="已完成<?php echo $hot['percent'];?>%"><span style="width: <?php echo $hot['width'];?>px; "></span></p>
                        <ul class="Pro-bar-li">
                            <li class="P-bar01"><em><?php echo $hot['join'];?></em>已参与人次</li>
                            <li class="P-bar02"><em><?php echo $hot['person'];?></em>总需人次</li>
                            <li class="P-bar03"><em><?php echo $hot['remain'];?></em>剩余人次</li>
                        </ul>
                    </div>
                    <div class="shop_buttom"><a rel="nofollow" href="/prodcuts/view/<?php echo $hot['id']; ?>/<?php echo $hot['periodId'];?>" target="_blank" class="shop_but" title="立即1元云购"></a></div>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <div class="goods_right">
        <div class="news">
            <h3> 云购动态</h3>
            <ul>
                <li><a href="javascript:void(0);" target="_blank">11月6日网络故障公告</a></li>
                <li><a href="javascript:void(0);" target="_blank">关于近期通过邮件和QQ索要密码的紧急公告</a></li>
                <li><a href="javascript:void(0);" target="_blank">2013年1元云购中秋国庆放假通知</a></li>
                <li><a href="javascript:void(0);" target="_blank">1元云购服务器升级维护公告</a></li>
                <li><a href="javascript:void(0);" target="_blank">1元云购网成功挂牌前海股权交易中心</a></li>
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
                // print_r($share);
            ?>
            <dl>
                <dt><a rel="nofollow" href="/shares/view/<?php echo $share[0]['productId'];?>/<?php echo $share[0]['periodId'];?>" target="_blank"><img alt="" src="<?php echo $share[0]['image'];?>" style=""></a></dt>
                <dd class="bg">
                    <ul>
                        <li class="name"><span><a href="javascript:void(0);" target="_blank"><?php echo $share[0]['user_id'];?></a></li>
                        <li class="content"><?php echo $share[0]['content'];?></li>
                    </ul>
                </dd>
            </dl>
            <dl>
                <dt><a rel="nofollow" href="javascript:void(0);" target="_blank"><img alt="" src="#" style=""></a></dt>
                <dd class="bg">
                    <ul>
                        <li class="name"><span><a href="javascript:void(0);" target="_blank">低调丶</a></li>
                        <li class="content">上周末抱着试试看的态度云购的，结果真中了，只花了25块钱收获了5S。开心的一米，本以为要等上一个月才能收到货，结果一周就到了，发货真是给力哇。。。。能赶在双十一之前到货，正好送给老婆当礼物。开心。这东西没…</li>
                    </ul>
                </dd>
            </dl>
            <?php
            }
            ?>
            <dl>
                <dt><a rel="nofollow" href="javascript:void(0);" target="_blank"><img alt="" src="#" style=""></a></dt>
                <dd class="bg">
                    <ul>
                        <li class="name"><span><a href="javascript:void(0);" target="_blank">钱姜江</a></li>
                        <li class="content">花十块钱抽红米没中，然后花两块钱中了个米三，这哪说理去。中奖之后我看晒单，还以为要一个月才能到，结果没想到三天就发货了，五天就到了，哈哈哈，太爽了。今天拿着米三来公司装个逼。
另外貌似很多人说一元云购是…</li>
                    </ul>
                </dd>
            </dl>
            <dl>
                <dt><a rel="nofollow" href="javascript:void(0);" target="_blank"><img alt="" src="#" style=""></a></dt>
                <dd class="bg">
                    <ul>
                        <li class="name"><span><a href="javascript:void(0);" target="_blank">低调丶</a></li>
                        <li class="content">上周末抱着试试看的态度云购的，结果真中了，只花了25块钱收获了5S。开心的一米，本以为要等上一个月才能收到货，结果一周就到了，发货真是给力哇。。。。能赶在双十一之前到货，正好送给老婆当礼物。开心。这东西没…</li>
                    </ul>
                </dd>
            </dl>
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