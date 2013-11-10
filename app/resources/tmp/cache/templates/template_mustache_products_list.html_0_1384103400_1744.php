<ul class="item" id="ulGoodsList">
{{# products }}
    <li class="goods-iten" codeid="19008">
        <div class="pic">
            <a rel="nofollow" href="/products/view/{{ _id }}" target="_blank" title="{{ title }}">
                <i class="goods_xs"></i>
                <img alt="{{ title }}" src="{{ images.0 }}">
            </a>
            <p name="buyCount" style="display: none; ">&nbsp;</p>
        </div>
        <p class="name"><a href="/products/view/{{ _id }}" target="_blank" title="{{ title }}">{{ title }}</a></p>
        <p class="money">价值：<span class="rmbgray">{{ price }}</span></p>
        <div class="Progress-bar">
            <p title="已完成100.00%"><span style="width:213px;"></span></p>
            <ul class="Pro-bar-li">
                <li class="P-bar01"><em>{{ person }}</em>已参与人次</li>
                <li class="P-bar02"><em>{{ person }}</em>总需人次</li>
                <li class="P-bar03"><em>{{ remain }}</em>剩余人次</li>
            </ul>
        </div>
        <div class="gl_buybtn">
            <div class="error" style="display: none;">最少需云购1人次</div>
            <div class="gl_number">我要云购 <a href="javascript:void();" class="num_del num_ban">-</a>
                <input type="text" surplus="0" value="1" class="num_dig">
                <a href="javascript:void();" class="num_add">+</a> 人次</div>
            <div class="go_buy"><a href="javascript:void();" title="立即1元云购" class="go_Shopping fl">立即1元云购</a><a href="javascript:void();" title="加入购物车" class="go_cart fr">加入购物车</a></div>
        </div>
        <div class="goods_Curbor"></div>
    </li>
{{/ products }}
</ul>