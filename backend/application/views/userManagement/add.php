<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php $this->load->view('common/meta'); ?>
	</head>
	<body>
		<div class="container-fluid">
			<?php $this->load->view('msg/info'); ?>
			<h2>创建用户</h2>

			<p class="error-msg"></p>
			<form class="form-horizontal" role="form" method="post" action="/UserManagement/doAdd" id="createUser-form">
				<?php echo TpCsrf::hidden(); ?>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="form-mobile">手机号码：</label>
					<div class="col-sm-10">
						<div class="col-sm-2">
							<input type="text" name="mobile" placeholder="请输入手机号码" class="form-username form-control"  value=""/>
						</div>
						<p class=" col-sm-12 error-msg"></p>
					</div>

				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="form-newpassword">新密码：</label>
					<div class="col-sm-10">
						<div class="col-sm-2">
							<input type="password" name="newpassword" placeholder="请输入6-20位字符密码" class="form-password form-control" id="form-newpassword" value=""/>
						</div>
						<p class=" col-sm-12 error-msg"></p>
					</div>

				</div>

				<div class="form-group">
					<label class="col-sm-2 control-label" for="form-password">再次输入：</label>
					<div class="col-sm-10">
						<div class="col-sm-2">
							<input type="password" name="password" placeholder="请输入6-20位字符密码" class="form-password form-control" id="form-password" value="">
							<p class="col-sm-12 error-msg"> </p>
						</div>

					</div>
				</div>

				<?php
					echo TpForm::select('用户组', 'group', '', $groupArray);
					echo TpForm::select('所属公司', 'companyId', '', $companyArray);
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
<script>
	$(document).ready(function () {
		
	});
</script>