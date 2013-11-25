<?php
$this->title('会员中心 > 晒单管理');
?>
<h2>晒单管理</h2>
<?php echo $this->mustache->render('shares/dashboard', compact('shares')); ?>
<? echo '<div class="pager">'; ?>
<?php echo $this->Paginator->paginate(); ?>
<? echo '</div>'; ?>