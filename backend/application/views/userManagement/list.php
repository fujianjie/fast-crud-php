<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php $this->load->view('common/meta'); ?>
	</head>
	<body>
		<div class="container-fluid">
			<?php $this->load->view('msg/info'); ?>
			<h2>用户管理</h2>
			<p class="error-msg"></p>
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th>ID</th>
						<th>手机号码</th>
						<th>邮箱</th>
						<th>公司</th>
						<th>操作</th>
					</tr>
				</thead>
				<tbody>
					<?php
						if(count($list)>0){
							foreach($list as $each){
								?>
					<tr>
						<td><?php echo $each['id'];?></td>
						<td><?php echo $each['mobile'];?></td>
						<td><?php echo $each['email'];?></td>
						<td><?php echo $company[$each['companyId']];?></td>
						<td>
							<a href="" class="btn btn-default"><span class="glyphicon glyphicon-search"></span>&nbsp;查看</a>
							<a href=""  class="btn btn-info"><span class="glyphicon glyphicon-pencil"></span>&nbsp;编辑</a>
							<a href=""  class="btn btn-warning"><span class="glyphicon glyphicon-trash"></span>&nbsp;停用</a>
							<a href=""  class="btn btn-danger"><span class="glyphicon glyphicon-th"></span>&nbsp;重置密码</a>
						</td>
					</tr>
								<?php
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

</script>