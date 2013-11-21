<?php
$this->title('会员中心 > 晒单管理');
?>
<h2>晒单管理</h2>
<?= $this->mustache->render('shares/dashboard', compact('shares')); ?>
<? echo '<div class="pager">'; ?>
<?= $this->Paginator->paginate();?>
<? echo '</div>'; ?>