<?php
$this->title('会员中心 > 晒单管理');
?>
<h2>晒单管理
    <a href="/shares/dashboard/2" class="insert_p<?php echo $h($typeId == 2 ? ' curr' : ''); ?>">未审核</a>
    <span style="float:right">|</span>
    <a href="/shares/dashboard/1" class="insert_p<?php echo $h($typeId == 1 ? ' curr' : ''); ?>">已审核</a>
</h2>

<ul class="edit_product">
<?php
foreach($shares as $share) {
?>
    <li>
        <a href="/shares/view/<?php echo $share['product_id']; ?>/<?php echo $share['period_id']; ?>" target="_blank">(第<?php echo $share['period_id']; ?>期)<?php echo $share['title']; ?></a>
        <span class="bottom_list">
            <?php if($typeId == 2) { ?>
            <a class="chkShare" productId="<?php echo $share['product_id']; ?>" periodId="<?php echo $share['period_id']; ?>" href="javascript:void(0);">审核</a>
            <?php } ?>
            <a class="delShare" productId="<?php echo $share['product_id']; ?>" periodId="<?php echo $share['period_id']; ?>" href="javascript:void(0);">删除</a>
        </span>
    </li>
<?php
}
if(empty($shares)) {
?>
    <li style="text-align: center; padding-bottom: 20px">冷冷清清，凄凄惨惨戚戚！~</li>
<?php } ?>
</ul>
<? echo '<div class="pages">'; ?>
<?php echo $this->Paginator->paginate(); ?>
<? echo '</div>'; ?>
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
