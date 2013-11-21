<?php
$this->title('商品管理');
?>
<h2>商品列表<?=$this->html->link('添加商品', '/products/add', ['class' => 'insert_p']) ?></h2>
<?= $this->mustache->render('products/dashboard', compact('products')); ?>
<? echo '<div class="pager">'; ?>
<?= $this->Paginator->paginate();?>
<? echo '</div>'; ?>