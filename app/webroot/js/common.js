$(function(){
    var productLeft = $('#CodeLift').html();
    productLeft = parseInt(productLeft);

    // 数量选中
    $('.num_dig').hover(function(){
        $(this).select();
    });

    // 添加数量
    $('.num_add').click(function(){
        var val = $(this).prev().val();

        // 列表补丁
        if($('#CodeLift').length == 0) {
            productLeft = parseInt($(this).attr('remain'));
            var obj = $(this).parent().prev();
            var newVal = showChance(parseInt(val) + 1, productLeft, obj);
        } else {
            var newVal = showChance(parseInt(val) + 1, productLeft);
        }


        if(newVal != false) {
            $(this).prev().val(newVal);
        } else {
            $(this).prev().val(val);
        }
        
        if(val == productLeft-1) {
            $(this).addClass('num_ban');
        }

        var hasBan = $(this).prev().prev().hasClass('num_ban');
        if(hasBan) {
            $(this).prev().prev().removeClass('num_ban');
        }
    });

    // 减少数量
    $('.num_del').click(function(){
        var val = $(this).next().val();

        // 列表补丁
        if($('#CodeLift').length == 0) {
            productLeft = parseInt($(this).attr('remain'));
            var obj = $(this).parent().prev();
            var newVal = showChance(parseInt(val) - 1, productLeft, obj);
        } else {
            var newVal = showChance(parseInt(val) - 1, productLeft);
        }
        

        if(newVal != false) {
            $(this).next().val(newVal);
        } else {
            $(this).next().val(val);
        }

        if(val == 2) {
            $(this).addClass('num_ban');
        }

        var hasBan = $(this).next().next().hasClass('num_ban');
        if(hasBan) {
            $(this).next().next().removeClass('num_ban');
        }
    });

    // 直接输入数量
    $('.num_dig').keyup(function(){
        var val = $(this).val();

        var reNum = /^\d*$/;
        if(!reNum.test(val)) {
            val = 1;
        }

        // 列表补丁
        if($('#CodeLift').length == 0) {
            productLeft = parseInt($(this).next().attr('remain'));
            var obj = $(this).parent().prev();
            showChance(val, productLeft, obj);
        } else {
            showChance(val, productLeft);
        }

        if(val >= productLeft) {
            $(this).val(productLeft);
            $(this).next().addClass('num_ban');
        }

        if(val <= 1) {
            $(this).val(1);
            $(this).prev().addClass('num_ban');
        }

        if(val > 1) {
            var hasBan = $(this).prev().hasClass('num_ban');
            if(hasBan) {
                $(this).prev().removeClass('num_ban');
            }
        }

        if(val < productLeft) {
            var hasBan = $(this).next().hasClass('num_ban');
            if(hasBan) {
                $(this).next().removeClass('num_ban');
            }
        }

    });


    // 立即1元购
    $('.go_Shopping').click(function() {
        alert(1);
    });

    // 列表加入购物车
    $('.go_cart').click(function(){
        $('#sCartlist').show(0, function() {
            $(this).delay(2000).hide(0);
        });
    });

    $('#sCart').hover(function() {
        $('#sCartlist').show();
    }, function() {
        $('#sCartlist').hide();
    });

});

// 显示购买几率
function showChance(val, total, obj) {
    if(val < 1) {
        var html = '<font color="ff6600">最少需云购1人次</font>';
        if($('#chance').length == 0) {
            obj.html(html).show();
            obj.fadeOut(2000);
        } else {
            $('#chance').html(html);
        }
        return false;
    }

    if(val > total) {
        var html = '<font color="ff6600">本期最多可云购'+total+'人次</font>';
        if($('#chance').length == 0) {
            var html = '<font color="ff6600">最多能云购'+total+'人次</font>';
            obj.html(html).show();
            obj.fadeOut(2000);
        } else {
            $('#chance').html(html);
        }

        return false;
    }


    var person = $('#CodeQuantity').html();
    var chance = val/person*100;

    $('#chance').html('<font color="red">获得机率 <b>'+chance.toFixed(2)+'%</b></font>');

    return val;
}