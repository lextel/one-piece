<div class="user_content">
    <div class="user_nav">
        <div class="user_pic">
            <a href="#"><img src="http://img3.douban.com/icon/u49925310-4.jpg" alt="weelion"></a>
        </div>
        <div class="user_info">
            <h1>luky</h1>
             <ul>
                <li><a href="/products/dashboard">商品管理</a></li>
                <li><a href="/shares/dashboard">晒单管理</a></li>
                <li><a href="/shares/index">晒单</a></li>
             </ul>
        </div>
    </div>
  </div>
  <h2>商品列表<?php echo $this->html->link('添加商品', '/products/add', ['class' => 'insert_p']); ?></h2>
<?php echo $this->mustache->render('products/dashboard', compact('products')); ?>
<? echo '<div class="pager">'; ?>
<?php echo $this->Paginator->paginate(); ?>
<? echo '</div>'; ?>