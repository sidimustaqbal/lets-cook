<div class="card-panel recent-post widget <?php echo $widget->slug ?>">
	<?php if ($widget->options['show_title']): ?>
		<h4 class="post-title"><span><?php echo $widget->instance_title; ?></span></h4>
	<?php endif; ?>

	<?php echo $widget->body; ?>
</div>