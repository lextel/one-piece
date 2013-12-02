<?php
$this->title('商品管理 > 编辑商品');
$this->scripts($this->resLoader->script('jquery.validate.js'));
$this->scripts($this->resLoader->script('additional-methods.min.js'));
$this->scripts($this->resLoader->script('jquery.ui.widget.js'));
$this->scripts($this->resLoader->script('jquery.iframe-transport.js'));
$this->scripts($this->resLoader->script('jquery.fileupload.js'));
?>
  <div class="add_product">
      <h2>修改资料<a href="/users/center" class="return_list">返回</a></h2>
          <form id="profile" method="post">
          <ul>
            <li class="text_nums">
                  <div>
                    <label>头像</label>
                    <img style="width: 30px; height: 30px" src='<?php echo $h($user['avatar']); ?>' id="avatar"/>
                    <input type="file" id="upload" name="file"/>
                    <input type="hidden" id="userAvater" name="avatar"  value="<?php echo $h($user['avatar']); ?>"/>
                  </div>
              </li>
              <li class="text_nums">
                <div>
                  <label>昵称</label>
                  <input type="text" id="nickname" name="nickname" value="<?php echo $h($user['nickname']); ?>"/>
                </div>
              </li>
              <li class="text_nums">
                <div>
                  <label>旧密码</label>
                  <input type="password" id="password" name="password" />
                  <label for="password" class="error">不修改请留空</label>
                </div>
              </li>
              <li class="text_nums">
                <div>
                  <label>新密码</label>
                  <input type="password" id="newpassword" name="newpassword" />
                </div>
              </li>
              <li class="text_nums">
                <div>
                  <label>确认密码</label>
                  <input type="password" id="repassword" name="repassword" />
                </div>
              </li>
              <li class="text_nums">
                <div>
                  <label>手机号码</label>
                  <input type="text" id="mobile" name="mobile" value="<?php echo $h($user['mobile']); ?>"/>
                </div>
              </li>
              <li class="text_nums">
                <div>
                  <label>收货人</label>
                  <input type="text" id="realname" name="realname" value="<?php echo $h($user['realname']); ?>"/>
                </div>
              </li>
              <li class="text_nums">
                <div>
                  <label>收货地址</label>
                  <input type="text" id="address" name="address" value="<?php echo $h($user['address']); ?>"/>
                </div>
              </li>
              <li class="text_nums">
                <div>
                  <label>邮政编码</label>
                  <input type="text" id="zipcode" name="zipcode" value="<?php echo $h($user['zipcode']); ?>"/>
                </div>
              </li>
              <li>
                <div class="bottom_side">
                    <?php echo $this->form->submit('提交', ['class' => 'published']); ?>
                    <?php echo $this->form->reset('重置', ['class' => 'canal']); ?>
                </div>
               </li>
            </ul>
            </form>
    </div>
    <script type="text/javascript">
      jQuery.validator.addMethod("isMobile", function(value, element) {
           var length = value.length;
           if(length == 0 ) return true;
           var mobile = /^(((13[0-9]{1})|(15[0-9]{1}))+\d{8})$/;
           return (length == 11 && mobile.exec(value))? true:false;
       }, "请正确填写您的手机号码");

       jQuery.validator.addMethod("isZipCode", function(value, element) {
           var length = value.length;
           if(length == 0 ) return true;   
           var tel = /^[0-9]{6}$/;       
           return (tel.exec(value))?true:false;       
       }, "请正确填写您的邮编");

        // 表单验证
        $('#profile').validate({
            rules: {
                nickname: "required",
                password: {
                  remote: "/users/oldpassword"
                },
                newpassword: {
                  rangelength: [6,20]
                },
                repassword: {
                  equalTo: "#newpassword"
                },
                mobile: {
                  isMobile: true
                },
                zipcode: {
                  isZipCode: true
                }
            },
            messages: {
              nickname: '昵称不能为空',
              password: '旧密码不正确',
              rangelength: '密码长度必须在6-20位之间',
              repassword: '两次密码不一致',

            },
            ignore: [],
            submitHandler: function(form) {
                $(form).find('input[name="file"]').remove();
                form.submit();
            }
        });

        $(function () {

            // 图片上传
            var url = '<?php echo $this->url('users::upload'); ?>';
            $('#upload').fileupload({
                url: url,
                dataType: 'json',
                done: function (e, data) {
                    if(data.result.status == true) {
                      $('#avatar').attr('src', data.result.data);
                      $('#userAvater').val(data.result.data);
                    } else {
                        $('#userAvater').next().remove();
                        $('#userAvater').after('<label for="userAvater" class="error">'+data.result.data+'</label');
                    }
                }
            });
        });
    </script>
