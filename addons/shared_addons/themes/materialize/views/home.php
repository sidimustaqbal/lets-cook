	{{ theme:partial name="header" }}
	
	<div class="row">
		<div class="col s12">
			{{ theme:image file="lets-cook2.jpg" class="circle responsive-img header-img" }}
			<div class="intro-text">
			<span class="name white-text lighten-5">Let's Cook</span>
			</div>
		</div>
	</div>
	</header>
	<div class="container">
		<div class="row recipes-list">
			{{ if posts }}
					{{ posts }}
					<div class="col s12 l4">
				<div style="overflow: hidden;" class="card">
					<div class="card-image waves-effect waves-block waves-light">
					<img class="activator" src="{{ picture:image }}">
					</div>
					<div class="card-content">
						<span class="card-title activator grey-text text-darken-4">{{ title }}<i class="material-icons right">more_vert</i></span>
					</div>
					<div style="display: none; transform: translateY(0px);" class="card-reveal">
						<span class="card-title grey-text text-darken-4"><a href="{{ url }}">{{ title }}</a><i class="material-icons right">close</i></span>
						<p>{{ intro }}</p>
						<a class="waves-effect waves-light" href="{{ url }}"><i class="material-icons right">navigate_next</i>Read More</a>
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
	</div>

	{{ theme:partial name="footer" }}