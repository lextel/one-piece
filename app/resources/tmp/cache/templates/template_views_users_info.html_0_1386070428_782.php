<?php
$this->title('会员资料');
?>
<div class="Current_nav"><a href="/">首页</a> &gt; 会员资料</div>
<div class="user_content">
    <div class="user_nav">
        <div class="user_pic">
            <img style="width: 60px; height: 60px" src="<?php echo $user['avatar'];?>" alt="<?php echo $user['nickname'];?>">
        </div>
        <div class="user_info">
            <h1>
                <?php echo $user['nickname'];?> <a href="">关注</a> <a href="">私信</a>
            </h1>
            <ul>
                <li><a href="/orders/user">云购记录</a></li>
                <li><a href="/products/my">获得的商品</a></li>
                <li><a href="/shares/share">晒单分享</a></li>
            </ul>
        </div>
    </div>
</div>