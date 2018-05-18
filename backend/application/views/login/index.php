<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php $this->load->view('common/meta'); ?>
		<?php
		$staticUrl = TpSystem::getParam('staticurl');
		?>
		<link rel="stylesheet" href="<?php echo $staticUrl; ?>/static/css/form-element.css"/>
		<link rel="stylesheet" href="<?php echo $staticUrl; ?>/static/css/login.css"/>
	</head>
	<body>
		<div class="top-content">
			<div class="inner-bg">
				<div class="container">
					<div class="row">
						<div class="col-sm-8 col-sm-offset-2 text">
							<h1><strong><?php echo TpSystem::getParam('sitename'); ?></strong></h1>
							<div class="description">
								<p><?php echo TpSystem::getParam('sitedesc'); ?></p>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 col-sm-offset-3 form-box">
							<div class="form-top">
								<div class="form-top-left">
									<h3>用户登录</h3>
									<p>请输入您的用户名和密码</p>
								</div>
								<div class="form-top-right">
									<i class="fa fa-key"></i>
								</div>
							</div>


							<div class="form-bottom">
								<p class="error-msg"><?php echo TpFlash::getError(); ?></p>
								<form role="form" action="/login/doLogin" method="post" class="login-form" id="login-form">
									<?php echo TpCsrf::hidden(); ?>
									<div class="form-group">
										<label class="sr-only" for="form-username">用户名：</label>
										<input type="text" name="username" placeholder="请输入手机号码" class="form-username form-control" id="form-username"  value=""/>
										<p class="error-msg"></p>
									</div>
									<div class="form-group">
										<label class="sr-only" for="password">密码：</label>
										<input type="password" name="password" placeholder="请输入6-20位字符密码" class="form-password form-control" id="form-password" value="">
										<p class="error-msg"> </p>
									</div>
									<div class="checkbox">
										<label>
											<input type="checkbox" name="remember" value="1">记住密码
										</label>
									</div>

									<button type="submit" class="btn">登录</button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="backstretch" >
			<img src="/static/images/login-bg.jpg" />
		</div>
	</body>
</html>
<script>
	if(self != top){
		parent.location.href='/login';
	}
	function setBackground() {
		var w = $(window).width();
		var h = $(window).height();
		$(".backstretch,.backstretch img").width(w).height(h);
	}
	$(document).ready(function () {
		setBackground();
		$(window).resize(function () {
			setBackground();
		});
		$("#login-form").loginForm();
		
	})
</script>