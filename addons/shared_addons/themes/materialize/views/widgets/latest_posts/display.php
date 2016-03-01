{{ if blog_widget }}
<ul class="collection">
	{{ blog_widget }}
	<li class="collection-item avatar">
		<img src="<?php echo base_url().'files/thumb/{{ picture }}/42/42/fit'; ?>" alt="" class="circle">
		<span class="title truncate"><a href="{{ url }}">{{ title }}</a></span>
		<p class="blue-grey-text lighten-5">{{ helper:date timestamp=created_on }}</p>
	</li>
	{{ /blog_widget }}
</ul>
{{ endif }}