<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <?php echo $this->html->charset();?>
    <title><?php echo $this->title(); ?> &gt; 商城</title>
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
                    <a href="javascript:void(0);" id="addSiteFavorite">收藏积分云购</a>
                </p>
                <ul class="login_info" style="display: block;">
                    <?php if(!$this->user->id()): ?>
                    <li class="h_login" id="logininfo"> <i>您好，欢迎光临！</i>
                        <a rel="nofollow" href="/users/login" class="gray01">登录</a>
                        <span>|</span>
                        <a rel="nofollow" href="/users/register" class="gray01">注册</a>
                    </li>
                    <?php endif; ?>
                    <?php if($this->user->id()): ?>
                    <li class="h_wel" id="logininfo">
                        <a href="/users/info" class="gray01">
                            <img src="<?php echo $this->user->avatar(); ?>">
                            <?php echo $this->user->nickname(); ?>
                        </a
                        >&nbsp;&nbsp;
                        <a href="/users/logout" class="gray01">[退出]</a>
                    </li>
                    <?php endif; ?>
                    <li class="h_1yyg">
                        <a rel="nofollow" href="/users/center">我的云购<b></b></a>
                    </li>
                    <?php if($this->user->id()): ?>
                    <li class="h_news" id="liMsgTip">
                        <a rel="nofollow" href="/users/message">
                            消息(0) <b></b>
                        </a>
                    </li>
                    <?php endif; ?>

                    <li class="h_help">
                        <a rel="nofollow" target="_blank" href="/help">帮助</a>
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
                <a class="logo_1yyg_img" href="/" title="积分云购">积分云购</a>
            </h1>
            <div id="topJackaroo" class="newbie_guide"></div>
            <div class="head_number">
                <a href="javascript:void(0);" target="_blank">已<span id="spBuyCount" style="color: rgb(34, 170, 255); background-color: rgb(245, 245, 245); opacity: 1; background-position: initial initial; background-repeat: initial initial; ">7383415</span>人次参与云购</a>
            </div>
            <div class="head_search">
                <input type="text" id="txtSearch" class="init" value="" title='输入"手机" 试试'>    
                <input type="button" id="butSearch" class="search_submit" value="搜索">    
                <div class="keySearch">
                    <a href="/search/index/智能手机" target="_blank">智能手机</a>
                    <a href="/search/index/3G手机" target="_blank">3G手机</a>
                    <a href="/search/index/宝马" target="_blank">宝马</a>
                    <a href="/search/index/单反" target="_blank">单反</a>
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
                        'newbie'   => ['name' => '新手指南', 'url' => '/help/newbie', 'class' => 'what-1yyg'],
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
                <?php
                $carts = $this->cart->get();

                $item = 0;
                $quantity = 0;
                $cart = '';
                foreach($carts as $k => $v) {
                    $item++;
                    $cart .= '<ul class="mycartcur">';
                    $cart .= '<li class="img"><a href="#"><img src="'.$v['image'].'"></a></li>';
                    $cart .= '<li class="title"><h3><a href="#">'.$v['title'].'</a></h3><div class="rmbred"><i>1.00 </i>x <i>'.$v['quantity'].'</i><a class="delGood" index="'.$item.'" href="javascript:void(0);">删除</a></div></li>';
                    $cart .= '</ul>';
                    $quantity += $v['quantity'];
                }
                $cart .= '<p id="p1">共计 <span id="CartTotal2">'.$item.'</span> 件商品 金额总计：<span id="CartTotalM" class="rmbred">'.$quantity.'.00</span></p>';
                $cart .= '<div class="settlement"><input type="button" id="sGotoCart" value="去购物车并结算"></div>';
                ?>
                <a rel="nofollow" href="javascript:void(0);" id="sCartNavi" class="cart">
                    <s></s>购物车<span id="sCartTotal"><?php echo $h($item); ?></span>
                </a>
                <a rel="nofollow" href="javascript:void(0);" class="checkout">去结算</a>
                <div class="mycart_list" id="sCartlist" style="display: none; z-index: 99999; ">
                    <?php echo $cart;?>
                    <div class="goods_loding" id="sCartLoading" style="display: none;"><img border="0" alt="" src="/img/goods_loading.gif">正在加载......</div>
                </div>
            </div>
        </div>
    </div>
    <!--header内容结束-->
    <!--中间内容开始-->
    <div class="Current_nav"><a href="/">首页</a> &gt; <?php echo $this->title(); ?></div>
    <div class="wrap" id="loadingPicBlock">
      <div class="user_content">
        <div class="user_nav">
            <div class="user_pic">
                <a href="/users/profile"><img style="width: 60px; height: 60px" src="<?php echo $this->user->avatar();?>" alt="<?php echo $this->user->nickname();?>"></a>
            </div>
            <div class="user_info">
                <h1>
                    <?php echo $this->user->nickname();?>
                    <div id="edit_signature" style="display: inline;font-weight: 400" class="j a_edit_signature edtext pl">
                        <a href="/users/profile">修改资料</a> 积分：<?php echo $this->user->credits();?> <a href="/users/recharge">[充值]</a>
                    </div>
                </h1>
                <ul>
                    <li><a href="/users/center">我的云购</a></li>
                    <li><a href="/orders/user">云购记录</a></li>
                    <li><a href="/product/my">获得的商品</a></li>
                    <li><a href="/shares/share">晒单分享</a></li>
                    <li><a href="/users/message">消息</a></li>
                    <?php if($this->user->role() == 100) : ?>
                    <li><a href="/products/dashboard">商品管理</a></li>
                    <li><a href="/shares/dashboard">晒单管理</a></li>
                    <?php endif; ?>
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
                         <a href="javascript:void(0);" rel="nofollow" target="_blank">了解积分云购</a>
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
                         <a href="javascript:void(0);" rel="nofollow" target="_blank">积分云购保障体系</a>
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
