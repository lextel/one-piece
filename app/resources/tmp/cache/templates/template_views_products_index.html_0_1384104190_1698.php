<?php
$this->styles($this->resLoader->css('product_list.css'));
?>
<div class="Current_nav"><a href="/">首页</a> &gt; 所有分类</div>
<div id="current" class="list_Curtit">
    <h1 class="fl">所有分类</h1>
    <span id="spTotalCount">(共<em class="orange"><?php echo $h($total); ?></em>件相关商品)</span>
</div>
<div class="list_class">
    <dl>
        <dt>分类</dt>
        <dd id="ddBrandList" style="height:78px;">
            <ul>
                <li><a href="/products/index" class="ClassCur">全部</a></li>
                <?php 
                    foreach($cats as $key => $cat) {
                        echo '<li><a href="/products/index/?cat_id='.$key.'" class="" title="' . $cat . '">' . $cat . '</a></li>';
                    }
                ?>
            </ul>
        </dd>
    </dl>
    <!--a class="list_classMore" href="javascript:void();">展开<i></i></a--> 
</div>
<div class="list_Sort">
    <dl>
        <dt>排序</dt>
        <dd> <a href="/products/index/?orderby=showed&sort=desc" class="SortCur">即将揭晓</a> <a href="/products/index/?orderby=hit&sort=desc" class="">人气</a> <a href="/products/index/?orderby=remain&sort=desc" class="">剩余人次</a> <a href="/products/index/?orderby=created&sort=desc" class="">最新</a> <a href="/products/index/?orderby=price&sort=desc" class="Price_Sort">价格 <i></i></a> </dd>
    </dl>
</div>
<!--列表开始-->
<div class="listContent">
   <?php echo $this->mustache->render('products/list', compact('products')); ?>
</div>
<!--列表结束-->
<!--分页开始-->
<div id="divPageNav" class="pages" style="">
    <?php echo $this->Paginator->paginate(); ?>
</div>
<!--分页结束-->