<?php
$this->title('商品管理');
?>
<h2>商品列表<?php echo $this->html->link('添加商品', '/products/add', ['class' => 'insert_p']); ?></h2>
<?php echo $this->mustache->render('products/dashboard', compact('products')); ?>
<? echo '<div class="pager">'; ?>
<?php echo $this->Paginator->paginate(); ?>
<? echo '</div>'; ?>