<!DOCTYPE html>
<html>
<head>
	<title>Let's Cook</title>
	
	<!--Import Google Icon Font-->
	<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<!--Import materialize.css-->
	{{ theme:css file="materialize.min.css" }}

	<!--Let browser know website is optimized for mobile-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	{{ theme:css file="style.css" }}
</head>

<body>
	<div class="navbar-fixed">
		<nav>
			<div class="nav-wrapper">
				<a href="#!" class="brand-logo">{{ settings:site_name }}</a>
				<a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
				<ul class="right hide-on-med-and-down">
					{{ navigation:links group="header" }}
				</ul>
				<ul class="side-nav" id="mobile-demo">
					{{ navigation:links group="header" }}
				</ul>
			</div>
		</nav>
	</div>
	<header>
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

	<footer class="page-footer">
		<div class="container">
			<div class="row">
				<div class="col l6 s12">
					<h5 class="white-text">Lorem ipsum dolor sit amett</h5>
					<p class="grey-text text-lighten-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
				</div>
				<div class="col l3 offset-l3 s12">
					<h5 class="white-text">Category</h5>
					<ul>
						<li><a class="grey-text text-lighten-3" href="#!">Category 1</a></li>
						<li><a class="grey-text text-lighten-3" href="#!">Category 2</a></li>
						<li><a class="grey-text text-lighten-3" href="#!">Category 3</a></li>
						<li><a class="grey-text text-lighten-3" href="#!">Category 4</a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="footer-copyright">
			<div class="container">
				&copy;2016 Copyright Text
			</div>
		</div>
	</footer>
	<!--  Scripts-->
    <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
    {{ theme:js file="materialize.min.js" }}
	<script type="text/javascript">
		$(document).ready(function() {
			$(".button-collapse").sideNav();
		});
	</script>
</body>
</html>