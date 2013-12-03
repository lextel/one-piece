<?php
$this->title($share['title']);
$this->styles($this->resLoader->css('product_list.css'));
?>
<div class="Current_nav">
    <a href="/">首页</a> &gt; <a href="/shares">晒单分享</a> &gt; 晒单详情
</div>
<div class="share_box" id="loadingPicBlock">
    <div id="DCMainLeft" class="share_box_left">
        <div class="share_main"> 
            <!--用户晒单部分-->
            <div class="share_title">
                <h3><?php echo $share['title']; ?></h3>
                <div class="share_time"> 晒单时间：<span><?php echo $this->times->friendlyDate($share['created']); ?></span></div>
            </div>
            <div class="share_goods">
                <div class="share-get"> <i></i> <a class="fl-img" href="/users/info/<?php echo $winner['user']['_id']; ?>" target="_blank"><img src="<?php echo $winner['user']['avatar']; ?>"></a>
                    <div class="share-getinfo">
                        <p class="getinfo-name">幸运获得者：<a class="blue Fb" href="/users/info/<?php echo $winner['user']['_id']; ?>" target="_blank"><?php echo $winner['user']['nickname']; ?></a></p>
                        <p>总共云购：<b class="orange"><?php echo count($winner['orderTotal']); ?></b>人次</p>
                        <p>幸运云购码：<?php echo $winner['periods'][0]['code']; ?></p>
                        <p>揭晓时间：<?php echo $this->times->friendlyDate($winner['periods'][0]['showed']); ?></p>
                    </div>
                </div>
                <div class="share-Conduct">
                    <div class="arrow arrow_Rleft"> <em>◆</em><span>◆</span></div>
                    <a class="fl-img" href="/products/view/<?php echo $winner['_id'];?>/<?php echo $winner['periods'][0]['id'];?>" target="_blank"><img src="<?php echo $winner['images'][0]; ?>" border="0"></a>
                    <div class="share-getinfo">
                        <p class="getinfo-title"><a class="gray01" href="/products/view/<?php echo $winner['_id'];?>/<?php echo $winner['periods'][0]['id'];?>" target="_blank">(第<?php echo $winner['periods'][0]['id']; ?>期)<?php echo $winner['title']; ?></a></p>
                        <p>价值：￥<?php echo sprintf('%.2f', $winner['price']); ?></p>
                        <?php if($active['status'] > 0 ) {?>
                        <p id="GoToBuy"><a class="getbut-a" href="/products/view/<?php echo $active['_id'];?>/<?php echo $active['periods'][0]['id'];?>" target="_blank">第<span><?php echo $active['periods'][0]['id'];?></span>期进行中… </a></p>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="share_content">
                <p class="content-pad"><?php echo $share['content']; ?></p>
                <?php 
                    foreach($share['images'] as $image) {
                        echo '<p><img src="'.$image.'" border="0" alt="" style=""></p>';
                    }
                ?>
            </div>
            <!--用户晒单部分结束--> 
            <!-- 分享按钮 -->
            <div class="mood">
                <div class="moodwm">
                    <div class="moodm hidden" style="display: block; "> 
                    <span class="smile" id="emHits">羡慕(<em><?php echo $share['good']; ?></em>)</span> 
                    <span class="much"><a href="#">评论(<em id="emReplyCount"><?php echo $total; ?></em>)</a></span> 
                </div>
                </div>
            </div>
        </div>
        <?php if(!$this->user->id()) : ?>
        <div id="bottomComment" class="qcomment_bottom_reply clearfix">
            <div class="Comment_Reply clearfix">
                <div class="Comment-pic"><img name="imgUserPhoto" src="/images/avatar/5/d/529af03b7572a79415000029.jpg"></div>
                <div class="Comment_form">
                    <div id="divCommTo" class="Comment-name" style="display:none;"></div>
                    <div class="Comment_textbox">
                        <textarea id="replyTAM0" name="replyTA" class="hidden Comment-txt"></textarea>
                        <div id="notLogin" name="replyLogin" class="Comment_login" runat="server">请您<a href="/users/login" class="blue" name="replyLoginBtn">登录</a>或<a href="/users/register" class="blue">注册</a>后再回复评论</div>
                        <input type="button" id="btnReplyMsgM0" name="btnReplyMsg" class="hidden">
                    </div>
                </div>
            </div>
        </div>
        <?php else : ?>
        <div id="bottomComment" class="Comment_Reply clearfix">
            <div class="Comment-pic" name="userFace">
                <img name="imgUserPhoto" src="<?php echo $this->user->avatar()?>">
            </div>
            <div class="Comment_form">
                <div id="divCommTo" class="Comment-name" style="display:none;"></div>
                <div class="Comment_textbox">
                    <textarea id="comment" name="comment" class="Comment-txt"></textarea>
                </div>
                <div class="Comment_button" id="counter">
                    <span>您还可以输入<i>150</i>个字！</span>
                    <button class="published disBtn" id="<?php echo $share['_id'];?>">发表评论</button>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <script type="text/javascript">
            $(function() {
                $('#comment').keydown(function(){
                    commentCount();
                }).keyup(function(){
                    commentCount();
                });

                $('#counter > button').click(function() {
                    var id = $(this).attr('id');
                    var content = $('#comment').val();

                    if(!$(this).hasClass('disBtn')) {
                        $.ajax({
                            type: 'post',
                            url: '/posts/addComment',
                            data: {id:id, content:content},
                            beforeSend: function() {
                                $('#counter > button').addClass('disBtn');
                            },
                            success: function(data) {
                                if(data.status == 1) {
                                    $('#comment').val('');
                                    var obj = $('#commentMain');
                                    loadComment(obj);
                                }
                            }
                        });
                    }
                });
            });

        function commentCount() {
          var fontlen = 150;
          var len = $('#comment').val().length;
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
        </script>
        <div id="commentMain" class="qcomment_main" style="">
        </div>
        <script type="text/javascript">
            var postId = '<?php echo $share['_id']; ?>';
            commonInit = true;
            $(function(){
                var obj = $('#commentMain');
                obj.attr('url', '/posts/comment/' + postId);
                loadComment(obj);

                // 分页点击激活ajax
                $(document).on('click', '#divPageNav > ul > li > a', function(){
                    loadComment($(this));
                });
            });

            function loadComment(obj) {
                var url = obj.attr('url');
                $.ajax({
                    url: url,
                    type: 'get',
                    success: function(data) {
                        $('#commentMain').html(data);

                        if(!commonInit) 
                            $("html,body").animate({scrollTop: $("#bottomComment").offset().top}, 500);

                        commonInit = false;
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
        
        <!--用户评论列表开始-->
        <div class="Comment_main clearfix" id="CommentMain"></div>
        <!--用户评论部分结束--> 
    </div>
    <!--晒单左侧结束--> 
    <!--晒单右侧-->
    <div class="Comment_right" id="PostDetailRight">
        <div class="Comment_victory">
            <div class="victory-tit"><span><a href="javascript:void(0);" class="page-upgray"></a><a href="javascript:void(0);" class="page-updow page-dow"></a></span>
                <h3>其他期数获得者</h3>
            </div>
            <ul>
                <ul>
                    <li class="victory_info">
                        <div class="victory_head"><a class="blue" href="#" title="不之谜" target="_blank"><img src="#"></a></div>
                        <p class="victory_User"><a class="blue" href="#" title="不之谜" target="_blank">不之谜</a>获得了第959期</p>
                        <p><span class="gray03">暂未晒单</span></p>
                    </li>
                    <li class="victory_info">
                        <div class="victory_head"><a class="blue" href="#" title="向5S钱进" target="_blank"><img src="#"></a></div>
                        <p class="victory_User"><a class="blue" href="#" title="向5S钱进" target="_blank">向5S钱进</a>获得了第958期</p>
                        <p><span class="gray03">暂未晒单</span></p>
                    </li>
                    <li class="victory_info">
                        <div class="victory_head"><a class="blue" href="#" title="只对土豪有感" target="_blank"><img src="#"></a></div>
                        <p class="victory_User"><a class="blue" href="#" title="只对土豪有感" target="_blank">只对土豪</a>获得了第957期</p>
                        <p><span class="gray03">暂未晒单</span></p>
                    </li>
                    <li class="victory_info">
                        <div class="victory_head"><a class="blue" href="#" title="否极泰来" target="_blank"><img src="#"></a></div>
                        <p class="victory_User"><a class="blue" href="#" title="否极泰来" target="_blank">否极泰来</a>获得了第956期</p>
                        <p><span class="gray03">暂未晒单</span></p>
                    </li>
                    <li class="victory_info">
                        <div class="victory_head"><a class="blue" href="#" title="qxoqxo" target="_blank"><img src="#"></a></div>
                        <p class="victory_User"><a class="blue" href="#" title="qxoqxo" target="_blank">qxoqxo</a>获得了第955期</p>
                        <p><span class="gray03">暂未晒单</span></p>
                    </li>
                    <li class="victory_info">
                        <div class="victory_head"><a class="blue" href="#" title="whc-top" target="_blank"><img src="#"></a></div>
                        <p class="victory_User"><a class="blue" href="#" title="whc-top" target="_blank">whc-top</a>获得了第954期</p>
                        <p><span class="gray03">暂未晒单</span></p>
                    </li>
                </ul>
            </ul>
        </div>
        <div class="Comment_share">
            <h4>最新晒单</h4>
            <div class="New-single">
                <p class="New-single-time"><a class="blue" href="#" target="_blank">土豪-姐姐请你来做客</a>今天 07:33</p>
                <p class="New-single-C"><a href="#" target="_blank">感谢云购抱着中500万的心态来玩云购吧<br>
                    大家一起来玩云购吧<br>
                    (*^__^*)&nbsp;嘻嘻……<br>
                    只要坚持就会中奖<br>
                    …</a></p>
                <div class="New-singleImg">
                    <div class="arrow arrow_Rleft"><em>◆</em></div>
                    <a href="#" target="_blank"><img border="0" alt="" src="#" style=""><img border="0" alt="" src="#" style=""><img border="0" alt="" src="#" style=""></a></div>
            </div>
            <div class="New-single">
                <p class="New-single-time"><a class="blue" href="#" target="_blank">花了这么多还不中</a>今天 00:08</p>
                <p class="New-single-C"><a href="#" target="_blank">在QQ上无意看到一元云购，第一次云购，看着他们1块2块就可以中了手机，那个嫉妒羡慕恨啊~~接着我…</a></p>
                <div class="New-singleImg">
                    <div class="arrow arrow_Rleft"><em>◆</em></div>
                    <a href="#" target="_blank"><img border="0" alt="" src="#" style=""><img border="0" alt="" src="#" style=""><img border="0" alt="" src="#" style=""></a></div>
            </div>
            <div class="New-single">
                <p class="New-single-time"><a class="blue" href="#" target="_blank">中吧中吧我要中奖</a>昨天 23:51</p>
                <p class="New-single-C"><a href="#" target="_blank">第一次中奖，也是朋友叫我玩，结果一玩就不可收拾。总投了快3000大元就中了这玩意，真心感动悲催…</a></p>
                <div class="New-singleImg">
                    <div class="arrow arrow_Rleft"><em>◆</em></div>
                    <a href="#" target="_blank"><img border="0" alt="" src="#" style=""><img border="0" alt="" src="#" style=""><img border="0" alt="" src="#" style=""></a></div>
            </div>
            <div class="New-single">
                <p class="New-single-time"><a class="blue" href="#" target="_blank">中次奖z不容易</a>昨天 22:52</p>
                <p class="New-single-C"><a href="#" target="_blank">MX2TD版，终于到手了，很漂亮!没及时发货加上咱是偏远地区云友，发的EMS所以才到手。给客服说过要…</a></p>
                <div class="New-singleImg">
                    <div class="arrow arrow_Rleft"><em>◆</em></div>
                    <a href="#" target="_blank"><img border="0" alt="" src="#" style=""><img border="0" alt="" src="#" style=""><img border="0" alt="" src="#" style=""></a></div>
            </div>
        </div>
    </div>
</div>