<?php
$this->title('我的云购');
?>
<div class="publish_side" id="feedMain">
  <div class="Comment_textbox">
    <textarea id="feed" name="feed" class="Comment-txt"></textarea>
  </div>
  <div class="Comment_button" id="counter">
    <span>您还可以输入<i>150</i>个字！</span>
    <button class="published disBtn">发布</button>
    <?php 
      if($this->user->role() == 100) {
          echo '<br/>发布公告格式：标题#内容';
      }
    ?>
  </div>
</div>
<div class="stream_items" id="feeds"></div>
<script type="text/javascript">
  $(function() {
    $('#feed').keydown(function(){
      feedCount();
    }).keyup(function(){
      feedCount();
    });

    var obj = $('#feedMain');
    obj.attr('url', '/posts/feed');
    loadFeed(obj);

    // 分页点击激活ajax
    $(document).on('click', '#divPageNav > ul > li > a', function(){
        loadFeed($(this));
    });

    $('#counter > button').click(function() {
      var id = $(this).attr('id');
      var content = $('#feed').val();

      if(!$(this).hasClass('disBtn')) {
        $.ajax({
          type: 'post',
          url: '/posts/addFeed',
          data: {id:id, content:content},
          beforeSend: function() {
            $('#counter > button').addClass('disBtn');
          },
          success: function(data) {
            if(data.status == 1) {
              $('#feed').val('');
              var obj = $('#feedMain');
              loadFeed(obj);
            }
          }
        });
      }
    });
  });

  function feedCount() {
    var fontlen = <?php echo $this->user->role() == 100 ? '1500' : '150'; ?>;
    var len = $('#feed').val().length;
    var left = fontlen - len;
    if(left > 0 && len > 0) {
      $('#counter > span').html('您还可以输入<i>'+left+'</i>个字！');
      $('#counter > button').removeClass('disBtn');
    } else if(len == 0) {
      $('#counter > span').html('您还可以输入<i>'+fontlen+'</i>个字！');
      $('#counter > button').addClass('disBtn');
    } else {
      left = len - fontlen;
      $('#counter > button').addClass('disBtn');
      $('#counter > span').html('<span class="orange">已超过'+left+'个字了，删除一些吧！</span>');
    }
  }

  feetInit = true;
  function loadFeed(obj) {
      var url = obj.attr('url');
      $.ajax({
          url: url,
          type: 'get',
          success: function(data) {
              $('#feeds').html(data);

              if(!feetInit) 
                  $("html,body").animate({scrollTop: $("#feedMain").offset().top}, 500);

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