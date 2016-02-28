{{ post }}
<div class="row">
		<div class="col s12">
			<img class="circle responsive-img header-img" src="img/menu.jpg">
			<div class="intro-text">
			<span class="name white-text lighten-5">Recipes</span>
			</div>
		</div>
	</div>
	</header>
	<div class="container blog">
		<div class="row">
			<div class="col s12 l8">
				<div class="col s12 widget">
					<div class="card-panel">
						<div class="post-img center">
							<img src="{{ picture:image }}" alt="" class="">
						</div>
						<span class="post-title">{{ title }}</span>
						<p class="blue-grey-text lighten-5">
							<i class="tiny material-icons">person</i> <span><a href="{{ url:site }}user/{{ created_by:user_id }}">{{ created_by:display_name }}</a></span>
							<i class="tiny material-icons">event</i> <span>{{ helper:date timestamp=created_on }}</span>
						</p>
						<div>
							{{ body }}
						</div>
					</div>
				</div>
				<div class="col s12 widget">
					<div class="card-panel">
						<div class="post_meta">
							{{ if keywords }}
								{{ theme:image file="tags.png" }}
								<span class="tags">
									{{ keywords }}
								</span>
							{{ endif }}
						</div>
						
						<?php if (Settings::get('enable_comments')): ?>	
							
							<div id="existing-comments">
								<h4><?php echo lang('comments:title') ?></h4>
								<?php echo $this->comments->display() ?>
							</div>		

							
							<?php if ($form_display): ?>
								<?php echo $this->comments->form() ?>
							<?php else: ?>
								<?php echo sprintf(lang('blog:disabled_after'), strtolower(lang('global:duration:'.str_replace(' ', '-', $post[0]['comments_enabled'])))) ?>
							<?php endif ?>
						
						<?php endif; ?>
					</div>
				</div>
			</div>
			<div class="col s12 l4">
				<div class="col s12 widget">
					<div class="card-panel recent-post">
						<span class="post-title">Recent Recipes</span>
						<ul class="collection">
							<li class="collection-item avatar">
								<img src="img/menu.jpg" alt="" class="circle">
								<span class="title truncate"><a href="post.html#">Lorem ipsum dolor sit amet</a></span>
								<p class="blue-grey-text lighten-5">Mar 26, 2016</p>
							</li>
							<li class="collection-item avatar">
								<img src="img/menu.jpg" alt="" class="circle">
								<span class="title truncate"><a href="post.html#">Lorem ipsum dolor sit amet</a></span>
								<p class="blue-grey-text lighten-5">Mar 26, 2016</p>
							</li>
							<li class="collection-item avatar">
								<img src="img/menu.jpg" alt="" class="circle">
								<span class="title truncate"><a href="post.html#">Lorem ipsum dolor sit amet</a></span>
								<p class="blue-grey-text lighten-5">Mar 26, 2016</p>
							</li>
						</ul>
						<hr />
						<span class="post-title">Categories</span>
						<ul class="collection">
							<li class="collection-item"><a href="blog.html#">Category 1</a></li>
							<li class="collection-item"><a href="blog.html#">Category 2</a></li>
							<li class="collection-item"><a href="blog.html#">Category 3</a></li>
						</ul>
					</div>
				</div>				
			</div>
		</div>
	</div>

{{ /post }}
