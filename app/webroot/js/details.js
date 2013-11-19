$(function(){

    // 期数展开收起功能
    var p = $("#btnOpenPeriod");
    var E = false;
    if (p.length > 0) {
        p.click(function() {
            if (E) {
                E = false;
                $(this).parent().parent().css("height", "99px");
                $(this).html("展开<i></i>");
                // if ($(window).scrollTop() > $("div.Current_nav").offset().top + 25) {
                //     $("body,html").animate({scrollTop: 0},0);
                // }
            } else {
                E = true;
                $(this).parent().parent().css("height", "");
                $(this).html("收起<s></s>")
            }
            return false
        })
    }

    // 处理期数在隐藏范围展开
    if($('ul.Period_list').length > 3) {
        var showList = true;
        E = true;
        for (var i = 0; i < 3; i++) {
            $('ul.Period_list').eq(i).find('li').each(function(){
                // console.log($(this).find('b.period_ArrowCur').length);
                if(showList == true && $(this).find('b.period_ArrowCur').length != 0) {
                    showList = false;
                    E = false;
                }
            });
        };

        if(showList) {
            $(p).parent().parent().css("height", "");
            $(p).html('收起<s></s>');
        } else {
            $(p).parent().parent().css("height", "99px");
        }
    } else {
        p.parent().hide();
    }

    // 右侧选项卡切换
    $("#ulRecordTab").tabs("#divRecordTab > div");
    // 内容选项卡切换
    $(".DetailsT_TitP > ul").tabs(".divContentTab > div");

    // 中奖展示内容互动切换选项卡
    $(".Announced_But").click(function() {
        var index = $(this).index()
        var api = $(".DetailsT_TitP > ul").data("tabs");
        api.click(index);
        scrollToContent();
    });

    // 限时倒计时
    var rtime = $('#divAutoRTime');
    if(rtime.length > 0) {
        console.log('I am in!');
        leftTime = rtime.attr('time');
        if(leftTime < 86400) {
            console.log('some time');
            var t = setTimeout("countTime()", 1000);
        }
    }
});

// 滚动到商品内容
function scrollToContent() {
    $("html,body").animate({scrollTop: $(".DetailsT_TitP").offset().top}, 500);
}

// 倒计时
function countTime() {
    // leftTime

            // $leftTime = $period['showed'] - time();
            // $hour = floor($leftTime/3600);
            // $second = $leftTime%3600;
            // $minute = floor($second/60);
            // $second = $second%60;

}

// 时间戳
function unixtime(){
    var dt = new Date()();
    var ux = Date().UTC(dt.getFullYear(),dt.getMonth(),dt.getDay(),dt.getHours(),dt.getMinutes(),dt.getSeconds())/1000;

    return ux;
}

