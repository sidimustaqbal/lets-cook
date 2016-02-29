<?php if (is_array($categories)): ?>
<ul class="collection">
	<?php foreach ($categories as $category): ?>
	<li class="collection-item"><?php echo anchor("blog/category/{$category->slug}", $category->title) ?></li>
	<?php endforeach ?>
</ul>
<?php endif ?>
