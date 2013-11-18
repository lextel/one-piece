{{# product }}
<div class="show_content">
    <!--商品期数开始-->
    <div id="divPeriodList" class="show_Period">
        <ul class="Period_list">
            {{# product.periodIds }}
                {{# class }}
                    {{# active }}
                    <li><a href="/products/view/{{ product.id }}/{{ id }}"><b class="{{ class }}">第{{ id }}期</b><i></i></a></li>
                    {{/ active}}
                    {{^ active }}
                    <li><b class="{{ class }}">第{{ id }}期</b></li>
                    {{/ active}}
                {{/ class}}
                {{^ class }}
                    <li><a href="/products/view/{{ product.id }}/{{ id }}" class="gray02">第{{ id }}期</a></li>
                {{/ class }}
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
				<div class="Pro_pic"><a href="/products/{{ product.id }}/{{ id }}" title="{{ product.title }}"><img width="398" height="398" alt="{{ product.title }}" src="{{ images.0 }}"></a><span>限时揭晓</span></div>
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
                        <p><a href="/products/{{ product.id }}/{{ id }}" target="_blank" class="Result_LConductBut">查看详情</a></p>
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
                        <img id="" style="width: 396px; height: 396px; position: absolute; top: 0px; left: 0px; " src="{{ images.0 }}">
                    </span>
                </div>
                <div class="smallPicList">
                    <div class="hidden" style="display: none; "></div>
                    <div class="jcarousel-clip">
                        <ul id="mycarousel" style="width: 378px; left: 0px; display: block; ">
                            {{# images }}
                            <li class="curr"><img width="48" height="48" src="{{ . }}" alt="" name=""></li>
                            {{/ images }}
                            <div class="hackbox"></div>
                        </ul>
                    </div>
                    <div class="hidden" style="display: none; "></div>
                </div>
            </div>
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
            {{/ showActive }}
        </div>
        <div class="Pro_Detright">
                <p class="Det_money">价值：<span class="rmbgray">{{ price }}</span></p>
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
							<dt><a rel="nofollow" href="http://u.1yyg.com/1000093029" target="_blank" title="他妈的在不中不玩啦"><img width="60" height="60" src="http://faceimg.1yyg.com/UserFace/20130524205654556.jpg"></a></dt>
							<dd class="gray02">
								<p>恭喜<a href="http://u.1yyg.com/1000093029" target="_blank" class="blue" title="他妈的在不中不玩啦">{{ userId }}</a>获得</p>
								<p>揭晓时间：{{ showed }}</p>
								<p>云购时间：{{ ordered }}</p>
							</dd>
						</dl>
					</div>
					<div class="Announced_FrameBut">
						<a href="javascript:void(0);" onclick="javascript:if(TabFun!=null){TabFun.showTabFun(1);}" class="Announced_But">本期详细计算结果</a>
						<a href="javascript:void(0);" onclick="javascript:if(TabFun!=null){TabFun.showTabFun(2);}" class="Announced_But">看看有谁参与了</a>
						<a href="javascript:void(0);" onclick="javascript:if(TabFun!=null){TabFun.showTabFun(3);}" class="Announced_But">看看有谁晒单</a>
					</div>
					<div class="Announced_FrameBm"></div>
				</div>
                {{/ showResult }}
                {{^ showResult }}
                <div class="Progress_side">
                    <p title="已完成{{ percent }}%"><span style="width:{{ width }}px; display:;"></span></p>
                    <ul class="Pro_sid_li">
                        <li class="P_bar01"><em>{{ join }}</em>已参与人次</li>
                        <li class="P_bar02"><em id="CodeQuantity">{{ person }}</em>总需人次</li>
                        <li class="P_bar03"><em id="CodeLift">{{ remain }}</em>剩余人次</li>
                    </ul>
                </div>
                <p class="Pro_Detsingle">
                    <a href="javascript:void(0);" class="gray02" id="btnGoToPost">本商品已有<span class="Fb blue">{{ shareTotal }}</span>个幸运者晒单<!--已有<span class="Fb blue">701</span>条晒单评论</a> -->
                 </p>
                 <div id="divNumber" class="Pro_number">
                    我要云购 <a href="javascript:void();" class="num_del num_ban">-</a>
                    <input type="text" value="1" maxlength="7" class="num_dig">
                    <a href="javascript:void();" class="num_add">+</a> 人次
                     <span id="chance" class="gray03"><font color="red">获得机率 <b>0.02%</b></font></span>
                </div>
                <div id="divBuy" class="Det_button">
                    <a href="javascript:void();" class="Det_Shopbut">立即1元云购</a><a href="javascript:void();" class="Det_Cart"><i></i>加入购物车</a>
                </div>
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
                        <li class="Explain orange">什么是1元云购？</li>
                    </ul>
                    <div class="Newest_Con">
                        <ul>
                            <li>
                                <a rel="nofollow" href="javascript:void(0);" target="_blank">
                                <img src="javascript:void(0);" height="20">
                                </a>
                                <a href="javascript:void(0);" class="blue">15110****00</a>
                                (陕西省西安市) 1分钟前 云购了<em class="Fb gray01">1</em>人次
                            </li>
                            <li>
                                <a rel="nofollow" href="javascript:void(0);" target="_blank">
                                <img src="javascript:void(0);" height="20">
                                </a>
                                <a href="javascript:void(0);" class="blue">5s5s5s哇</a>
                                (北京市) 1分钟前 云购了<em class="Fb gray01">1</em>人次
                            </li>
                            <li>
                                <a rel="nofollow" href="javascript:void(0);" target="_blank">
                                <img src="javascript:void(0);" height="20">
                                </a>
                                <a href="javascript:void(0);" class="blue">
                                火箭123</a>(江西省南昌市) 1分钟前 云购了<em class="Fb gray01">1</em>人次
                             </li>
                            <li>
                                <a rel="nofollow" href="javascript:void(0);" target="_blank">
                                    <img src="javascript:void(0);" height="20">
                                </a>
                                <a href="javascript:void(0);" class="blue">红米米35ss4来个</a>
                                (福建省三明市) 1分钟前 云购了<em class="Fb gray01">1</em>人次
                             </li>
                            <li>
                                <a rel="nofollow" href="javascript:void(0);" target="_blank">
                                    <img src="javascript:void(0);" height="20">
                                </a>
                                <a href="javascript:void(0);" class="blue">
                                18050****82</a>(福建省) 3分钟前 云购了<em class="Fb gray01">1</em>人次
                            </li>
                            <li>
                                <a rel="nofollow" href="javascript:void(0);" target="_blank">
                                    <img src="javascript:void(0);" height="20">
                                </a>
                                <a href="javascript:void(0);" class="blue">我不玩了</a>
                                (广东省广州市) 4分钟前 云购了<em class="Fb gray01">2</em>人次
                            </li>
                            </ul>
                        <p style=""><a id="btnUserBuyMore" href="javascript:void();" class="gray01">查看更多</a></p>

                    </div>
                    <div class="My_Record" style="display:none;">
                        <div class="My_RecordReg">
                            <b class="gray01">看不到？是不是没登录或是没注册？ 登录后看看</b>
                            <a href="javascript:void(0);" class="My_Regbut">注册</a>
                        </div>
                    </div>
                    <div class="Newest_Con" style="display:none;">
                        <p class="MsgIntro">1元云购是指只需1元就有机会买到想要的商品。即每件商品被平分成若干"等份"出售，每份1元，当一件商品所有"等份"售出后，根据云购规则产生一名幸运者，该幸运者即可获得此商品。</p>
                        <p class="MsgIntro1">1元云购以"快乐云购，惊喜无限"为宗旨，力求打造一个100%公平公正、100%正品保障、寄娱乐与购物一体化的新型购物网站。<a href="javascript:void(0);" target="_blank">查看详情&gt;&gt;</a></p>
                    </div>
                </div>
                {{/ showResult }}
        </div>
    </div>
    <!--商品简要结束-->
</div>
<!--商品详情选项卡 开始-->
<div class="ProductTabNav">
    <div id="divProductNav" class="DetailsT_Tit">
        <div class="DetailsT_TitP">
            <ul>
                <li class="Product_DetT DetailsTCur"><span class="DetailsTCur">商品详情</span></li>
                <li id="liUserBuyAll" class="All_RecordT"><span class="">所有参与记录</span></li>
                <li class="Single_ConT"><span class="">晒单</span></li>
            </ul>
            <p><a id="btnAdd2Cart" href="javascript:void(0)" class="white DetailsT_Cart"><s></s>加入购物车</a></p>
        </div>
    </div>
</div>
<!--商品详情选项卡 结束-->
<!--商品详情 开始-->
<div id="divContent" class="Product_Content" style="display: block; ">
    <div class="Product_Con">
        {{& content }}
    </div>
</div>
<!--商品详情 结束-->
{{/ product }}
