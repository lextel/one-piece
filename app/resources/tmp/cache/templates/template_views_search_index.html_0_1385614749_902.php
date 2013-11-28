<?php
$this->title('商品搜索');
$this->styles($this->resLoader->css('product_list.css'));
?>
<div class="Current_nav"><a href="/">首页</a> &gt; <?php echo $h($crumbs); ?></div>
<div id="current" class="list_Curtit">
    <h1 class="fl"><?php echo $h($crumbs); ?> - "<?php echo $h($title); ?>"</h1>
    <span id="spTotalCount">(共<em class="orange"><?php echo $h($total); ?></em>件相关商品)</span>
</div>

<div class="list_Sort">
    <dl>
        <dt>排序</dt>
        <dd>
            <?php
                foreach($sortList as $list) {
                    echo $list;
                }
            ?>
        </dd>
    </dl>
</div>
<!--列表开始-->
<div class="listContent">
   <?php echo $this->mustache->render('search/index', compact('products')); ?>
</div>
<!--列表结束-->
<!--分页开始-->
<div id="divPageNav" class="pages" style="">
    <?php echo $this->Paginator->paginate(); ?>
</div>
<!--分页结束-->