<?php
$this->styles($this->resLoader->css('product_list.css'));
$this->scripts($this->resLoader->script('jquery.tools.min.js'));
$this->scripts($this->resLoader->script('details.js'));
$this->title($product['title']);
?>
<div class="Current_nav"><a href="/">首页</a> &gt; <a href="/products">所有分类</a>  &gt; 商品详情</div>
<?php
    echo $dump;
?>
<?php echo $this->mustache->render('products/view', compact('product')); ?>

<script>
$(function(){
    // 加载晒单
    if($('.Single_ConT').length > 0) {
        var obj = $('#divPost');
          // var obj = $('#feedMain');
          obj.attr('url', '/shares/product/<?php echo $product['id'];?>');
          loadShare(obj);
    }

  // 分页点击激活ajax
  $(document).on('click', '#divPageNav > ul > li > a', function(){
      loadShare($(this));
  });

});

feetInit = true;
function loadShare(obj) {
    var url = obj.attr('url');
    $.ajax({
        url: url,
        type: 'get',
        success: function(data) {
            $('#divPost').html(data);

            if(!feetInit) 
                $("html,body").animate({scrollTop: $("#divPost").offset().top}, 500);

            feetInit = false;

           // 分页强制转ajax
            $('#divPageNav > ul > li > a').each(function(){
                var url = $(this).attr('href');
                $(this).attr('href', 'javascript:void(0);');
                $(this).attr('url', url);
            });
        }
    });
}
</script>