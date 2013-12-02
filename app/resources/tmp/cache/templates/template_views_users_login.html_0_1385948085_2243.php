<?php
$this->title('用户登录');
$this->styles($this->resLoader->css('product_list.css'));
$this->scripts($this->resLoader->script('jquery.validate.js'));
$this->scripts($this->resLoader->script('additional-methods.min.js'))
?>

<div class="login">
    <div class="login_bg">
        <div id="loadingPicBlock" class="login_banner"> <a href="#" target="_blank"><img src="/img/20130911171446251.jpg" alt="手机触屏版全新上线！" width="542" height="360"></a> </div>
        <div class="login_box" id="LoginForm">
            <form id="login" method="post">
                <h3>用户登录</h3>
                <ul>
                    <li class="click">
                        <span>账号：</span>
                        <input id="username" name="username" type="text" class="text_name" tabindex="1">
                    </li>
                    <li>
                        <span>密码：</span>
                        <input id="password"  name="password"  type="password" class="text_password" tabindex="2">
                        <span class="fog"><a id="hylinkGetPassPage" tabindex="5" href="/users/password">忘记密码？</a></span> </li>
                    <li class="end">
                        <input type="submit" value="登录" class="login_init" tabindex="3">
                    </li>
                </ul>
                <p> 还不是积分云购用户？<br>
                    开心云购，惊喜无限，就在积分云购，马上注册吧！</p>
                <div class="register"><a id="hylinkRegisterPage" tabindex="4" class="reg" href="/users/register">立即注册</a></div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
// 添加商品表单验证
$('#login').validate({
    rules: {
        username: {
            required: true,
            email: true,
        },
        password: "required",
    },
    messages: {
        username: {
            required:"邮箱地址不能为空",
            email:"请输入正确的邮箱地址",
        },
        password: "密码不能为空",
    },
    ignore: [],
    submitHandler: function(form) {
        form.submit();
    }
});
</script>