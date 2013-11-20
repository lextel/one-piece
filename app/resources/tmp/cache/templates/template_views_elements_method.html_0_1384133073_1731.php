<div id="method" class="section">
	<section>
<?php if ($object['description']) { ?>
	<div class="description markdown">
		<?php echo $h($t($this->docs->cleanup($object['description']), compact('scope'))); ?>
	</div>
<?php } ?>
	</section>
</div>
<?php if ($object['text']) { ?>
<div class="section">
	<section>
		<div class="text markdown">
			<?php echo $h($t($this->docs->cleanup($object['text']), compact('scope'))); ?>
		</div>
	</section>
</div>
<?php } ?>

<?php // Method parameters ?>
<?php if (isset($object['tags']['params'])) { ?>
<div id="params" class="section">
	<section>
		<h3><?php echo $h($t('Parameters', array('scope' => 'li3_docs'))); ?></h3>
		<ul class="parameters">
			<?php foreach ((array) $object['tags']['params'] as $name => $data) { ?>
				<li>
					<span class="type"><?php echo $h($data['type']); ?></span>
					<?php echo $h($name); ?>
					<span class="parameter text markdown">
						<?php echo $h($t($this->docs->cleanup($data['text']), compact('scope'))); ?>
					</span>
				</li>
			<?php } ?>
		</ul>
	</section>
</div>
<?php } ?>

<?php // Method return value ?>
<?php if (isset($object['return'])) { ?>
<div id="return" class="section">
	<section>
		<h3><?php echo $h($t('Returns', array('scope' => 'li3_docs'))); ?></h3>
		<span class="type"><?php echo $h($object['return']['type']); ?></span>
		<span class="return markdown">
			<?php echo $h($t($this->docs->cleanup($object['return']['text']), compact('scope'))); ?>
		</span>
	</section>
</div>
<?php } ?>

<?php // Method filtering info ?>
<?php if (isset($object['tags']['filter'])) { ?>
<div id="filter" class="section">
	<section>
		<span class="flag markdown">
			<?php echo $h($t('This method can be filtered.', array('scope' => 'li3_docs'))); ?>
		</span>
	</section>
</div>
<?php } ?>
