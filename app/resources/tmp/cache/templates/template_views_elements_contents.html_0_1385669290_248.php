<div class="nav">
	<nav>
	<?php if ($object['children']) { ?>
		<h2><?php echo $h($t('Contents', array('scope' => 'li3_docs'))); ?></h2>
		<ul class="children">
			<?php echo $this->docs->contents($object['children']); ?>
		</ul>
	<?php } ?>
	</nav>
</div>
