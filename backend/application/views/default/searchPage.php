<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php $this->load->view('common/meta'); ?>
		<script>
			var autofill = false;
		</script>
	</head>
	<body class="inframe">
		<div class="container-fluid">
			<?php $this->load->view('msg/info'); ?>
			<div class="page-header row">
				<div class="col-lg-4">
					<h3 class="m-top-0">
						<?php echo $controllerName; ?>
						<small>综合搜索</small>
					</h3>
				</div>
				<div class='col-lg-4 pull-right text-right mobile-hide' >
					<a href="<?php echo $referer; ?>" class='btn btn-default' >返回上一页</a>
				</div>
			</div>

			<form class="form-horizontal" node="add" role="form" method="post" action="/<?php echo $className ?>/index" id="data-form">
				<input type="hidden" name="searchType" value="searchPage"/>
				<?php
				echo TpCsrf::hidden();
				if (count($searchPageKey) > 0) {
					foreach ($searchPageKey as $eachKey) {
						echo "\n\n";
						$formInputName = 'TpForm::' . $keyTypeList[$eachKey];
						if (empty($keyAddDefault) || !isset($keyAddDefault[$eachKey])) {
							$default = '';
						} else {
							$default = $keyAddDefault[$eachKey];
						}

						if (empty($keySelectData) || !isset($keySelectData[$eachKey])) {
							$selectData = '';
						} else {
							$selectData = $keySelectData[$eachKey];
						}
						if (empty($keyNeed) || !isset($keyNeed[$eachKey])) {
							$need = true;
						} else {
							$need = $keyNeed[$eachKey];
						}
						if (is_callable('TpForm', $keyTypeList[$eachKey])) {
							$labelName = $keyNameList[$eachKey];
							if ($need) {
								$labelName = "<span class='need'>*</span>" . $labelName;
							}
							echo TpForm::$keyTypeList[$eachKey]($labelName, $eachKey, $default, $selectData, $need);
						} else {
							echo "<div class=\"form-group\"><p>{$formInputName} not exist</p></div>";
						}
					}
				}
				?>
				<?php
				if (isset($GLOBALS['hropen']) && $GLOBALS['hropen']) {
					echo "</div>";
				}
				?>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10 submitGroup">
						<button type="submit" class="btn btn-info"><span class="glyphicon glyphicon-ok"></span> 搜索</button>
						<button type="reset" class="btn btn-warning"><span class="glyphicon glyphicon-remove"></span> 清除</button>
					</div>
				</div>
				<div class='mobile-only m-bottom-30'  >
					<a href="<?php echo $referer; ?>" class='btn btn-default btn-block' >返回上一页</a>
				</div>
			</form>
		</div>
	</body>
</html>
<?php $this->load->view('common/iframefooter'); ?>
<script>
	var pageController = '<?php echo $className; ?>';
	$(document).ready(function() {
		if (self != top) {
			parent.setNav('<?php echo $controllerName; ?>');
		}
		$("input[type=text]:first").focus();
	});
</script>