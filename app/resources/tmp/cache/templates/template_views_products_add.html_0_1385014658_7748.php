<?php
$this->title('商品管理 > 添加商品');
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
           <h2>添加商品<a href="/products/dashboard" class="return_list">返回列表</a></h2>
          <?php echo $this->form->create($product, ['id' => 'addProduct']); ?>
          <ul>
              <li class="text_nums">
                  <?php echo $this->form->field(['title' => '名称'], ['style' => 'width: 400px']); ?>
              </li>
              <li class="text_nums">
                  <?php echo $this->form->field(['feature' => '特性'], ['style' => 'width:400px']); ?>
              </li>
              <li class="text_nums">
                  <?php
                  $cats = ['' => '--请选择--'] + $cats;
                  ?>
                  <?php echo $this->form->field(['cat_id' => '分类'], ['type' => 'select', 'list' => $cats] ); ?>
              </li>
              <li class="text_nums brand" style="display:none">
                  <?php echo $this->form->field(['brand_id' => '品牌'], ['type' => 'select', 'list' => ['' => '--请选择--']]); ?>
              </li>
              <li class="text_nums">
                  <?php echo $this->form->field(['price' => '价格'], ['template' => '<div tips="如:1999.99">{:label}{:input}{:error}</div>']); ?>
              </li>
              <li class="text_nums">
                  <?php echo $this->form->field(['images' => '图片'], ['template' =>'<div>{:label}<dl class="add_p_img"><dd class="insert_bottom">添加<input id="upload" type="file" name="file"></dd></dl><input id="ProductsImages" name="images[]" style="width:1px;height:1px;opacity: 0;-ms-filter: \'alpha(opacity=0)\';"></div>']); ?>
              </li>
              <li class="content_li">
                  <?php echo $this->form->field(['content' => '详情'], ['type' => 'textarea', 'id' => 'content', 'style'=>'height:600px;width:750px;margin-left:30px']); ?>
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
        // 编辑器
        editor = new UE.ui.Editor();
        editor.render("content");

        // 图片验证
        jQuery.validator.addMethod("images", function() {
          var flag = false;
          if($('input[name="images[]"]').length > 1 ) {
            flag = true;
          }
          return flag;
        });

        // 内容验证
        jQuery.validator.addMethod("content", function() {
            return editor.hasContents();
        });

        // 品牌验证
        jQuery.validator.addMethod("brand", function() {
            var flag = false;
            console.log($('.brand').css('display'));
            if($('.brand').css('display') == 'none') {
                flag = true;
            }

            if(!flag) {
                if($('#ProductsBrandId').val() != '') {
                    flag = true;
                }
            }

            return flag;
        });

        // 添加商品表单验证
        $('#addProduct').validate({
            rules: {
                title: "required",
                feature: "required",
                cat_id: "required",
                brand_id: "brand",
                price:  "required",
                'images[]': 'images',
                content: "content"
            },
            messages: {
                title: "请输入商品名称",
                feature: "请输入商品特性",
                cat_id: "请选择分类",
                brand_id: "请选择品牌",
                price: "请输入商品价格",
                'images[]' : '请上传图片',
                content: "请输入商品详情"
            },
            ignore: [],
            submitHandler: function(form) {
                $(form).find('input[name="file"]').remove();
                $('#ProductsImages').remove();
                form.submit();
            }
        });

        $(function () {
            // 品牌选择
            $('#ProductsCatId').change(function() {
                var cat_id = $(this).val();
                $.ajax({
                    url: '<?php echo $this->url('Products::brand'); ?>/'+cat_id,
                    dataType: 'json',
                    success: function(data) {
                        if(data.length != 0) {
                            var options = '<option value="">--请选择--</option>';
                            for(idx in data) {
                                options += '<option value="'+idx+'">' + data[idx].name + '</option>';
                            }
                            $('#ProductsBrandId').html(options);
                            $('.brand').show();
                        } else {
                            $('.brand').hide();
                        }
                    }
                });

            });

            // 图片上传
            var url = '<?php echo $this->url('Products::upload'); ?>';
            $('#upload').fileupload({
                url: url,
                dataType: 'json',
                done: function (e, data) {
                    if(data.result.status == true) {
                        $('.insert_bottom').before('<dd><img src="' + data.result.data + '"><s class="close"></s><input type="hidden" name="images[]" value="'+data.result.data+'"/></li>');
                            $('#ProductsImages').next().remove();
                            $('.close').on('click', function() {
                                $(this).parent().remove();
                                if($('input[name="images[]"]').length < 2 ) {
                                    $('#ProductsImages').after('<label for="ProductsImages" class="error">请上传图片</label');
                                }
                            });
                    } else {
                        $('#ProductsImages').next().remove();
                        $('#ProductsImages').after('<label for="ProductsImages" class="error">'+data.result.data+'</label');
                    }
                }
            });
        });
    </script>
