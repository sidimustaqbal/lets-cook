<?php dump($posts); ?>
{{ if posts }}
<ul class="collection">
	{{ posts }}
	<li class="collection-item avatar">
		<img src="{{ picture:image }}" alt="" class="circle">
		<span class="title truncate"><a href="{{ url }}">{{ title }}</a></span>
		<p class="blue-grey-text lighten-5">{{ helper:date timestamp=created_on }}</p>
	</li>
	{{ /posts }}
</ul>
{{ endif }}