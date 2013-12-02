<?php
$this->title('商品管理');
$this->scripts($this->resLoader->script('jquery-ui.js'));
$this->styles($this->resLoader->css('product_list.css'));
$this->styles($this->resLoader->css('jquery-ui.css'));
?>
<h2>商品列表<?=$this->html->link('添加商品', '/products/add', ['class' => 'insert_p']) ?></h2>
<?= $this->mustache->render('products/dashboard', compact('products')); ?>
<div class="pages">
<?= $this->Paginator->paginate();?>
</div>