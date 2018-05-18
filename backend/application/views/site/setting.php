<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php $this->load->view('common/meta'); ?>
		<?php
		$staticUrl = TpSystem::getParam('staticurl');
		?>
		<link rel="stylesheet" href="<?php echo $staticUrl; ?>/static/css/dashboard.css"/>
	</head>
	<body>
		<?php $this->load->view('common/topnav'); ?>
		<div class="container-fluid">
			<div class="row">
				<?php $this->load->view('common/settingbar'); ?>
				<iframe class="main" id="iframe" width="100%" height="100%" name="iframe" frameborder="0" scrolling="no"   src="/UserSetting/changePass"></iframe>
			</div>
		</div>
	</body>
</html>
<script>
$(document).ready(function(){
	setNavInit();
	$("body").resetPageWH();
	$(window).resize(function(){
		$("body").resetPageWH();
	});
});
</script>