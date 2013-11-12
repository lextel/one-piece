<?php
$this->styles($this->resLoader->css('product_list.css'));
?>
<div class="Current_nav"><a href="/">首页</a> &gt; 所有分类</div>
<div id="current" class="list_Curtit">
    <h1 class="fl">所有分类</h1>
    <span id="spTotalCount">(共<em class="orange"><?php echo $h($total); ?></em>件相关商品)</span>
</div>

<!-- 分类开始 -->
<div class="list_class">
    <dl>
        <dt>分类</dt>
        <dd id="ddBrandList">
            <ul>
                <?php
                    $class = empty($cat_id) ? 'ClassCur' : '';
                    echo '<li><a href="'.$this->url(['Products::index']).'" class="'.$class.'">全部</a></li>';
                    foreach($cats as $key => $cat) {
                        $class = '';
                        if($key == $cat_id) {
                            $class = 'ClassCur';
                        }
                        echo '<li><a href="'.$this->url(['Products::index', 'cat_id' => $key]).'" class="'.$class.'" title="' . $cat . '">' . $cat . '</a></li>';
                    }
                ?>
            </ul>
        </dd>
    </dl>
    <!--a class="list_classMore" href="javascript:void();">展开<i></i></a--> 
</div>
<!-- 分类结束 -->

<!-- 品牌开始 -->
<?php if( !empty($brands) && !empty($cat_id) ): ?>
<div class="list_class">
    <dl>
        <dt>品牌</dt>
        <dd id="ddBrandList">
            <ul>
                <?php
                    $class = empty($brand_id) ? 'ClassCur' : '';
                    echo '<li><a href="'.$this->url(['Products::index', 'cat_id' => $cat_id]).'" class="'.$class.'">全部</a></li>';
                    foreach($brands as $key => $brand) {
                        $class = ($key == $brand_id) ? 'ClassCur' : '';
                        echo '<li><a href="'.$this->url(['Products::index', 'cat_id'=> $cat_id, 'brand_id' => $key]).'" class="'.$class.'" title="' . $brand['name'] . '">' . $brand['name'] . '</a></li>';
                    }
                ?>
            </ul>
        </dd>
    </dl>
    <!--a class="list_classMore" href="javascript:void();">展开<i></i></a-->
</div>
<?php endif; ?>
<!-- 品牌结束 -->
<div class="list_Sort">
    <dl>
        <dt>排序</dt>
        <dd>
            <?php
                foreach($orderByList as $list) {
                    echo $list;
                }
            ?>
        </dd>
    </dl>
</div>
<!--列表开始-->
<div class="listContent">
   <?php echo $this->mustache->render('products/index', compact('products')); ?>
</div>
<!--列表结束-->
<!--分页开始-->
<div id="divPageNav" class="pages" style="">
    <?php echo $this->Paginator->paginate(); ?>
</div>
<!--分页结束-->