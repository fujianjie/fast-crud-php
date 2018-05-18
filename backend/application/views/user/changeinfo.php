<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php $this->load->view('common/meta'); ?>
	</head>
	<body style="background: #fff;">
		<div class="container-fluid">
			<?php $this->load->view('msg/info'); ?>
			<h2>修改个人信息</h2>

			<p class="error-msg"><?php echo validation_errors(); ?></p>
			<form class="form-horizontal" role="form" method="post" action="/UserSetting/doChangeInfo">
				<?php 
					echo TpCsrf::hidden(); 
					echo TpForm::shortText('EMAIL邮箱','email', $email);
					echo TpForm::shortText('姓名','realname', $realname);
				?>

				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<button type="submit" class="btn btn-info">提交</button>
					</div>
				</div>
			</form>
		</div>
	</body>
</html>
<?php $this->load->view('common/iframefooter'); ?>