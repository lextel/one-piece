<?php
$this->title('用户登录');
$this->styles($this->resLoader->css('product_list.css'));
?>
<div class="login">
    <div class="login_bg">
        <div id="loadingPicBlock" class="login_banner">
            <a href="#" target="_blank"><img src="/img/20130911171446251.jpg" alt="手机触屏版全新上线！" width="542" height="360"></a>
        </div>
        <div class="login_box" id="LoginForm">
            <h3>用户登录</h3>
            <ul>
                <li class="click"><span>账号：</span><input id="username" type="text" class="text_name" tabindex="1"></li>
                <li class="ts_wrong" id="name_ts">请输入正确的手机号/邮箱</li>
                <li><span>密码：</span>
                    <input id="pwd" type="password" class="text_password" tabindex="2">
                    <span class="fog"><a id="hylinkGetPassPage" tabindex="5" href="#">忘记密码？</a></span>
                </li>
                <li class="ts" id="pwd_ts">请填写长度为6-20长度的字符密码</li>
                <li class="end">
                    <input id="btnSubmitLogin" name="btnSubmitLogin" type="button" value="登录" class="login_init" tabindex="3">
                    <input name="hidLoginForward" type="hidden" id="hidLoginForward" value="http://member.1yyg.com/ReferAuth.html">
                </li>
            </ul>

            <div class="loginQQ">
                使用合作帐号登录：<span id="qq_login_btn"><img src="http://skin.1yyg.com/Passport/Images/qqlogin.png" border="0" alt=""></span>
            </div>
            <p>
                还不是1元云购用户？<br>
                开心云购，惊喜无限，就在1元云购，马上注册吧！</p>
                <div class="register"><a id="hylinkRegisterPage" tabindex="4" class="reg" href="#">立即注册</a></div>
            </div>
        </div>
    </div>