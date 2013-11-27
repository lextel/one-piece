<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <?php echo $this->html->charset();?>
    <title>商城 &gt; <?php echo $this->title(); ?></title>
    <?php echo $this->html->style(array('header', 'common')); ?>
    <?php echo $this->html->script(['jquery', 'common']);?>
    <?php echo $this->scripts(); ?>
    <?php echo $this->styles(); ?>
    <?php echo $this->html->link('Icon', null, array('type' => 'icon')); ?>
</head>
<body>    
    <!--header顶部开始-->
    <div class="header">
        <div class="site_top">
            <div class="head_top">
                <p class="collect">
                    <a href="javascript:void(0);" id="addSiteFavorite">收藏1元云购</a>
                </p>
                <ul class="login_info" style="display: block;">
                    <li class="h_login" id="logininfo"> <i>您好，欢迎光临！</i>
                        <a rel="nofollow" href="javascript:void(0);" class="gray01">登录</a>
                        <span>|</span>
                        <a rel="nofollow" href="javascript:void(0);" class="gray01">注册</a>
                    </li>
                    <li class="h_1yyg">
                        <a rel="nofollow" href="javascript:void(0);">
                            我的1元云购 <b></b>
                        </a>
                        <div class="h_1yyg_eject" style="display: none; ">
                            <dl>
                                <dt>
                                    <a rel="nofollow" href="javascript:void(0);">
                                        我的1元云购 <i></i>
                                    </a>
                                </dt>
                                <dd>
                                    <a rel="nofollow" href="javascript:void(0);">云购记录</a>
                                </dd>
                                <dd>
                                    <a rel="nofollow" href="javascript:void(0);">获得的商品</a>
                                </dd>
                                <dd>
                                    <a rel="nofollow" href="javascript:void(0);">帐户充值</a>
                                </dd>
                                <dd>
                                    <a rel="nofollow" href="javascript:void(0);">个人设置</a>
                                </dd>
                            </dl>
                        </div>
                    </li>
                    <li class="h_news" id="liMsgTip" style="display:none;">
                        <a rel="nofollow" href="javascript:void(0);">
                            消息 <b></b>
                        </a>
                        <div class="h_news_down" style="display:none;">
                            <div class="h_news_downT">
                                <a rel="nofollow" href="javascript:void(0);">
                                    消息
                                    <i></i>
                                </a>
                            </div>
                            <div class="h_news_downC"></div>
                        </div>
                    </li>
                    <!--li class="h_Mobile">
                        <a rel="nofollow" target="_blank" href="javascript:void(0);">桌面版</a>
                    </li>
                    <li class="h_Mobile">
                        <a rel="nofollow" target="_blank" href="javascript:void(0);">手机版</a>
                    </li-->
                    <li class="h_help">
                        <a rel="nofollow" target="_blank" href="javascript:void(0);">帮助</a>
                    </li>
                    <li class="h_inv">
                        <a rel="nofollow" target="_blank" href="javascript:void(0);">在线客服</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!--header顶部结束-->
    <!--header内容开始-->
    <div class="head_mid">
        <div class="head_mid_bg">
            <h1 class="logo_1yyg">
                <a class="logo_1yyg_img" href="javascript:void(0);" title="1元云购">1元云购</a>
            </h1>
            <div id="topJackaroo" class="newbie_guide"></div>
            <div class="head_number">
                <a href="javascript:void(0);" target="_blank">已<span id="spBuyCount" style="color: rgb(34, 170, 255); background-color: rgb(245, 245, 245); opacity: 1; background-position: initial initial; background-repeat: initial initial; ">7383415</span>人次参与云购</a>
            </div>
            <div class="head_search">
                <input type="text" id="txtSearch" class="init" value="" title="输入"红米手机" 试试">    
                <input type="button" id="butSearch" class="search_submit" value="搜索">    
                <div class="keySearch">
                    <a href="javascript:void(0);" target="_blank">智能手机</a>
                    <a href="javascript:void(0);" target="_blank">3G手机</a>
                    <a href="javascript:void(0);" target="_blank">宝马</a>
                    <a href="javascript:void(0);" target="_blank">单反</a>
                </div>
            </div>
        </div>
    </div>
    <div class="head_nav">
        <div class="nav_center">
            <ul class="nav_list">
                <?php 
                    $navs = [
                        'home'    => ['name' => '首页', 'url' => '/', 'class' => 'home-back'],
                        'product' => ['name' => '所有商品', 'url' => '/products', 'class' => 'sort-all'],
                        'lottery'   => ['name' => '最新揭晓', 'url' => '/lotterys', 'class' => 'new-lottery'],
                        'share'   => ['name' => '晒单分享', 'url' => '/shares', 'class' => 'share'],
                        'cooperation'   => ['name' => '邀请', 'url' => '/cooperation', 'class' => 'cooperation'],
                        'new'   => ['name' => '新手指南', 'url' => '/new', 'class' => 'what-1yyg'],
                    ];

                    foreach($navs as $key => $nav) {
                        $class = '';
                        if(isset($navCurr) && $navCurr == $key) {
                            $class = ' navCurr';
                        }
                        echo "<li class='{$nav['class']}{$class}'><a href='{$nav['url']}'>{$nav['name']}</a></li>";
                    }
                ?>
            </ul>
            <div class="mini_mycart" id="sCart">
                <input type="hidden" id="hidChanged" value="0">
                <a rel="nofollow" href="javascript:void(0);" id="sCartNavi" class="cart">
                    <s></s>购物车<span id="sCartTotal">0</span>
                </a>
                <a rel="nofollow" href="javascript:void(0);" class="checkout">去结算</a>
                <div class="mycart_list" id="sCartlist" style="display: none; z-index: 99999; ">
                    <div class="goods_loding" id="sCartLoading">
                        <img border="0" alt="" src="http://skin.1yyg.com/images/goods_loading.gif">正在加载......</div>
                    <p id="p1">    共计<span id="sCartTotal2">0</span>    件商品 金额总计：<span id="sCartTotalM" class="rmbred">0.00</span></p>
                    <h3>
                        <input type="button" id="sGotoCart" value="去购物车并结算"></h3>
                </div>
            </div>
        </div>
    </div>
    <!--header内容结束-->
    <!--中间内容开始-->  
    <div class="wrap" id="loadingPicBlock">
      <div class="user_content">
        <div class="user_nav">
            <div class="user_pic">
                <a href="#"><img src="http://img3.douban.com/icon/u49925310-4.jpg" alt="weelion"></a>
            </div>
            <div class="user_info">
                <h1>luky</h1>
                 <ul>
                    <li><a href="/products/dashboard">商品管理</a></li>
                    <li><a href="/shares/dashboard">晒单管理</a></li>
                    <li><a href="/shares/share">晒单</a></li>
                 </ul>
            </div>
        </div>
      </div>
        <?php
            $flash = $this->session->message();
            if (is_string($flash)) {
                echo "<p class='success'>{$flash}</p>";
            } else if(is_array($flash)) {
                echo "<p class='{$flash['status']}'>{$flash['message']}</p>";
            }
        ?>
        <?php echo $this->content(); ?>
    </div>
    <!--中间内容结束-->
    <!--底部内容开始-->
    <div class="footer_content">
         <div class="footer_line"></div>
         <div class="footservice">
             <div class="support">
                 <dl class="ft-newbie">
                     <dt>
                         <span>新手指南</span>
                     </dt>
                     <dd> <b></b>
                         <a href="javascript:void(0);" rel="nofollow" target="_blank">了解1元云购</a>
                     </dd>
                     <dd> <b></b>
                         <a href="javascript:void(0);" rel="nofollow" target="_blank">常见问题</a>
                     </dd>
                     <dd>
                         <b></b>
                         <a href="javascript:void(0);" rel="nofollow" target="_blank">服务协议</a>
                     </dd>
                     <dd>
                         <b></b>
                         <a href="javascript:void(0);" rel="nofollow" target="_blank">会员福分经验值</a>
                     </dd>
                 </dl>
                 <dl class="ft-wares">
                     <dt>
                         <span>云购保障</span>
                     </dt>
                     <dd>
                         <b></b>
                         <a href="javascript:void(0);" rel="nofollow" target="_blank">1元云购保障体系</a>
                     </dd>
                     <dd>
                         <b></b>
                         <a href="javascript:void(0);" rel="nofollow" target="_blank">正品保障</a>
                     </dd>
                     <dd>
                         <b></b>
                         <a href="javascript:void(0);" rel="nofollow" target="_blank">安全支付</a>
                     </dd>
                     <dd>
                         <b></b>
                         <a href="javascript:void(0);" rel="nofollow" target="_blank">投诉建议</a>
                     </dd>
                 </dl>
                 <dl class="ft-delivery">
                     <dt>
                         <span>商品配送</span>
                     </dt>
                     <dd>
                         <b></b>
                         <a href="javascript:void(0);" rel="nofollow" target="_blank">商品配送</a>
                     </dd>
                     <dd>
                         <b></b>
                         <a href="javascript:void(0);" rel="nofollow" target="_blank">配送费用</a>
                     </dd>
                     <dd>
                         <b></b>
                         <a href="javascript:void(0);" rel="nofollow" target="_blank">商品验货与签收</a>
                     </dd>
                     <dd>
                         <b></b>
                         <a href="javascript:void(0);" rel="nofollow" target="_blank">长时间未收到商品</a>
                     </dd>
                 </dl>
                 <dl class="ft-ygjj">
                     <dt>
                         <span>云购基金</span>
                     </dt>
                     <dd>
                         <b></b>
                         <a href="javascript:void(0);" rel="nofollow" target="_blank">云购基金</a>
                     </dd>
                     <dd>
                         <b></b>
                         <a href="javascript:void(0);" rel="nofollow" target="_blank">社会活动</a>
                     </dd>
                 </dl>
                 <dl class="ft-fwrx">
                     <dt>
                         <span>服务热线</span>
                     </dt>
                     <dd class="ft-fwrx-tel"> <i></i>
                     </dd>
                     <dd class="ft-fwrx-time">周一至周五 8:30-18:30</dd>
                     <dd class="ft-fwrx-service">
                         <span class="ft-qqicon">
                             <a href="javascript:void(0);" rel="nofollow" target="_blank" style="text-indent:0em; background:none;width:160px;">
                                 官方QQ群①： <em class="orange Fb">89834747</em>
                             </a>
                         </span>
                         <span class="ft-qqicon">
                             <a href="javascript:void(0);" rel="nofollow" target="_blank" style="text-indent:0em; background:none;width:160px;">
                                 官方QQ群②： <em class="orange Fb">190818578</em>
                             </a>
                         </span>
                     </dd>
                 </dl>
                 <dl class="ft-weixin">
                     <dt>
                         <span>微信扫一扫</span>
                     </dt>
                     <dd class="ft-weixin-img">
                         <s></s>
                     </dd>
                     <dd class="gray02"></dd>
                 </dl>
             </div>
         </div>
         <div class="service-promise">
             <ul>
                 <li class="sp-fair">
                     <a href="javascript:void(0);" rel="nofollow" target="_blank">
                         <span></span>
                     </a>
                 </li>
                 <li class="sp-wares">
                     <a href="javascript:void(0);" rel="nofollow" target="_blank">
                         <span></span>
                     </a>
                 </li>
                 <li class="sp-free-delivery">
                     <a href="javascript:void(0);" rel="nofollow" target="_blank">
                         <span></span>
                     </a>
                 </li>
                 <li class="sp-business service-promise-border-r0">
                     <a href="javascript:void(0);" rel="nofollow" target="_blank">
                         <span></span>
                     </a>
                 </li>
             </ul>
         </div>
         <div class="service_date">
             <div class="Service_Time">
                 <p>服务器时间</p>
                 <span id="sp_ServerTime">17:18:41</span>
             </div>
             <div class="Service_Fund">
                 <a href="javascript:void(0);" target="_blank">
                     <p>云购公益基金</p>
                     <span id="spanFundTotal">1073979.25</span>
                 </a>
             </div>
         </div>
     </div>
     <!--底部内容结束-->
     <!--footer 开始-->
     <div class="footer">
          <div class="footer_links">
              <a href="javascript:void(0);">首页</a> <b></b>
              <a href="javascript:void(0);">关于云购</a> <b></b>
              <a href="javascript:void(0);">隐私声明</a>
              <b></b>
              <a href="javascript:void(0);">合作专区</a>
              <b></b>
              <a href="javascript:void(0);">加入云购</a>
              <b></b>
              <a href="javascript:void(0);">云购圈</a>
              <b></b>
              <a href="javascript:void(0);">友情链接</a>
              <b></b>
              <a href="javascript:void(0);">联系我们</a>
          </div>
          <div class="copyright">Copyright  © 2011 - 2013,  版权所有  1yyg.com  粤ICP备09213115号-1</div>
          <div class="footer_icon" style="width:599px;">
              <ul>
                  <li class="fi_ectrustchina">
                      <a target="_blank" href="javascript:void(0);">
                          <span>可信网站</span>
                      </a>
                  </li>
                  <li class="fi_315online">
                      <a target="_blank" href="javascript:void(0);">
                          <span>深圳市市场监督管理局</span>
                      </a>
                  </li>
                  <li class="fi_cnnic">
                      <a target="_blank" href="javascript:void(0);">
                          <span>中国电子商务诚信单位</span>
                      </a>
                  </li>
                  <li class="fi_anxibao">
                      <a target="_blank" href="javascript:void(0);">
                          <span>安信保</span>
                      </a>
                  </li>
                  <li class="fi_pingan">
                      <a target="_blank" href="javascript:void(0);">
                          <span>平安银行</span>
                      </a>
                  </li>
                  <li class="fi_qh">
                      <a target="_blank" href="javascript:void(0);">
                          <span>前海股权交易中心</span>
                      </a>
                  </li>
              </ul>
          </div>
      </div>
      <!--footer 结束-->
    </body>
</html>
