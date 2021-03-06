<?php

if (!isset($object) || !$object) {
	return;
}

?>
<div class="aside crumbs">
	<aside>
		<h3>docs for</h3>
		<ul>
				<!-- <li class="home">
					<?php echo $this->html->link($t('\\', array('scope' => 'li3_docs')), array(
						'controller' => 'li3_docs.ApiBrowser', 'action' => 'index'
					), array('escape' => false)); ?>
				</li> -->
			<?php foreach ($this->docs->crumbs($object) as $crumb): ?>
				<li class="<?php echo $h($crumb['class']); ?>">
					<?php
						if ($crumb['url']) {
							echo $this->html->link($crumb['title'], $crumb['url']);
							continue;
						}
					?>
					<span><?php echo $h($crumb['title']); ?></span>
				</li>
			<?php endforeach; ?>
		</ul>
	</aside>
</div>