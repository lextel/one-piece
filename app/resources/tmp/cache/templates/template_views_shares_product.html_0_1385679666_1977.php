<?php
foreach($shares as $share) {
?>
<div name="pitem" class="Single_list">
    <div class="SingleL fl Topiclist-img"><a class="head-img" href="http://u.1yyg.com/1000066052" target="_blank" type="showCard" uweb="1000066052"><img border="0" alt="" src="http://faceimg.1yyg.com/UserFace/20131105210145983.jpg"></a><a class="blue" href="http://u.1yyg.com/1000066052" target="_blank" rel="nofollow" type="showCard" uweb="1000066052">只想中M3</a><span class="class-icon01"><s></s>云购小将</span></div>
    <div class="SingleR fl">
        <div class="SingleR_TC"><i></i> <s></s>
            <h3><span class="gray02">第期晒单</span> <a href="http://post.1yyg.com/detail-2992.html" target="_blank">16G闪迪U盘</a> <em class="gray02">昨天 13:00</em></h3>
            <p class="gray01">最近准备买个U盘用用，我想还不如去晕狗碰碰运气，真的很幸运真的中了，这U盘不错，发货速度很快，但是抱歉 我太过于兴奋忘了把包装拍下来了，希望下次再中，下次一定不会再忘记了，大家要多支持云购。。</p>
        </div>
        <ul class="SingleR_pic">
            <li><img src="http://postimg.1yyg.com/UserPost/Small/20131105130011561.jpg"></li>
            <li><img src="http://postimg.1yyg.com/UserPost/Small/20131105130017795.jpg"></li>
            <li><img src="http://postimg.1yyg.com/UserPost/Small/20131105130023373.jpg"></li>
        </ul>
        <div class="SingleR_Comment" postid="2992" count="0">
            <div class="Comment_smile gray02"><span><i></i>4人羡慕嫉妒恨</span><span><s></s>0条评论</span></div>
        </div>
    </div>
</div>
<?php
}
if(empty($shares)) {
?>
<div id="divPost" class="Single_Content" style="">
   <div class="NoConMsg"><span>暂无晒单记录哦~！</span></div>
</div>
<?php
}
?>
<!--分页开始-->
<div id="divPageNav" class="pages" style="">
    <?php echo $this->Paginator->paginate(); ?>
</div>
<!--分页结束-->