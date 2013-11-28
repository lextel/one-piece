<?php
$this->styles($this->resLoader->css('product_list.css'));
$this->scripts($this->resLoader->script('jquery.tools.min.js'));;
$this->scripts($this->resLoader->script('details.js'));;
$this->title($product['title']);
?>
<div class="Current_nav"><a href="/">首页</a> &gt; <a href="/products">所有分类</a>  &gt; 商品详情</div>
<?php
    echo $dump;
?>
<?= $this->mustache->render('products/view', compact('product')); ?>