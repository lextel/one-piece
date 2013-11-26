<?php
$this->title('商品管理 > 编辑商品');
$this->scripts($this->resLoader->script('jquery.validate.js'));
$this->scripts($this->resLoader->script('additional-methods.min.js'));
$this->scripts($this->resLoader->script('jquery.ui.widget.js'));
$this->scripts($this->resLoader->script('jquery.iframe-transport.js'));
$this->scripts($this->resLoader->script('jquery.fileupload.js'));
$this->scripts($this->resLoader->script('umeditor/ueditor.config.js'));
$this->scripts($this->resLoader->script('umeditor/ueditor.all.min.js'));
$this->scripts($this->resLoader->script('umeditor/lang/zh-cn/zh-cn.js'));
?>
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
                  <?php echo $this->form->field(['cat_id' => '分类'], ['type' => 'select', 'list' => $cats, $catId]); ?>
              </li>
              <?php if(!empty($brands)){ ?>
              <li class="text_nums brand">
                <div>
                  <label for="ProductsBrandId">品牌</label>
                  <select name="brand_id" id="ProductsBrandId" class="valid">
                    <?php
                      foreach($brands as $key => $brand) {
                         $select = $key == $brandId ? ' selected' : '';
                         echo "<option value='{$key}' {$select}>{$brand['name']}</option>";
                      }
                    ?>
                  </select>
                </div>
              </li>
              <?php } ?>
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

            // 图片删除
            $('.add_p_img dd s').click(function() {
                $(this).parent().remove();
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
