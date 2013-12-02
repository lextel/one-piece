<?php
$this->title('会员中心 > 我的晒单');
?>
<h2>我的晒单
    <a href="/shares/share/2" class="insert_p<?php echo $h($typeId == 2 ? ' curr' : ''); ?>">未晒单</a>
    <span style="float:right">|</span>
    <a href="/shares/share/1" class="insert_p<?php echo $h($typeId == 1 ? ' curr' : ''); ?>">已晒单</a>
</h2>
<?php if($typeId == 2) { ?>
<?php echo $this->mustache->render('shares/share', compact('shares')); ?>
<?php } else { 
    foreach($shares as $share) {
    ?>
    <ul class="edit_product">
        <li>
        <a href="/shares/view/<?php echo $share['product_id']; ?>/<?php echo $share['period_id']; ?>" target="_blank">(第<?php echo $share['period_id']; ?>期)<?php echo $share['title']; ?></a>
   <span class="bottom_list">
    <?php echo $share['status'] == 1 ? '已审核' : '未审核'; ?>
   </span>
    </ul>
    <?php
        } 
     } 
     ?>
<? echo '<div class="pages">'; ?>
<?php echo $this->Paginator->paginate(); ?>
<? echo '</div>'; ?>
