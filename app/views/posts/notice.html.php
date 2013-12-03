<?php
$this->title('云购动态');
?>
<div class="Current_nav"><a href="/">首页</a> &gt; 动态内容</div>
<div id="divTopicShow" class="detail-content">
<div class="detail-Ctitle">
    <!--div class="detail-Ctimg">
        <a href="http://u.1yyg.com/1000759875" class="fl-img" uweb="1000759875" type="showCard">
            <img src="http://faceimg.1yyg.com/UserFace/20120913170030105.jpg" border="0" alt="">
        </a>
    </div-->
    <div class="detail-Ctl">
        <p class="detail-tit gray">
            <?php echo $details['title'];?> 
        </p>
            <div class="detail-Ctit gray03">
                <a rel="nofollow" href="/" class="blue" type="showCard">积分云购</a>
                <span class="class-icon07"><s></s>云购官方</span>
                <span class="time gray02"><?php echo $this->times->friendlyDate($details['created']);?></span>&nbsp;&nbsp;
            </div>
        </div>
    </div>
    <div id="divTopicContent" class="detail-Con gray01">
        <?php echo $details['content'];?>
    </div>
</div>