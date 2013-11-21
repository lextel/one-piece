<?php
$this->title('会员中心 > 我的晒单');
?>
<h2>我的晒单
    <a href="/shares/share/2" class="insert_p<?= $typeId == 2 ? ' curr' : '';?>">未晒单</a>
    <span style="float:right">|</span>
    <a href="/shares/share/1" class="insert_p<?= $typeId == 1 ? ' curr' : '';?>">已晒单</a>
</h2>
<?= $this->mustache->render('shares/share', compact('shares')); ?>
<? echo '<div class="pager">'; ?>
<?= $this->Paginator->paginate();?>
<? echo '</div>'; ?>