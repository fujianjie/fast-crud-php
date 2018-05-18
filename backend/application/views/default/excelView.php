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
						<small>数据导入检查 数据行<?php echo $sheetLine;?>  有效行<?php echo $formatLine;?></small>
					</h3>
				</div>

				<div class='col-lg-4 pull-right text-right mobile-hide' >
					<a href="/<?php echo $className.'/excel'; ?>" class='btn btn-default' >返回上一页</a>
				</div>
			</div>
			<div>
				待处理数据
				<pre>
					<?php var_dump($checkAllData);?>
				</pre>
			</div>
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<?php foreach($format as $k=>$v){
							echo "<th>{$keyNameList[$v]}</th>";
						 }?>
					</tr>
					
				</thead>
				<tbody>
					<?php
						if(count($data)>0){
							foreach($data as $eachLine){
								echo "<tr>";
								foreach($format as $v){
									if(isset($eachLine[$v])){
										echo "<td>$eachLine[$v]</td>";
									}else{
										echo "<td></td>";
									}
								}
								echo "</tr>";
							}
						}
					?>
				</tbody>
			</table>
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
<style>
	td{max-width: 150px !important; }

</style>