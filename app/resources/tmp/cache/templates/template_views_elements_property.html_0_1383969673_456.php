<?php if ($object['description']) { ?>
	<div class="section">
		<section>
			<div class="description markdown">
			<?php echo $h($t($this->docs->cleanup($object['description']), compact('scope'))); ?>
			</div>
		</section>
	</div>
<?php } ?>
<?php if ($object['text']) { ?>
	<div class="section">
		<section>
			<p class="text markdown">
				<?php echo $h($t($this->docs->cleanup($object['text']), compact('scope'))); ?>
			</p>
		</section>
	</div>
<?php } ?>
