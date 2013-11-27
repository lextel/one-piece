<div class="Current_nav">
    <a href="/">首页</a> &gt; 晒单分享
</div>
<div id="current" class="share_Curtit">
    <h1 class="fl">晒单分享</h1>
    <span id="spTotalCount">(共<em class="orange"><?=$total;?></em>个幸运获得者晒单)</span>
</div>
<div class="list_Sort">
    <dl>
        <dt>排序</dt>
        <dd>
            <a href="http://post.1yyg.com/list.html" id="new" class="SortCur">最新晒单</a>
            <a href="http://post.1yyg.com/list.html?r=20" id="popularity" class="">人气晒单</a>
            <a href="http://post.1yyg.com/list.html?r=30" id="comment" class="">评论最多</a>
        </dd>
    </dl>
</div>
<div id="loadingPicBlock" class="share_list">
    <div class="goods_share_listC">
        <ul>
            <li>
                <?php
                    if(isset($shares[0])) {
                    foreach($shares[0] as $share) {
                ?>
                <div class="share_list_content">
                    <dl>
                        <dt>
                            <a target="_blank" href="/shares/view/<?php echo $share['productId']; ?>/<?php echo $share['periodId']; ?>">
                                <img src="<?php echo $share['image'];?>"></a>
                        </dt>
                        <dd class="share-name gray02">
                            <a href="<?php echo $share['user_id'];?>" class="name-img">
                                <img border="0" alt="" src="<?php echo $share['user_id'];?>"></a>
                            <div class="share-name-r">
                                <span class="gray03">
                                    <a rel="nofollow" href="<?php echo $share['user_id'];?>" class="blue"><?php echo $share['user_id'];?></a>
                                    <?php echo $this->times->friendlyDate($share['created'])?>
                                </span>
                                <a class="Fb gray01" href="/shares/view/<?php echo $share['productId']; ?>/<?php echo $share['periodId']; ?>" target="_blank"><?php echo $share['title'];?></a>
                            </div>
                        </dd>
                        <dd class="share_info gray01"><?php echo $share['content']; ?></dd>
                        <dd class="message hidden" style="display: block;">
                            <span class="smile gray03"> <i></i> <b>羡慕( <em num="3620"><?php echo $share['good'];?></em>
                                    )</b> 
                            </span>
                            <span class="much">
                                <a target="_blank" rel="nofollow" href="/shares/view/<?php echo $share['productId']; ?>/<?php echo $share['periodId']; ?>" class="gray03"> <i></i>
                                    评论 <em>(<?php echo $share['comment'];?>)</em>
                                </a>
                            </span>
                        </dd>
                    </dl>
                    <p class="text-h10"></p>
                </div>
                <?php
                    }
                }
                ?>
             </li>
            
            <li>
            </li>
            <li class="share-liR">
                
            </li>
        </ul>
    </div>
    <!--分页开始-->
    <div id="divPageNav" class="pages" style="">
        <?= $this->Paginator->paginate();?>
    </div>
    <!--分页结束-->
</div>