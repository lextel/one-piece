<?php
$this->styles($this->resLoader->css('product_list.css'));
$this->title($product['title']);
?>
<div class="Current_nav"><a href="/">首页</a> &gt; 所有分类</div>
<?= $this->mustache->render('products/view', compact('product')); ?>
