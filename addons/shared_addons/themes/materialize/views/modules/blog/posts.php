	<div class="row">
		<div class="col s12">
			{{ theme:image file='menu.jpg' class="circle responsive-img header-img"}}
			<div class="intro-text">
			<span class="name white-text lighten-5">Recipes</span>
			</div>
		</div>
	</div>
	</header>
	<div class="container blog">
		<div class="row">
			<div class="col s12 l8">
				{{ if posts }}
					{{ posts }}
					
						<div class="card post-list">
							<div class="row">
								<div class="card-image col s12 l4">
									<img src="{{ picture:image }}">
								</div>
								<div class="card-content col s12 l8">
									<span class="post-title"><a href="{{ url }}">{{ title }}</a></span>
									<p class="blue-grey-text lighten-5">
										<i class="tiny material-icons">person</i> <span><a href="{{ url:site }}user/{{ created_by:user_id }}">{{ created_by:display_name }}</a></span>
										<i class="tiny material-icons">event</i> <span>{{ helper:date timestamp=created_on }}</span>
									</p>
									<p>{{ intro }}</p>
									<p class="blue-grey-text lighten-5 right">
									<a class="waves-effect waves-light" href="{{ url }}"><i class="material-icons right">navigate_next</i>Read More</a>
									</p>
								</div>
							</div>
						</div>

					{{ /posts }}

					<div class="row">
						<div class="col s12">	
							{{ pagination }}
						</div>
					</div>

				{{ else }}
					
					{{ helper:lang line="blog:currently_no_posts" }}

				{{ endif }}				
				
			</div>
			<div class="col s12 l4">
				<div class="col s12 widget">
					{{ widgets:area slug="sidebar"}}
				</div>				
			</div>
		</div>
	</div>
