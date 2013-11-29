$(function(){

    // 图片切换
    $('#mycarousel > li').hover(function() {
        var parent = $(this).parent();
        var idx = $(this).index();
        parent.children().removeClass('curr');
        parent.children().eq(idx).addClass('curr');
        $('#viewImage').attr('src', parent.children().eq(idx).find('img').attr('src'));
    });

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
        leftTime = rtime.attr('time');
        if(leftTime < 86400) {
            countTime();
        }
    }


});

// 滚动到商品内容
function scrollToContent() {
    $("html,body").animate({scrollTop: $(".DetailsT_TitP").offset().top}, 500);
}

// 倒计时
function countTime() {

    var hour = showZeroFilled(Math.floor(leftTime/3600));
    var second = leftTime%3600;
    var minute = showZeroFilled(Math.floor(second/60));
    second = showZeroFilled(second%60);
    $('#divAutoRTime > p').html('剩余时间：<em>'+hour+'</em>时<em>'+minute+'</em>分<em>'+second+'</em>秒');

    leftTime--;
    
    setTimeout("countTime()", 1000);
}

// 不足两位补零
function showZeroFilled(inValue) {
    if (inValue > 9) {                             
        return "" + inValue;
    }

    return "0" + inValue;
}


