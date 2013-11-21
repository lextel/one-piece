<?php
$this->title('会员中心 > 晒单');
$this->scripts($this->resLoader->script('jquery.validate.js'));
$this->scripts($this->resLoader->script('additional-methods.min.js'));
$this->scripts($this->resLoader->script('jquery.ui.widget.js'));
$this->scripts($this->resLoader->script('jquery.iframe-transport.js'));
$this->scripts($this->resLoader->script('jquery.fileupload.js'));

?>
<div class="add_product">
   <h2>晒单<a href="/shares/share" class="return_list">返回列表</a></h2>
    <form action="/shares/add" method="post" id="addShare">
    <ul>
      <li class="text_nums">
        <div>
        <span style="font-size: 14px; padding-left: 84px">(第<?php echo $h($share['periodId']); ?>期) <?php echo $h($share['title']); ?></span>
        </div>
      </li>
      <li class="text_nums">
        <div>
        <label>标题</label><input type="text" name="title" style="width: 400px" />
        </div>
      </li>
      <li class="text_nums">
        <div>
          <label>图片</label>
          <dl class="add_p_img"><dd class="insert_bottom">添加<input id="upload" type="file" name="file"></dd></dl><input id="ProductsImages" name="images[]" style="width:1px;height:1px;opacity: 0;-ms-filter: 'alpha(opacity=0)';">
        </div>
      </li>
      <li class="content_li">
        <div>
          <label>内容</label>
          <textarea id="content" name="content" style="height:300px;width:750px;margin-left:30px"></textarea>
      </li>
      <li>
        <div class="bottom_side">
            <input type="submit" class="published" value="提交"/>
            <input type="reset" class="canal" value="重置"/>
        </div>
       </li>
    </ul>
    </form>
</div>
    <script type="text/javascript">

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

        // 晒单表单验证
        $('#addShare').validate({
            rules: {
                title: "required",
                'images[]': 'images',
                content: "required"
            },
            messages: {
                title: "请输入晒单标题",
                'images[]' : '请上传图片',
                content: "描述一下中奖感受"
            },
            ignore: [],
            submitHandler: function(form) {
                $(form).find('input[name="file"]').remove();
                $('#ProductsImages').remove();
                form.submit();
            }
        });

        $(function () {
            // 图片上传
            var url = '<?php echo $this->url('Shares::upload'); ?>';
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
