<?=$this->html->link('添加商品', '/products/add') ?>
<?= $this->mustache->render('products/dashboard', compact('products')); ?>
<? echo '<div class="pager">'; ?>
<?= $this->Paginator->paginate();?>
<? echo '</div>'; ?>