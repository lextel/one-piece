<?php
$this->styles($this->resLoader->css('product_list.css'));
$this->scripts($this->resLoader->script('jquery.tools.min.js'));
$this->scripts($this->resLoader->script('details.js'));
$this->title($product['title']);
?>
<div class="Current_nav"><a href="/">首页</a> &gt; <a href="/products">所有分类</a>  &gt; 商品详情</div>
<?php
   // print_r($product);
?>
<?php echo $this->mustache->render('products/view', compact('product')); ?>

<script>
$(function(){
    // 加载晒单
    if($('.Single_ConT').length > 0) {
        var obj = $('#divPost');
          obj.attr('url', '/shares/product/<?php echo $product['id'];?>');
          loadShare(obj);
    }

    // 晒单分页点击激活ajax
    $(document).on('click', '#divPost > #divPageNav > ul > li > a', function(){
        loadShare($(this));
    });

    // 加载晒单
    if($('.All_RecordT').length > 0) {
        var obj = $('#divBuyRecord');
        obj.attr('url', '/orders/product/<?php echo $product['id'];?>/<?php echo $product['periodId']; ?>');
        loadOrder(obj);
    }

  // 晒单分页点击激活ajax
  $(document).on('click', '#divBuyRecord > #divPageNav > ul > li > a', function(){
      loadOrder($(this));
  });

  // 加入购物车
  $('.Det_Cart, #btnAdd2Cart').click(function(){
        var quantity  = $('.num_dig').val();
        var productId = $(this).attr('productId');
        var periodId  = $(this).attr('periodId');

        $('#sCartlist').show();
        
        $.ajax({
            url: '/cart/add',
            data: {productId: productId, periodId: periodId, quantity: quantity},
            type: 'post',
            dataType: 'json',
            success: function(data) {
                showCarts(data);
            }
        });
  });

    // 倒计时
    if($('.announceing_frame').length > 0) {
        sh=setInterval(countDown,10);  
    }
});

<?php
if($product['showFull'] && !$product['showResult']) :
?>

function countDown() {
     var endtime = new Date("<?php echo date('Y-m-d H:i:s', $product['showed']); ?>");  
     var nowtime = new Date();  
     var second = parseInt((endtime.getTime()-nowtime.getTime())/1000);  
     var min = parseInt((second/60)%60);  
     var sec = parseInt(second%60);  
     var c= new Date();
     var msec = c.getMilliseconds();

    if(min < 10) {
        min = '0' + min;
    }

    if(sec < 10) {
        sec = '0' + sec;
    }

    if(msec < 100) {
        msec = '0' + msec;
    } else if(msec < 10) {
        msec = '00' + msec;
    }

    var lefttime = '';
    lefttime += min.toString();
    lefttime += sec.toString();
    lefttime += msec.toString();

    var min1 = lefttime.substr(0,1);
    var min2 = lefttime.substr(1,1);
    var sec1 = lefttime.substr(2,1);
    var sec2 = lefttime.substr(3,1);
    var msec1 = lefttime.substr(4,1);
    var msec2 = lefttime.substr(5,1);

    var timer = '<li class="Code_'+min1+'">'+min1+'<b></b></li>' +
                '<li class="Code_'+min2+'">'+min2+'<b></b></li>' + 
                '<li class="colon"><b></b></li>' + 
                '<li class="Code_'+sec1+'">'+sec1+'<b></b></li>' + 
                '<li class="Code_'+sec2+'">'+sec2+'<b></b></li>' + 
                '<li class="colon"><b></b></li>' + 
                '<li class="Code_'+msec1+'">'+msec1+'<b></b></li>' + 
                '<li class="Code_'+msec2+'">'+msec2+'<b></b></li>';

    $('#countDown').html(timer);

    if(min.toString() == '04' && sec > 30) {
      $('.announceing_get').find('img').attr('src', '/img/10.gif');
    } else if(min.toString() == '04' && sec <= 30) {
      $('.announceing_get').find('img').attr('src', '/img/9.gif');
    } else if(min.toString() == '03' && sec > 30) {
      $('.announceing_get').find('img').attr('src', '/img/8.gif');
    } else if(min.toString() == '03' && sec <= 30) {
      $('.announceing_get').find('img').attr('src', '/img/7.gif');
    } else if(min.toString() == '02' && sec > 30) {
      $('.announceing_get').find('img').attr('src', '/img/6.gif');
    } else if(min.toString() == '02' && sec <= 30) {
      $('.announceing_get').find('img').attr('src', '/img/5.gif');
    } else if(min.toString() == '01' && sec > 30) {
      $('.announceing_get').find('img').attr('src', '/img/4.gif');
    } else if(min.toString() == '01' && sec <= 30) {
      $('.announceing_get').find('img').attr('src', '/img/3.gif');
    } else if(min.toString() == '00' && sec > 30) {
      $('.announceing_get').find('img').attr('src', '/img/2.gif');
    } else if(min.toString() == '00' && sec <= 30) {
      $('.announceing_get').find('img').attr('src', '/img/1.gif');
    }

    if(second<=0){
      $('.announceing_frame').hide();
      $('.calculate').show();
      clearInterval(sh);  

      // 获取结果
      sh=setInterval(showResult,1000);
    }
}
<?php
endif;
?>

function showResult() {
  $.ajax({
    url: '/products/lottery/<?php echo $product['id']?>/<?php echo $product['periodId']?>',
    type: 'get',
    dataType: 'json',
    success: function(data){
        if(data.status == 1) {
          $('.calculate').hide();
          var codes = '';
          for(var i in data.code) {
            codes += '<li class="Code_'+data.code[i]+'">'+data.code[i]+'<b></b></li>';
           }
          $('.Announced_FrameCodeMal').html(codes);
          var winner = '<dl>';
              winner += '<dt><a rel="nofollow" href="/users/info/'+data.userId+'" target="_blank" title=""><img width="60" height="60" src="'+data.avatar+'"></a></dt>';
              winner += '<dd class="gray02">';
              winner += '<p>恭喜<a href="" target="_blank" class="blue" title="">'+data.nickname+'</a>获得</p>';
              winner += '<p>揭晓时间：'+data.ordered+'</p>';
              winner += '<p>云购时间：'+data.showed+'</p>';
              winner += '</dd>';
              winner += '</dl>';

          $('.Announced_FrameGet').html(winner);
          $('.Announced_Frame').show();
          clearInterval(sh);
        }
    }
  });

}

shareInit = true;
function loadShare(obj) {
    var url = obj.attr('url');
    $.ajax({
        url: url,
        type: 'get',
        success: function(data) {
            $('#divPost').html(data);

            if(!shareInit) 
                $("html,body").animate({scrollTop: $("#divPost").offset().top}, 500);

            shareInit = false;

           // 分页强制转ajax
            $('#divPost > #divPageNav > ul > li > a').each(function(){
                var url = $(this).attr('href');
                $(this).attr('href', 'javascript:void(0);');
                $(this).attr('url', url);
            });
        }
    });
}

orderInit = true;
function loadOrder(obj) {
    var url = obj.attr('url');
    $.ajax({
        url: url,
        type: 'get',
        success: function(data) {
            $('#divBuyRecord').html(data);

            if(!orderInit) 
                $("html,body").animate({scrollTop: $("#divBuyRecord").offset().top}, 500);

            orderInit = false;

           // 分页强制转ajax
            $('#divBuyRecord > #divPageNav > ul > li > a').each(function(){
                var url = $(this).attr('href');
                $(this).attr('href', 'javascript:void(0);');
                $(this).attr('url', url);
            });
        }
    });
}
</script>