<?php
$this->scripts($this->resLoader->script('jquery.validate.js'));
$this->scripts($this->resLoader->script('additional-methods.min.js'));
$this->scripts($this->resLoader->script('jquery.ui.widget.js'));
$this->scripts($this->resLoader->script('jquery.iframe-transport.js'));
$this->scripts($this->resLoader->script('jquery.fileupload.js'));
$this->scripts($this->resLoader->script('umeditor/ueditor.config.js'));
$this->scripts($this->resLoader->script('umeditor/ueditor.all.min.js'));
$this->scripts($this->resLoader->script('umeditor/lang/zh-cn/zh-cn.js'));
?>
<div class="user_content">
    <div class="user_nav">
        <div class="user_pic">
            <a href="#"><img src="http://img3.douban.com/icon/u49925310-4.jpg" alt="weelion"></a>
        </div>
        <div class="user_info">
            <h1>luky
                <div class="signature">
                    <span>最爱网购</span>
                    <span><a href="#">(编辑)</a></span>
                </div>
              </h1>
             <ul>
                <li><a href="#">我的主页</a></li>
                <li><a href="#">广播</a></li>
                <li><a href="#">相册</a></li>
                <li><a href="#">日记</a></li>
                <li><a href="#">喜欢</a></li>
                <li><a href="#">豆列</a></li>
                <li><a href="/products/dashboard">商品管理</a></li>
             </ul>
        </div>
    </div>
  </div>
  <div class="add_product">
      <h2>编辑商品<a href="/products/dashboard" class="return_list">返回列表</a></h2>
          <?php echo $this->form->create($product, ['id' => 'addProduct']); ?>
          <ul>
              <li class="text_nums">
                  <?php echo $this->form->field(['title' => '名称'], ['style' => 'width:400px']); ?>
              </li>
              <li class="text_nums">
                  <?php echo $this->form->field(['feature' => '特性'], ['style' => 'width:400px']); ?>
              </li>
              <li class="text_nums">
                  <?php echo $this->form->field(['cat_id' => '分类'], ['type' => 'select', 'list' => $cats]); ?>
              </li>
              <li class="text_nums">
                  <?php echo $this->form->field(['price' => '价格']); ?>
              </li>
              <li class="text_nums">
                  <div>
                    <label for="ProductsImages">图片</label>
                    <dl class="add_p_img">
                    <?php
                      foreach($product->images as $image) {
                        echo '<dd><img src="'.$image.'"><s class="close"></s><input type="hidden" name="images[]" value="'.$image.'"></dd>';
                      }
                    ?>
                      <dd class="insert_bottom">添加<input id="upload" type="file" name="file" multiple></dd>
                    </dl>

                  </div>
              </li>
              <li class="content_li">
                  <?php echo $this->form->field(['content' => '详情'], ['type' => 'textarea', 'id' => 'content', 'style'=>'height:600px;width:750px']); ?>
              </li>
              <li></li>
              <li></li>
              <li>
                <div class="bottom_side">
                    <?php echo $this->form->submit('提交', ['class' => 'published']); ?>
                    <?php echo $this->form->reset('重置', ['class' => 'canal']); ?>
                </div>
               </li>
            </ul>
            <?php echo $this->form->end(); ?>
    </div>
    <script type="text/javascript">
      // 添加验证方式
      jQuery.validator.addMethod("images", function(value, element) {
        var flag = false;
        if($('input[name="images[]"]').length > 0 ) {
          flag = true;
        }
        return flag;
      }, "Please input something");

        // 编辑器
        var editor = new UE.ui.Editor();
        editor.render("content");

        // 添加商品表单验证
        $('#addProduct').validate({
            rules: {
                title: "required",
                feature: "required",
                price:  "required",
                img:  "images",
                content: "required"
            },
            messages: {
                title: "请输入商品名称",
                feature: "请输入商品特性",
                price: "请输入商品价格",
                img: "请上传商品图片",
                content: "请输入商品详情"
            }
        });

        // 图片上传
        $(function () {
            var url = '/products/upload';
            $('#upload').fileupload({
                url: url,
                dataType: 'json',
                done: function (e, data) {
                    if(data.result.status == true) {
                        $('.insert_bottom').before('<dd><img src="' + data.result.data + '"><s class="close"></s><input type="hidden" name="images[]" value="'+data.result.data+'"/></li>');
                            $('#addProduct').valid();
                            $('.close').on('click', function() {
                                $(this).parent().remove();
                                $('#addProduct').valid();
                            });
                    } else {
                        $('input[name="img"]').next().remove();
                        $('input[name="img"]').after('<label for="img" class="error" style="">'+data.result.data+'</label');
                    }
                }
            });


        });
    </script>
