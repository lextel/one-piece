{{# product }}
<div class="show_content">
    <!--商品期数开始-->
    <div id="divPeriodList" class="show_Period">
    <div class="period_Open"><a class="gray02" id="btnOpenPeriod" href="javascript:void(0);">展开<i></i></a></div>
        <ul class="Period_list">
            {{# product.periodIds }}
                {{# class }}
                    {{# active }}
                    <li><a href="/products/view/{{ product.id }}/{{ id }}"><b class="{{ class }}">第{{ id }}期<i></i></b></a></li>
                    {{/ active}}
                    {{^ active }}
                    <li><b class="{{ class }}">第{{ id }}期</b></li>
                    {{/ active}}
                {{/ class}}
                {{^ class }}
                    <li><a href="/products/view/{{ product.id }}/{{ id }}" class="gray02">第{{ id }}期</a></li>
                {{/ class }}
                {{# separator }}
                </ul><ul class="Period_list">
                {{/ separator }}
            {{/ product.periodIds }}
         </ul>
     </div>
    <!--商品期数结束-->
    <!--商品简要开始-->
    <div class="Pro_Details">
        <h1><span>(第{{ periodId }}期)</span>{{ title }}{{# showFeature }}<span class="red">{{ feature }}</span>{{/ showFeature }}</h1>
        <div class="Pro_Detleft">
            {{# showActive }}
            {{# activePeriod }}
            <div class="Pro_Detimg">
				<div class="Pro_pic"><a href="/products/view/{{ product.id }}/{{ id }}" title="{{ product.title }}"><img width="398" height="398" alt="{{ product.title }}" src="{{ images.0 }}"></a><span>限时揭晓</span></div>
			</div>
            <div class="Result_LConduct">
				<dl>
                    <dt><span>第{{ id }}期</span>正在进行</dt>
                    <dd>
                        <div class="Result_Progress-bar">
                            <p title="已完成{{ percent }}%"><span style="width:{{ percent }}%;"></span></p>
                            <ul class="Pro-bar-li">
                                <li class="P-bar01"><em>{{ join }}</em>已参与人次</li>
                                <li class="P-bar02"><em>{{ person }}</em>总需人次</li>
                                <li class="P-bar03"><em>{{ remain }}</em>剩余人次</li>
                            </ul>
                        </div>
                        <p><a href="/products/view/{{ product.id }}/{{ id }}" target="_blank" class="Result_LConductBut">查看详情</a></p>
                    </dd>
                </dl>
			</div>
            {{/ activePeriod }}
            {{/ showActive }}
            {{^ showActive }}
            <div class="detail-itemsummary-imageviewer">
                <div id="middlePicRemark" class="middlePicRemark"></div>
                <img id="imgGoodsPic" alt="" src="{{ images.0 }}" style="width:396px; height:396px; display:none;">
                <div id="middlePicBox" class="middlePicBox" style="position: relative; ">
                    <span id="BigViewImage" class="jqzoom" style="outline-style: none; cursor: crosshair; display: block; position: relative; height: 396px; width: 396px; ">
                        <img id="viewImage" style="width: 396px; height: 396px; position: absolute; top: 0px; left: 0px; " src="{{ images.0 }}">
                    </span>
                </div>
                <div class="smallPicList">
                    <div class="hidden" style="display: none; "></div>
                    <div class="jcarousel-clip">
                        <ul id="mycarousel" style="width: 378px; left: 0px; display: block; ">
                            <?php
                            foreach($product['images'] as $k => $image):
                                $class = $k == 0 ? 'curr' : '';
                            ?>
                            <li class="<?php echo $class; ?>"><img width="48" height="48" src="<?php echo $image; ?>" alt="" name=""></li>
                            <?php endforeach; ?>
                            <div class="hackbox"></div>
                        </ul>
                    </div>
                    <div class="hidden" style="display: none; "></div>
                </div>
            </div>
            {{# showWinner }}
            <div class="Pro_GetPrize">
                <h2>上期获得者</h2>
                <div class="GetPrize">
                    <dl>
                        <dt><a rel="nofollow" href="javascript:void(0);" src="http://faceimg.1yyg.com/UserFace/20131105093925504.jpg"></a></dt>
                        <dd class="gray02">
                            <p>恭喜 <a href="javascript:void(0);" class="blue">坑才不坑爹</a> (北京市) 获得了本商品</p>
                            <p>揭晓时间：2013-11-06 12:07:03.647</p>
                            <p>云购时间：2013-11-05 22:48:17.193</p>
                            <p>幸运云购码：<em class="orange Fb">10001873</em></p>
                        </dd>
                    </dl>
                </div>
            </div>
            {{/ showWinner }}
            {{/ showActive }}
        </div>
        <div class="Pro_Detright">
                {{# showSoldOut }}
                <div class="End_DetailsExplain">本商品已结束云购！</div>
                {{/ showSoldOut }}
                {{^ showSoldOut }}
                <p class="Det_money">价值：<span class="rmbgray">{{ price }}</span></p>
                {{# showFull }}
                {{^ showResult }}
                <!--倒计时 begin-->
                <div class="announceing_frame" style="display:block">
                    <div class="announceing_tltle">揭晓倒计时</div>
                    <div class="announceing_code">
                        <div class="announceing_clock"></div>
                        <ul id="countDown">
                            <li class="Code_0">0<b></b></li>
                            <li class="Code_0">0<b></b></li>
                            <li class="colon"><b></b></li>
                            <li class="Code_0">0<b></b></li>
                            <li class="Code_0">0<b></b></li>
                            <li class="colon"><b></b></li>
                            <li class="Code_0">0<b></b></li>
                            <li class="Code_0">0<b></b></li>
                        </ul>
                    </div>
                    <div class="announceing_get">
                        <img src="/img/10.gif">
                    </div>
                </div>
                <!--倒计时 end-->
                <!--计算中 begin-->
                <div class="calculate" style="display:none">
                    <div class="calculate_tltle">正在计算</div>
                    <div class="calculate_c">
                        <img src="/img/Announced_6.png">
                        <img src="/img/Announced_4.gif">
                    </div>
                    <div class="Announced_FrameBm"></div>
                 </div>
                <!-- 计算中 end -->
                <!-- 揭晓 begin -->
                <div class="Announced_Frame" style="display:none">
                    <div class="Announced_FrameT">揭晓结果</div>
                    <div class="Announced_FrameCode">
                        <ul class="Announced_FrameCodeMal">
                            <li class="Code_0">0<b></b></li>
                            <li class="Code_0">0<b></b></li>
                            <li class="Code_0">0<b></b></li>
                            <li class="Code_0">0<b></b></li>
                            <li class="Code_0">0<b></b></li>
                            <li class="Code_0">0<b></b></li>
                            <li class="Code_0">0<b></b></li>
                            <li class="Code_0">0<b></b></li>
                        </ul>
                    </div>
                    <div class="Announced_FrameGet">

                    </div>
                    <div class="Announced_FrameBut">
                        <a href="javascript:void(0);" class="Announced_But divShowResult">本期详细计算结果</a>
                        <a href="javascript:void(0);" class="Announced_But">看看有谁参与了</a>
                        <a href="javascript:void(0);" class="Announced_But">看看有谁晒单</a>
                    </div>
                    <div class="Announced_FrameBm"></div>
                </div>
                <!-- 揭晓 end -->
                {{/ showResult }}
                {{/ showFull }}
                {{# showResult }}
                <div class="Announced_Frame">
					<div class="Announced_FrameT">揭晓结果</div>
					<div class="Announced_FrameCode">
						<ul class="Announced_FrameCodeMal">
						    <li class="Code_{{ code.0 }}">{{ code.0 }}<b></b></li><li class="Code_{{ code.1 }}">{{ code.1 }}<b></b></li><li class="Code_{{ code.2 }}">{{ code.2 }}<b></b></li><li class="Code_{{ code.3 }}">{{ code.3 }}<b></b></li><li class="Code_{{ code.4 }}">{{ code.4}}<b></b></li><li class="Code_{{ code.5 }}">{{ code.5 }}<b></b></li><li class="Code_{{ code.6 }}">{{ code.6 }}<b></b></li><li class="Code_{{ code.7 }}">{{ code.7 }}<b></b></li>
						</ul>
					</div>
					<div class="Announced_FrameGet">
						<dl>
							<dt><a rel="nofollow" href="/users/info/{{ userId }}" target="_blank" title="{{ nickname }}"><img width="60" height="60" src="{{ avatar }}"></a></dt>
							<dd class="gray02">
								<p>恭喜<a href="/users/info/{{ userId }}" target="_blank" class="blue" title="{{ nickname }}">{{ nickname }}</a>获得</p>
								<p>揭晓时间：{{ showed }}</p>
								<p>云购时间：{{ ordered }}</p>
							</dd>
						</dl>
					</div>
					<div class="Announced_FrameBut">
						<a href="javascript:void(0);" class="Announced_But divShowResult">本期详细计算结果</a>
						<a href="javascript:void(0);" class="Announced_But">看看有谁参与了</a>
						<a href="javascript:void(0);" class="Announced_But">看看有谁晒单</a>
					</div>
					<div class="Announced_FrameBm"></div>
				</div>
                {{/ showResult }}
                {{^ showResult }}
                {{^ showFull }}
                <div class="Progress_side">
                    <p title="已完成{{ percent }}%"><span style="width:{{ width }}px; display:;"></span></p>
                    <ul class="Pro_sid_li">
                        <li class="P_bar01"><em>{{ join }}</em>已参与人次</li>
                        <li class="P_bar02"><em id="CodeQuantity">{{ person }}</em>总需人次</li>
                        <li class="P_bar03"><em id="CodeLift">{{ remain }}</em>剩余人次</li>
                    </ul>
                </div>
                {{^ showCounting }}
                {{# showLimit }}
                <div id="divAutoRTime" class="Immediate" time="{{ leftTime }}">
                    <span><a class="orange" target="_blank" href="#">限时揭晓的规则？</a></span>
                    <b>限时揭晓</b> <p>{{& showed }}</p>
                </div>
                {{/ showLimit }}
                {{/ showCounting }}
                <p class="Pro_Detsingle">
                    <a href="javascript:void(0);" class="gray02" id="btnGoToPost">本商品已有<span class="Fb blue">{{ shareTotal }}</span>个幸运者晒单<!--已有<span class="Fb blue">701</span>条晒单评论 --></a>
                 </p>
                 {{^ showCounting }}
                 {{# showFull }}
                 <!--div id="divIsEndBuy" class="End_DetailsAutoTime">啊哦！！ 被抢光啦！！</div-->
                 {{/ showFull }}
                 {{/ showCounting }}
                 {{# showCounting }}
                 <div id="divIsEndBuy" class="End_DetailsAutoTime">计算中。。。</div>
                 {{/ showCounting }}
                 {{^ showFull }}
                 <div id="divNumber" class="Pro_number">
                    <span>我要云购</span>
                    <a href="javascript:void(0);" class="num_del num_ban">-</a>
                    <input type="text" value="1" maxlength="7" class="num_dig">
                    <a href="javascript:void(0);" class="num_add">+</a> 
                    <span>人次</span>
                    <span id="chance" class="gray03">购买人次越多获得几率越大哦！</span>
                </div>
                <div id="divBuy" class="Det_button">
                    <a href="javascript:void(0);" class="Det_Shopbut" productId="{{ id }}" periodId="{{ periodId }}">立即云购</a>
                    <a href="javascript:void(0);" class="Det_Cart" productId="{{ id }}" periodId="{{ periodId }}"><i></i>加入购物车</a>
                </div>
                {{/ showFull }}
                {{/ showFull }}
                <div class="Security">
                    <ul>
                        <li><a href="javascript:void(0);" target="_blank"><i></i>100%公平公正</a></li>
                        <li><a href="javascript:void(0);" target="_blank"><s></s>100%正品保证</a></li>
                        <li><a href="javascript:void(0);" target="_blank"><b></b>全国免费配送</a></li>
                    </ul>
                    <div class="Det_Share">
                    </div>
                </div>
                <div class="Pro_Record">
                    <ul id="ulRecordTab" class="Record_tit">
                        <li class="NewestRec Record_titCur">最新云购记录</li>
                        <li class="MytRec">我的云购记录</li>
                        <li class="Explain orange">什么是积分云购？</li>
                    </ul>
                    <div id="divRecordTab">
                    <div class="Newest_Con">
                        <ul>
                            <?php //print_r($product); ?>
                            <?php foreach($product['orders'] as $order) :?>
                            <li>
                                <a rel="nofollow" href="javascript:void(0);" target="_blank">
                                <img src="<?php echo $order['user']['avatar']?>" height="20">
                                </a>
                                <a href="javascript:void(0);" class="blue"><?php echo $order['user']['nickname']?></a> <?php echo $this->times->friendlyDate($order['ordered']);?>云购了<em class="Fb gray01"><?php echo $order['count'];?></em>人次
                            </li>
                            <?php endforeach; ?>
                            </ul>
                        <p style=""><a id="btnUserBuyMore" href="javascript:void(0);" class="gray01">查看更多</a></p>

                    </div>
                    <div class="My_Record" style="display:none;">
                        <div class="My_Record" style="">
                            <div class="My_RecordReg">
                                <b class="gray01">看不到？是不是没登录或是没注册？ 登录后看看</b>
                                <a href="#" class="My_Signbut">登录</a><a href="#" class="My_Regbut">注册</a>
                            </div>
                        </div>
                    </div>
                    <div class="Newest_Con" style="display:none;">
                        <p class="MsgIntro">积分云购是指只需1元就有机会买到想要的商品。即每件商品被平分成若干"等份"出售，每份1元，当一件商品所有"等份"售出后，根据云购规则产生一名幸运者，该幸运者即可获得此商品。</p>
                        <p class="MsgIntro1">积分云购以"快乐云购，惊喜无限"为宗旨，力求打造一个100%公平公正、100%正品保障、寄娱乐与购物一体化的新型购物网站。<a href="javascript:void(0);" class="blue" target="_blank">查看详情&gt;&gt;</a></p>
                    </div>
                    </div>
                </div>
                {{/ showResult }}
                {{/ showSoldOut }}
        </div>
    </div>
    <!--商品简要结束-->
</div>
<!--商品详情选项卡 开始-->
<div class="ProductTabNav">
    <div id="divProductNav" class="DetailsT_Tit">
        <div class="DetailsT_TitP">
            <ul>
                {{^ showResult }}
                <li class="Product_DetT"><span>商品详情</span></li>
                {{/ showResult }}
                {{# showResult }}
                <li class="All_RecordT"><span>计算结果</span></li>
                {{/ showResult }}
                {{^ showSoldOut }}
                <li class="All_RecordT"><span>所有参与记录</span></li>
                {{/ showSoldOut }}
                <li class="Single_ConT"><span>晒单</span></li>
            </ul>
            {{^ showResult }}
            {{^ showFull }}
            {{^ showSoldOut }}
            <p><a id="btnAdd2Cart" href="javascript:void(0)" class="white DetailsT_Cart" productId="{{ id }}" periodId="{{ periodId }}"><s></s>加入购物车</a></p>
            {{/ showSoldOut }}
            {{/ showFull }}
            {{/ showResult }}
        </div>
    </div>
</div>
<!--商品详情选项卡 结束-->
<!--商品详情 开始-->
<div class="divContentTab">
    {{^ showResult }}
    <!-- 商品详情开始 -->
    <div id="divContent" class="Product_Content" style="display: block; ">
        <div class="Product_Con">
            {{& content }}
        </div>
    </div>
    <!-- 商品详情结束 -->
    {{/ showResult }}
    {{# showResult }}
    <!-- 计算结果开始 -->
    <div id="divCalResult" class="Product_Content" style="display: block; ">
        <div class="ygRecord" style="">
            <div class="yghelp"> 1、取该商品最后购买时间前网站所有商品的最后100条购买时间记录 <br>
                2、每个时间记录按时、分、秒、毫秒依次排列取数值 <br>
                3、将这100个数值之和除以该商品总参与人次后取余数，余数加上10000001 即为"幸运云购码"。 </div>
            <ul class="Record_title">
                <li class="time">云购时间</li>
                <li class="nem">会员账号</li>
                <li class="name">商品名称</li>
                <li class="much">云购人次</li>
            </ul>
            <div class="RecordOnehundred">
                <h4>截止该商品最后购买时间【{{ ordered }}】最后100条全站购买时间记录</h4>
                <div class="FloatBox"></div>
            <?php
                $total = 0;
                foreach($product['results'] as $rs) :
                    $times = explode('.', $rs['ordered']);
                    $timeVal = date('His', $times[0]).$times[1];
                    $total += $timeVal;
            ?>
            <ul class="Record_content">
                <li class="time"><b><?php echo date('Y-m-d', $times[0]); ?></b><?php echo date('H:i:s', $times[0]); ?>.<?php echo $times[1]; ?></li>
                <li class="timeVal"><?php echo $timeVal; ?></li>
                <li class="nem"><a class="gray02" href="/users/info/<?php echo $rs['user_id'];?>" target="_blank"><?php echo $rs['nickname'];?></a></li>
                <li class="name"><a class="gray02" href="/products/view/<?php echo $rs['product_id'];?>/<?php echo $rs['period_id'];?>" target="_blank">（第<?php echo $rs['period_id'];?>期）<?php echo $rs['name'];?></a></li>
                <li class="much"><?php echo $rs['count'];?>人次</li>
            </ul>
            <?php
                endforeach;
                $totalFloat = floatval($total);
                $code = fmod($totalFloat,$product['person']);
            ?>
                <div class="ResultBox">
                    <h2>计算结果</h2>
                    <p class="num4">求和：<span class="Fb"><?php echo $total; ?></span>(上面<?php echo count($product['results']); ?>条云购记录时间取值相加之和)<br>
                        取余： <span class="Fb"><?php echo $total; ?></span>(<?php echo count($product['results']); ?>条时间记录之和)<span class="Fb"> % {{ person }}</span>(本商品总需参与人次) <span class="Fb"> = <?php echo $code; ?></span>(余数)<br>
                        结果：<span class="Fb"><?php echo $code; ?></span>(余数
                        )<span class="Fb"> + 10000001 = <em><?php echo $code+10000001;?></em></span> </p>
                    <b>最终结果：<?php echo $code+10000001;?></b> </div>
            </div>
        </div>
    </div>
    <!-- 计算结果结束 -->
    {{/ showResult }}
    {{^ showSoldOut }}
    <!-- 参与者记录开始 -->
    <div id="divBuyRecord" class="AllRecord_Content"></div>
    <!-- 参与者记录结束 -->
    {{/ showSoldOut }}
    <!-- 晒单开始 -->
    <div id="divPost" class="Single_Content"></div>
    <!-- 晒单结束 -->
</div>
<!--商品详情 结束-->
{{/ product }}