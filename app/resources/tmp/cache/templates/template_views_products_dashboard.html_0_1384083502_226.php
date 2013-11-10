<?php echo $this->html->link('添加商品', '/products/add'); ?>
<?php echo $this->mustache->render('products/dashboard', compact('products')); ?>
<? echo '<div class="pager">'; ?>
<?php echo $this->Paginator->paginate(); ?>
<? echo '</div>'; ?>