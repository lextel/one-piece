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

        var newVal = showChance(parseInt(val) + 1, productLeft);

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
        
        var newVal = showChance(parseInt(val) - 1, productLeft);

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

        showChance(val, productLeft);
    });

});

// 显示购买几率
function showChance(val, total) {
    if(val < 1) {
        $('#chance').html('<font color="ff6600">最少需云购1人次</font>');
        return false;
    }

    if(val > total) {
        $('#chance').html('<font color="ff6600">本期最多可云购'+total+'人次</font>');
        return false;
    }


    var person = $('#CodeQuantity').html();
    var chance = val/person*100;

    $('#chance').html('<font color="red">获得机率 <b>'+chance.toFixed(2)+'%</b></font>');

    return val;
}