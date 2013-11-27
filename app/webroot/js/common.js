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

        var quantity  = 1;
        var productId = $(this).attr('productId');
        var periodId  = $(this).attr('periodId');

        $.ajax({
            url: '/cart/add',
            data: {productId: productId, periodId: periodId, quantity: quantity},
            type: 'post',
            dataType: 'json',
            success: function(data) {
                window.location.href = '/cart/index';
            }
        });
    });

    // 列表加入购物车
    $('.go_cart').click(function(){

        var quantity  = $(this).parent().prev().find('input').val();
        var productId = $(this).attr('productId');
        var periodId  = $(this).attr('periodId');

        $('#p1').remove();
        $('div.settlement').remove();
        $('ul.mycartcur').remove();
        $('#sCartLoading').show();
        $('#sCartlist').show();

        $.ajax({
            url: '/cart/add',
            data: {productId: productId, periodId: periodId, quantity: quantity},
            type: 'post',
            dataType: 'json',
            success: function(data) {
                showCarts(data);
            }
        });

    });

    // 删除购物车商品
    $(document).on("click", '.delGood', function(){

        var i = $(this).attr('index');
        $.ajax({
            url: '/cart/del',
            data: {index:i},
            type: 'post',
            dataType: 'json',
            success: function(data) {
                showCarts(data);
            }
        });

    });

    // 结算按钮
    $(document).on('click', '#sGotoCart, .checkout', function(){
        window.location.href = '/cart/index';
    });

    // 购物车移进出
    $('#sCart').hover(function() {
        if($('ul.mycartcur').length != 0 )
            $('#sCartlist').show();
    }, function() {
        $('#sCartlist').hide();
    });


    // 购物车页面
    var jiaFun = function(){
        $('.jia').unbind('click');
        var productId = $(this).attr('productId');
        var periodId = $(this).attr('periodId');
        var quantity = $('#txtNum' + productId).val();
        $.ajax({
            url: '/cart/modify',
            data: {productId: productId, periodId:periodId, quantity:quantity, method: 'add'},
            dataType: 'json',
            type: 'post',
            success: function(data) {
                if(data.status < 3) {
                    var msg = '';
                    switch(data.status) {
                        case 2:
                            msg = '此商品剩余人次不足';
                            break;
                        case 1:
                            msg = '本期已经结束';
                            break;
                        case 0:
                            msg = '参数有误';
                            break
                    }

                    alert(msg);
                } else {
                    quantity = data.q;
                    $('#txtNum' + productId).val(quantity);
                    $('.xj' + productId).html('￥'+quantity+'.00');
                    var total = parseInt($('#moenyCount').html());
                    total++;
                    $('#moenyCount').html(total+'.00')
                }
                $('.jia').bind('click', jiaFun);
            }
        });
    };

    $('.jia').bind('click', jiaFun);

    var jianFun = function(){
        $('.jian').unbind('click');
        var productId = $(this).attr('productId');
        var periodId = $(this).attr('periodId');
        var quantity = $('#txtNum' + productId).val();
        if(quantity == '1'){
            $(this).parent().parent().next().show().delay(1000).fadeOut();
            return false;
        }
        $.ajax({
            url: '/cart/modify',
            data: {productId: productId, periodId:periodId, quantity:quantity, method: 'del'},
            dataType: 'json',
            type: 'post',
            success: function(data) {

                if(data.status < 3) {
                    var msg = '';
                    switch(data.status) {
                        case 2:
                            msg = '此商品剩余人次不足';
                            break;  
                        case 1:
                            msg = '本期已经结束';
                            break;
                        case 0:
                            msg = '参数有误';
                            break
                    }

                    alert(msg);
                } else {
                    quantity = data.q;
                    $('#txtNum' + productId).val(quantity);
                    $('.xj' + productId).html('￥'+quantity+'.00');
                    var total = parseInt($('#moenyCount').html());
                    total--;
                    $('#moenyCount').html(total+'.00')
                }
                $('.jian').bind('click', jianFun);
            }
        });
    };

    $('.jian').bind('click', jianFun);


    // 删除产品
    $(".delgood").click(function() {
        var delBtn = $(this);
        var i = delBtn.attr('index');
        $.ajax({
            url: '/cart/del',
            data: {index:i},
            type: 'post',
            dataType: 'json',
            success: function(data) {
                delBtn.parent().parent().remove();
                if($('li.end').length == 0) {
                    $('li.top').after('<li><div id="cartNO" class="cartno"><p><span></span>购物车中暂时没有商品！<a href="/">返回继续云购&gt;&gt;</a></p></div></li>');
                }
                updateCartTotal();
            }
        });

    });

    // 全选反选
    $('#ckAll').click(function () {
        if (this.checked) {//全选
            $('input[name="ids[]"]').prop('checked', true);
        } else {
            $('input[name="ids[]"]').prop('checked', false);
        }
    });

    // 删除购物车
    var allDeleteFun = function(){

        var ids = new Array;
        $('input[name="ids[]"]:checked').each(function() {
            ids.push($(this).val());

        });

        $('#AllDelete').unbind('click');
        $.ajax({
            url: '/cart/batchDel',
            data: {ids: ids},
            type: 'post',
            dataType: 'json',
            success: function(data) {
                window.location.href = window.location.href;
            }
        });
    }

    // 删除所有商品
    $('#AllDelete').bind('click', allDeleteFun);

    // 支付页面
    $('#but_ok').click(function() {
        if($('li.end').length == 0) {
            return false;
        }
        window.location.href = '/cart/payment';
    });


});



function updateCartTotal() {
    var total = 0;
    $('input[id^="txtNum"]').each(function() {
        total += parseInt($(this).val());
    });
    $('#moenyCount').html(total+'.00')
}

// 显示购物车
function showCarts(data) {
    var cart = ''; 
    var item = 0;
    var quantity = 0;

    for(var i in data) {
        item++;
        cart += '<ul class="mycartcur">';
        cart += '<li class="img"><a href="#"><img src="'+data[i].image+'"></a></li>';
        cart += '<li class="title"><h3><a href="#">'+data[i].title+'</a></h3><div class="rmbred"><i>1.00 </i>x <i>'+data[i].quantity+'</i><a class="delGood" index="'+item+'" href="javascript:void(0);">删除</a></div></li>';
        cart += '</ul>';
        quantity += parseInt(data[i].quantity);
    }
    cart += '<p id="p1">共计 <span id="CartTotal2">'+item+'</span> 件商品 金额总计：<span id="CartTotalM" class="rmbred">'+quantity+'.00</span></p>';
    cart += '<div class="settlement"><input type="button" id="sGotoCart" value="去购物车并结算"></div>';
    cart += '<div class="goods_loding" id="sCartLoading" style="display: none;"><img border="0" alt="" src="/img/goods_loading.gif">正在加载......</div>';
    $('#sCartTotal').html(item);
    $('#sCartLoading').hide();
    $('#sCartlist').html(cart);

    if($('ul.mycartcur').length == 0) {
        $('#sCartlist').hide();
        return false;
    }
}

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