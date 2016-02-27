<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title><?php echo $this->settings->site_name; ?> - <?php echo lang('login_title');?></title>

		<meta name="description" content="User login page" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />

		<!-- -----------------
		STYLES
		------------------ -->
		
		<?php Asset::css('bootstrap.min.css'); ?>
		<?php Asset::css('font-awesome.min.css'); ?>
		<?php Asset::css('ace-fonts.css'); ?>
		<?php Asset::css('ace.css'); ?>
		<?php Asset::css('ace-rtl.min.css'); ?>
		<?php echo Asset::render_css('global') ?>
		
		<!--[if IE 7]>
		<?php Asset::css('font-awesome-ie7.min.css', false, 'ie7_styles'); ?>
		<?php echo Asset::render_css('ie7_styles') ?>
		<![endif]-->

		<!--[if lte IE 8]>
		<?php Asset::css('ace-ie.min.css', false, 'ie8_styles'); ?>
		<?php echo Asset::render_css('ie8_styles') ?>
		<![endif]-->

		<!-- -----------------
		SCRIPTS 
		------------------ -->
		
		<!--[if !IE]> -->
		<?php Asset::js('jquery-2.0.3.js', false, 'notie_scripts'); ?>
		<?php Asset::js('hello.min.js', false, 'notie_scripts'); ?>

		<?php echo Asset::render_js('notie_scripts') ?>
		<!-- <![endif]-->

		<!--[if IE]>
		<?php Asset::js('jquery-1.10.2.js', false, 'ie_scripts'); ?>
		<?php echo Asset::render_js('ie_scripts') ?>
		<![endif]-->

		<!--[if lt IE 9]>
		<?php Asset::js('html5shiv.js', false, 'ie9_scripts'); ?>
		<?php Asset::js('respond.min.js', false, 'ie9_scripts'); ?>
		<?php echo Asset::render_js('ie9_scripts') ?>
		<![endif]-->
		<style type="text/css">
			.loader {
				position: fixed;
				left: 0px;
				top: 0px;
				width: 100%;
				height: 100%;
				z-index: 9999;
				background: url('<?php echo Asset::get_filepath_img('loader.gif'); ?>') 50% 50% no-repeat rgb(249,249,249);
				background-size: 100px 100px;
				opacity: 0.6;
				display: none;
			}
		</style>
	</head>

	<body class="login-layout">
		<div class="loader"></div>
		<div class="main-container">
			<div class="main-content">
				<div class="row">
					<div class="col-sm-10 col-sm-offset-1">
						<div class="login-container">
							<div class="center">
								<?php 
								echo Asset::img('logo_login.png', $this->settings->site_name, array(
									'style' => 'margin-top: 20px; margin-bottom: -10px;', 
									'width' => 100)) 
								?>
								<h1>
									<span class="white"><?php echo $this->settings->site_name; ?></span>
								</h1>
								<h4 class="blue"><?php echo $this->settings->site_slogan; ?></h4>
							</div>

							<div class="space-6"></div>

							<div class="position-relative">
								<div id="login-box" class="login-box visible widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
											<!-- Messege for login -->
											<?php echo $this->session->flashdata('notice'); ?>
											<?php if ( ! empty($error_string)): ?>
												<!-- Woops... -->
												<div class="alert alert-danger">
													<?php echo $error_string;?>
												</div>
											<?php endif; ?>

											<!-- Messege for activate email -->
											<?php if ($this->template->activated_email!='') : ?>
											<div class="alert alert-success">
										        <?php echo $this->template->activated_email; ?>
											</div>
											<?php endif; ?>

											<!-- Messege for forget password -->
											<?php echo $this->session->flashdata('reset_password'); ?>

											<h4 class="header blue lighter bigger" id="login-header">
												<i class="icon-lock green"></i>
												<?php echo lang('login_title'); ?>
											</h4>

											<div class="space-6"></div>

											<?php echo form_open('login'); ?>
												<fieldset>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input name="email" type="text" class="form-control" placeholder="<?php echo lang('global:username_or_email'); ?>" />
															<i class="icon-user"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input name="password" type="password" class="form-control" placeholder="<?php echo lang('global:password'); ?>" />
															<i class="icon-lock"></i>
														</span>
													</label>

													<div class="space"></div>

													<div class="clearfix">
														<label class="inline">
															<input type="checkbox" class="ace" name="remember" id="remember-check" checked />
															<span class="lbl"> <?php echo lang('user:remember'); ?></span>
														</label>

														<button name="submit" type="submit" class="width-35 pull-right btn btn-sm btn-primary">
															<i class="icon-key"></i>
															<?php echo lang('login_label'); ?>
														</button>
													</div>

													<div class="space-4"></div>
												</fieldset>
											<?php echo form_close(); ?>

											<div class="social-or-login center">
												<span class="bigger-110"><?php echo lang('or_login_using_label'); ?></span>
											</div>

											<div class="social-login center">
												<a class="btn btn-primary login_social" onclick="login_social('facebook')" >
													<i class="icon-facebook"></i>
												</a>

												<a class="btn btn-info login_social" onclick="login_social('twitter')">
													<i class="icon-twitter"></i>
												</a>

												<a class="btn btn-danger login_social" onclick="login_social('google')">
													<i class="icon-google-plus"></i>
												</a>
											</div>
										</div><!-- /widget-main -->

										<div class="toolbar clearfix">
											<div>
												<a href="#" onclick="show_box('forgot-box'); return false;" class="forgot-password-link">
													<i class="icon-arrow-left"></i>
													<?php echo lang('forgot_password_label'); ?>
												</a>
											</div>

											<div>
												<a href="#" onclick="show_box('signup-box'); return false;" class="user-signup-link">
													<?php echo lang('register_label'); ?>
													<i class="icon-arrow-right"></i>
												</a>
											</div>
										</div>
									</div><!-- /widget-body -->
								</div><!-- /login-box -->

								<div id="forgot-box" class="forgot-box widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
											<?php if ( ! empty($success_string)):?>
												<!-- Woops... -->
												<div class="alert alert-success animated fadeIn">
													<?php echo $success_string;?>
												</div>
											<?php endif; ?>

											<?php if ( ! empty($error_string)):?>
												<!-- Woops... -->
												<div class="alert alert-danger">
													<?php echo $error_string;?>
												</div>
											<?php endif; ?>
											<h4 class="header red lighter bigger">
												<i class="icon-key"></i>
												<?php echo lang('forgot_password_title'); ?>
											</h4>

											<div class="space-6"></div>
											<p>
												<?php echo lang('forgot_password_header'); ?>
											</p>

											<?php echo form_open('users/reset_pass', array('id'=>'reset-pass')); ?>
												<fieldset>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="email" class="form-control" name="email" placeholder="<?php echo lang('global:email'); ?>" />
															<i class="icon-envelope"></i>
														</span>
													</label>

													<div class="clearfix">
														<button type="submit" class="width-35 pull-right btn btn-sm btn-danger">
															<i class="icon-lightbulb"></i>
															<?php echo lang('forgot_password_send'); ?>
														</button>
													</div>
												</fieldset>
											<?php echo form_close() ?><br/><br/>
										</div><!-- /widget-main -->

										<div class="toolbar center">
											<a href="#" onclick="show_box('login-box'); return false;" class="back-to-login-link">
												<?php echo lang('login_back'); ?>
												<i class="icon-arrow-right"></i>
											</a>
										</div>
									</div><!-- /widget-body -->
								</div><!-- /forgot-box -->

								<div id="signup-box" class="signup-box widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
											<?php 
												if ( ! empty($error_string)):?>
												<!-- Woops... -->
												<div class="alert alert-danger">
													<?php echo $error_string;?>
												</div>
											<?php endif; ?>
											<h4 class="header green lighter bigger">
												<i class="icon-group blue"></i>
												<?php echo lang('register_title'); ?>
											</h4>

											<div class="space-6"></div>
											<p> <?php echo lang('register_header'); ?> </p>

											<?php echo form_open('users/register', array('id' => 'register')); ?>
												<fieldset>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="email" name="email" id="r_email" class="form-control" placeholder="<?php echo lang('global:email'); ?>" value="<?php echo set_value('email'); ?>" />
															<i class="icon-envelope"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="text" name="username" id="r_username" class="form-control" placeholder="<?php echo lang('global:username'); ?>" value="<?php echo set_value('username'); ?>" />
															<?php echo form_input('d0ntf1llth1s1n', ' ', 'class="default-form" style="display:none"') ?>
															<i class="icon-user"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="password" name="password" class="form-control" placeholder="<?php echo lang('global:password'); ?>" />
															<i class="icon-lock"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="password" class="form-control" name="re-password"placeholder="<?php echo lang('global:re-password'); ?>" />
															<i class="icon-retweet"></i>
														</span>
													</label>

													<label class="block" id="l_agreement">
														<input type="checkbox" class="ace" />
														<span class="lbl">
															<?php echo lang('user_agreement_label'); ?>
															<a href="#"><?php echo lang('user_agreement'); ?></a>
														</span>
													</label>

													<div class="space-24"></div>

													<div class="clearfix">
														<button type="reset" class="width-30 pull-left btn btn-sm">
															<i class="icon-refresh"></i>
															Reset
														</button>

														<button type="submit" class="width-65 pull-right btn btn-sm btn-success">
															<?php echo lang('register_label'); ?>
															<i class="icon-arrow-right icon-on-right"></i>
														</button>
													</div>
												</fieldset>
											<?php echo form_close(); ?>
										</div>

										<div class="toolbar center">
											<?php
											if(isset($_SERVER['HTTP_REFERER']) && stripos($_SERVER['HTTP_REFERER'], 'admin')>0) {
												echo anchor(base_url().'admin/login','<i class="icon-arrow-left"></i>'.lang('login_back'), 'class="back-to-login-link"');
											} else {
											?>
											<a href="#" onclick="show_box('login-box'); return false;" class="back-to-login-link">
												<i class="icon-arrow-left"></i>
												<?php echo lang('login_back'); ?>
											</a>
											<?php } ?>
										</div>
									</div><!-- /widget-body -->
								</div><!-- /signup-box -->
							</div><!-- /position-relative -->
						</div>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div>
		</div><!-- /.main-container -->

		<script type="text/javascript">
			if("ontouchend" in document) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>

		<!-- inline scripts related to this page -->

		<script type="text/javascript">
			$(document).ready(function() {
				if(window.location.hash=='#register' || window.location.href.indexOf('register')>0) {
					$('.forgot-box .widget-body .widget-main .alert').remove();
					$('.login-box .widget-body .widget-main .alert').remove();
					show_box('signup-box');
				} else if (window.location.href.indexOf('reset_pass')>0) {
					$('.signup-box .widget-body .widget-main .alert').remove();
					$('.login-box .widget-body .widget-main .alert').remove();
					show_box('forgot-box');
				} else if (window.location.href.indexOf('login')>0 || window.location.href.indexOf('activate')>0) {
					$('.signup-box .widget-body .widget-main .alert').remove();
					$('.forgot-box .widget-body .widget-main .alert').remove();
					show_box('login-box');
				}
			});

			function show_box(id) {
			 jQuery('.widget-box.visible').removeClass('visible');
			 jQuery('#'+id).addClass('visible');
			}
		</script>
		<script>
			function login_social(provider) {
				hello(provider).login({scope:'email'}).then( function(){
					//alert("You are signed in to Facebook");
				}, function( e ){
					alert("Signin error: " + e.error.message );
				});
			}
			
			$(document).ready(function() {
				$('.login_social').click(function() {
					hello.on('auth.login',function(auth){
						// call user information, for the given network
						hello(auth.network).api('/me').then(function(r) {
							//inject it into the container
							var uname = r.name;
							var uid = r.id;

							if(auth.network == 'facebook' || auth.network== 'google') {
								var uemail = r.email;
								var username = r.first_name.toLowerCase()+r.last_name.toLowerCase();
							} else if(auth.network == 'twitter') {
								var uemail = r.screen_name.toLowerCase();
								var username = r.screen_name.toLowerCase();
							}

							$('.loader').show();

							$.ajax({
								type:'POST',
								data:'uid='+uid+'&uemail='+uemail+'&username='+username,
								dataType:'JSON',
								url:'<?php echo base_url(); ?>users/cek_'+auth.network+'_account',
								success:function(msg) {
									if(msg.status) {
										window.location = '<?php echo base_url(); ?>';
									} else {
										$('.loader').fadeOut();
										$('#login-header').before('<span class="alert alert-danger">'+msg.message+'</span>');
									}
								},
								error:function(e) {
									console.log(e);
								}
							});
						});
					});
				});
			});

			//fb : 10202690620887987
			hello.init({
				facebook : '1524581137788191',
				twitter : 'EjgYduCyEwKjkMISlItD5kHuh',
				google : '1055449686140-s1rbilpsg940vinprhl77tb3tvbnvrt8.apps.googleusercontent.com'
			});
		</script>
	</body>
	
	<?php echo Asset::render() ?>
</html>
