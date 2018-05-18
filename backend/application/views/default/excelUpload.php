<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php $this->load->view('common/meta'); ?>
	</head>
	<body class="inframe">
		<div class="container-fluid">
			<?php $this->load->view('msg/info'); ?>
			<div class="page-header row">
				<div class="col-lg-4">
					<h3 class="m-top-0">
						<?php echo $controllerName; ?>
						<small>数据导入</small>
					</h3>
				</div>
				<div class='col-lg-4 pull-right text-right mobile-hide' >
					<a href="<?php echo $referer; ?>" class='btn btn-default' >返回上一页</a>
				</div>
			</div>

			<form class="form-horizontal" role="form" method="post" action="/<?php echo $className ?>/parseExcel" id="data-form">
				<?php echo TpCsrf::hidden(); ?>
				<?php
				echo TpForm::file('数据导入', 'excel','',"",0);
				echo TpForm::radio('是否插入数据库', 'tosql', 0, array(0=>'否',1=>'是'));
				?>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10 submitGroup">
						<button type="submit" class="btn btn-info"><span class="glyphicon glyphicon-ok"></span> 提交</button>
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
	$(document).ready(function(){
		 if (self!=top) {
			  parent.setNav('<?php echo $controllerName; ?>');
		  }
	});
</script>