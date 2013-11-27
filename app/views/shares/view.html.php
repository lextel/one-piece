<?php
$this->title('晒单列表');
$this->styles($this->resLoader->css('product_list.css'));
?>
<div class="share_box" id="loadingPicBlock">
    <div id="DCMainLeft" class="share_box_left">
        <div class="share_main"> 
            <!--用户晒单部分-->
            <div class="share_title">
                <h3><?php echo $share['title']; ?></h3>
                <div class="share_time"> 晒单时间：<span><?php echo $this->times->friendlyDate($share['created']); ?></span></div>
            </div>
            <div class="share_goods">
                <div class="share-get"> <i></i> <a class="fl-img" href="http://u.1yyg.com/1000898861" target="_blank"><img src="http://faceimg.1yyg.com/UserFace/20131029144912263.jpg"></a>
                    <div class="share-getinfo">
                        <p class="getinfo-name">幸运获得者：<a class="blue Fb" href="http://u.1yyg.com/1000898861" target="_blank">土豪-姐姐请你</a></p>
                        <p>总共云购：<b class="orange">102</b>人次</p>
                        <p>幸运云购码：10000290</p>
                        <p>揭晓时间：2013-10-15 13:27:46.561</p>
                    </div>
                </div>
                <div class="share-Conduct">
                    <div class="arrow arrow_Rleft"> <em>◆</em><span>◆</span></div>
                    <a class="fl-img" href="http://www.1yyg.com/product/18406.html" target="_blank"><img src="http://goodsimg.1yyg.com/GoodsPic/pic-70-70/20130816134906377.jpg" border="0"></a>
                    <div class="share-getinfo">
                        <p class="getinfo-title"><a class="gray01" href="http://www.1yyg.com/product/18406.html" target="_blank">(第602期)小米（MIUI） 红米手机</a></p>
                        <p>价值：￥1288.00</p>
                        <p id="GoToBuy"><a class="getbut-a" href="http://www.1yyg.com/products/21344.html" target="_blank">第<span>960</span>期进行中… </a></p>
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
                    <div class="moodm hidden" style="display: block; "> <span class="smile" id="emHits"><i></i><b>羡慕嫉妒恨(<em><?php echo $share['good']; ?></em>)</b></span> <span class="much"> <i></i>评论(<em id="emReplyCount"><?php echo $total; ?></em>)</span> </div>
                </div>
            </div>
        </div>
        <input name="hidReplyCount" type="hidden" id="hidReplyCount" value="7">
        <input name="hidUserFace" type="hidden" id="hidUserFace" value="00000000000000000.jpg">
        <!--div id="bottomComment" class="qcomment_bottom_reply clearfix">
            <div class="Comment_Reply clearfix">
                <div class="Comment-pic"><img name="imgUserPhoto" src="http://faceimg.1yyg.com/UserFace/00000000000000000.jpg"></div>
                <div class="Comment_form">
                    <div id="divCommTo" class="Comment-name" style="display:none;"></div>
                    <div class="Comment_textbox">
                        <textarea id="replyTAM0" name="replyTA" class="hidden Comment-txt"></textarea>
                        <div id="notLogin" name="replyLogin" class="Comment_login" runat="server">请您<a href="javascript:;" class="blue" name="replyLoginBtn">登录</a>或<a href="http://passport.1yyg.com/register.html?forward=rego" class="blue">注册</a>后再回复评论</div>
                        <input type="button" id="btnReplyMsgM0" name="btnReplyMsg" class="hidden">
                    </div>
                </div>
            </div>
        </div-->
        <div class="Comment_Reply clearfix">
            <div class="Comment-pic" name="userFace">
                <img name="imgUserPhoto" src="http://faceimg.1yyg.com/UserFace/20131125203540957.jpg">
            </div>
            <div class="Comment_form">
                <div id="divCommTo" class="Comment-name" style="display:none;"></div>
                <div class="Comment_textbox">
                    <textarea id="comment" name="comment" class="Comment-txt"></textarea>
                </div>
                <div class="Comment_button" id="counter">
                    <span>您还可以输入<i>140</i>个字！</span>
                    <button class="disBtn">发表评论</button>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $(function() {
                $('#comment').keydown(function(){
                    commentCount();
                }).keyup(function(){
                    commentCount();
                });
            });

            function commentCount() {
                var len = $('#comment').val().length;
                var left = 140 - len;
                if(left >= 0) {
                    $('#counter > span').html('您还可以输入<i>'+left+'</i>个字！');
                } else {
                    left = len - 140;
                    $('#counter > span').html('<span class="orange">已超过'+left+'个字了，删除一些吧！</span>');
                }

            }
        </script>
        <div id="commentMain" class="qcomment_main" style="">
            <ul>
                <?php
                foreach($posts as $post) {
                ?>
                <li class="Comment_single">
                    <div class="Comment_box_con clearfix">
                        <div class="User_head"><a rel="nofollow" href="<?php echo $post['user_id']; ?>" target="_blank" title="<?php echo $post['user_id']; ?>"><img src="<?php echo $post['user_id']; ?>" alt=""></a></div>
                        <div class="Comment_con">
                            <div class="Comment_User"><span><a class="blue" href="<?php echo $post['user_id']; ?>" target="_blank"><?php echo $post['user_id']; ?></a></span></div>
                            <div class="C_summary"><?php echo $post['content']; ?><span class="Summary-time"><?php echo $this->times->friendlyDate($post['created']); ?></span><span class="Reply-r"><a class="blue signReplay" href="javascript:;">回复(<b>0</b>)</a>
                                <input name="replyDataState" type="hidden" value="0">
                                </span></div>
                        </div>
                        <div name="Replybox" class="qcomment_box_reply" style="display: none;">
                            <div class="qcomment_box_reply_topbj"></div>
                            <div name="ReplyForm" class="qcomment_reply_module"></div>
                            <div name="ReplyList" class="qcomment_reply_list_module"></div>
                            <div class="Comment_Collapse" style="display: none; "><a href="#">收起<b></b></a></div>
                        </div>
                        <div class="qhackbox"></div>
                        <div class="qcomment_box_bottom"></div>
                    </div>
                </li>
                <?php
                }
                ?>
            </ul>
            <!--分页开始-->
            <div id="divPageNav" class="pages" style="">
                <?= $this->Paginator->paginate();?>
            </div>
            <!--分页结束-->
        </div>
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
                        <div class="victory_head"><a class="blue" href="http://u.1yyg.com/1001425527" title="不之谜" target="_blank"><img src="http://faceimg.1yyg.com/UserFace/20131107113923463.jpg"></a></div>
                        <p class="victory_User"><a class="blue" href="http://u.1yyg.com/1001425527" title="不之谜" target="_blank">不之谜</a>获得了第959期</p>
                        <p><span class="gray03">暂未晒单</span></p>
                    </li>
                    <li class="victory_info">
                        <div class="victory_head"><a class="blue" href="http://u.1yyg.com/1000000091" title="向5S钱进" target="_blank"><img src="http://faceimg.1yyg.com/UserFace/20131105102304740.jpg"></a></div>
                        <p class="victory_User"><a class="blue" href="http://u.1yyg.com/1000000091" title="向5S钱进" target="_blank">向5S钱进</a>获得了第958期</p>
                        <p><span class="gray03">暂未晒单</span></p>
                    </li>
                    <li class="victory_info">
                        <div class="victory_head"><a class="blue" href="http://u.1yyg.com/1000174153" title="只对土豪有感" target="_blank"><img src="http://faceimg.1yyg.com/UserFace/20131024162740995.jpg"></a></div>
                        <p class="victory_User"><a class="blue" href="http://u.1yyg.com/1000174153" title="只对土豪有感" target="_blank">只对土豪</a>获得了第957期</p>
                        <p><span class="gray03">暂未晒单</span></p>
                    </li>
                    <li class="victory_info">
                        <div class="victory_head"><a class="blue" href="http://u.1yyg.com/1000101873" title="否极泰来" target="_blank"><img src="http://faceimg.1yyg.com/UserFace/20131012090235772.jpg"></a></div>
                        <p class="victory_User"><a class="blue" href="http://u.1yyg.com/1000101873" title="否极泰来" target="_blank">否极泰来</a>获得了第956期</p>
                        <p><span class="gray03">暂未晒单</span></p>
                    </li>
                    <li class="victory_info">
                        <div class="victory_head"><a class="blue" href="http://u.1yyg.com/1000987381" title="qxoqxo" target="_blank"><img src="http://faceimg.1yyg.com/UserFace/20131106091025577.jpg"></a></div>
                        <p class="victory_User"><a class="blue" href="http://u.1yyg.com/1000987381" title="qxoqxo" target="_blank">qxoqxo</a>获得了第955期</p>
                        <p><span class="gray03">暂未晒单</span></p>
                    </li>
                    <li class="victory_info">
                        <div class="victory_head"><a class="blue" href="http://u.1yyg.com/1000268557" title="whc-top" target="_blank"><img src="http://faceimg.1yyg.com/UserFace/20130822010721313.jpg"></a></div>
                        <p class="victory_User"><a class="blue" href="http://u.1yyg.com/1000268557" title="whc-top" target="_blank">whc-top</a>获得了第954期</p>
                        <p><span class="gray03">暂未晒单</span></p>
                    </li>
                </ul>
            </ul>
        </div>
        <div class="Comment_share">
            <h4>最新晒单</h4>
            <div class="New-single">
                <p class="New-single-time"><a class="blue" href="http://u.1yyg.com/1000898861" target="_blank">土豪-姐姐请你来做客</a>今天 07:33</p>
                <p class="New-single-C"><a href="http://post.1yyg.com/detail-3048.html" target="_blank">感谢云购抱着中500万的心态来玩云购吧<br>
                    大家一起来玩云购吧<br>
                    (*^__^*)&nbsp;嘻嘻……<br>
                    只要坚持就会中奖<br>
                    …</a></p>
                <div class="New-singleImg">
                    <div class="arrow arrow_Rleft"><em>◆</em></div>
                    <a href="http://post.1yyg.com/detail-3048.html" target="_blank"><img border="0" alt="" src="http://img.1yyg.com/UserPost/Small/20131107073308851.jpg" style=""><img border="0" alt="" src="http://img.1yyg.com/UserPost/Small/20131107073313304.jpg" style=""><img border="0" alt="" src="http://img.1yyg.com/UserPost/Small/20131107073317726.jpg" style=""></a></div>
            </div>
            <div class="New-single">
                <p class="New-single-time"><a class="blue" href="http://u.1yyg.com/1000753487" target="_blank">花了这么多还不中</a>今天 00:08</p>
                <p class="New-single-C"><a href="http://post.1yyg.com/detail-3047.html" target="_blank">在QQ上无意看到一元云购，第一次云购，看着他们1块2块就可以中了手机，那个嫉妒羡慕恨啊~~接着我…</a></p>
                <div class="New-singleImg">
                    <div class="arrow arrow_Rleft"><em>◆</em></div>
                    <a href="http://post.1yyg.com/detail-3047.html" target="_blank"><img border="0" alt="" src="http://img.1yyg.com/UserPost/Small/20131107000658504.jpg" style=""><img border="0" alt="" src="http://img.1yyg.com/UserPost/Small/20131107000707676.jpg" style=""><img border="0" alt="" src="http://img.1yyg.com/UserPost/Small/20131107000716238.jpg" style=""></a></div>
            </div>
            <div class="New-single">
                <p class="New-single-time"><a class="blue" href="http://u.1yyg.com/1000956863" target="_blank">中吧中吧我要中奖</a>昨天 23:51</p>
                <p class="New-single-C"><a href="http://post.1yyg.com/detail-3046.html" target="_blank">第一次中奖，也是朋友叫我玩，结果一玩就不可收拾。总投了快3000大元就中了这玩意，真心感动悲催…</a></p>
                <div class="New-singleImg">
                    <div class="arrow arrow_Rleft"><em>◆</em></div>
                    <a href="http://post.1yyg.com/detail-3046.html" target="_blank"><img border="0" alt="" src="http://img.1yyg.com/UserPost/Small/20131106235105088.jpg" style=""><img border="0" alt="" src="http://img.1yyg.com/UserPost/Small/20131106235117322.jpg" style=""><img border="0" alt="" src="http://img.1yyg.com/UserPost/Small/20131106235124807.jpg" style=""></a></div>
            </div>
            <div class="New-single">
                <p class="New-single-time"><a class="blue" href="http://u.1yyg.com/1000092511" target="_blank">中次奖z不容易</a>昨天 22:52</p>
                <p class="New-single-C"><a href="http://post.1yyg.com/detail-3045.html" target="_blank">MX2TD版，终于到手了，很漂亮!没及时发货加上咱是偏远地区云友，发的EMS所以才到手。给客服说过要…</a></p>
                <div class="New-singleImg">
                    <div class="arrow arrow_Rleft"><em>◆</em></div>
                    <a href="http://post.1yyg.com/detail-3045.html" target="_blank"><img border="0" alt="" src="http://img.1yyg.com/UserPost/Small/20131106224447442.jpg" style=""><img border="0" alt="" src="http://img.1yyg.com/UserPost/Small/20131106224745066.jpg" style=""><img border="0" alt="" src="http://img.1yyg.com/UserPost/Small/20131106224913878.jpg" style=""></a></div>
            </div>
        </div>
    </div>
</div>