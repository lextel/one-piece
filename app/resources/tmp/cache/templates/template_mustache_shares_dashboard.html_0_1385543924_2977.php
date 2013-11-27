<ul class="edit_product">
{{# shares }}
        <li>
            <a href="/shares/view/{{ productId }}/{{ periodId }}" target="_blank">(第{{ .period_id }}期){{ title }} <font style="color: #ccc">({{ shareTitle }})</font></a>
            <span class="bottom_list">
                <?php if($typeId == 2) { ?>
                <a class="chkShare" productId="{{ productId }}" periodId="{{ periodId }}" href="javascript:void(0);">审核</a>
                <?php } ?>
                <a class="delShare" productId="{{ productId }}" periodId="{{ periodId }}" href="javascript:void(0);">删除</a>
            </span>
        </li>
{{/ shares }}
{{^ shares }}
    <li style="text-align: center; padding-bottom: 20px">冷冷清清，凄凄惨惨戚戚！~</li>
{{/ shares }}
</ul>
<script type="text/javascript">

    $(function() {

        // 审核
        $('.chkShare').click(function(){
            var $this = $(this);
            var productId = $this.attr('productId');
            var periodId  = $this.attr('periodId');

            $.ajax({
                url: '/shares/check',
                data: {productId: productId, periodId: periodId},
                type: 'post',
                dataType: 'json',
                success: function(data) {
                    if(data.status == 1) {
                        $this.parent().parent().remove();
                         $('.user_content').after("<p class='success'>审核成功</p>").next().delay(1000).fadeOut();
                    } else {
                        $('.user_content').after("<p class='error'>审核失败</p>").next().delay(1000).fadeOut();
                    }
                },
                error: function() {
                    $('.user_content').after("<p class='error'>请求失败</p>").next().delay(1000).fadeOut();
                }
            });
        });

        // 删除
        $('.delShare').click(function(){
            var $this = $(this);
            var productId = $this.attr('productId');
            var periodId  = $this.attr('periodId');

            $.ajax({
                url: '/shares/delete',
                data: {productId: productId, periodId: periodId},
                type: 'post',
                dataType: 'json',
                success: function(data) {
                    if(data.status == 1) {
                        $this.parent().parent().remove();
                         $('.user_content').after("<p class='success'>删除成功</p>").next().delay(1000).fadeOut();
                    } else {
                        $('.user_content').after("<p class='error'>删除失败</p>").next().delay(1000).fadeOut();
                    }
                },
                error: function() {
                    $('.user_content').after("<p class='error'>请求失败</p>").next().delay(1000).fadeOut();
                }
            });
        });
    });
</script>
