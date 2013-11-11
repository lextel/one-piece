<div class="user_content">
    <div class="user_nav">
        <div class="user_pic">
            <a href="#"><img src="http://img3.douban.com/icon/u49925310-4.jpg" alt="weelion"></a>
        </div>
        <div class="user_info">
            <h1>luky
                <div class="signature">
                    <span>最爱网购</span>
                    <span><a href="#">(编辑)</a></span>
                </div>
              </h1>
             <ul>
                <li><a href="#">我的主页</a></li>
                <li><a href="#">广播</a></li>
                <li><a href="#">相册</a></li>
                <li><a href="#">日记</a></li>
                <li><a href="#">喜欢</a></li>
                <li><a href="#">豆列</a></li>
                <li><a href="/products/dashboard">商品管理</a></li>
             </ul>
        </div>
    </div>
  </div>
  <h2>商品列表<?=$this->html->link('添加商品', '/products/add', ['class' => 'insert_p']) ?></h2>
<?= $this->mustache->render('products/dashboard', compact('products')); ?>
<? echo '<div class="pager">'; ?>
<?= $this->Paginator->paginate();?>
<? echo '</div>'; ?>