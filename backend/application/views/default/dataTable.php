<?php defined('BASEPATH') OR exit('No direct script access allowed');
	$skipType = array('extraInput','hrFirst','html','hr');
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php $this->load->view('common/meta'); ?>
	</head>
	<body>
		<div class="container">
			<div class="page-header row">
				<div class="col-lg-4">
					<h3><?php echo $controllerName; ?></h3>
					<h5 class="m-top-0"> 表名： <?php echo $tableName; ?></h5>
				</div>
			</div>

			<hr/>
			<h4 id="#<?php echo $className.'_index';?>"><?php echo $controllerName; ?>列表</h4>
			<pre>请求地址：/<?php echo $className;?>/index</pre>
			<p>请求参数说明</p>
			<table class="table table-hover">
				<thead>
					<tr>
						<th width="150">参数</th>
						<th width="150">字段类型</th>
						<th>说明</th>
						<th>是否必须</th>
						<th>选项内容</th>
					</tr>
				</thead>
				<tbody >
					<tr>
						<td>per_page</td>
						<td>int</td>
						<td>分页offset</td>
						<td>否</td>
						<td></td>
					</tr>
					<?php
						foreach($searchKey as $key){
							?>
							<tr>
								<td><?php echo $key;?></td>
								<td><?php echo isset($keySqlType[$key]) ? $keySqlType[$key]: ''  ?></td>
								<td><?php echo $keyNameList[$key];?></td>
								<td>否</td>
								<td>
									<?php
									if(isset($keySelectData[$key])){
										foreach($keySelectData[$key] as $v=>$n){
											echo "$v  =>  $n <br/>";
										}
									}
									?>
								</td>
							</tr>
							<?php
						}
					?>

				</tbody>
			</table>
			<p>返回样例</p>
			<pre><?php echo $listJson;?></pre>
			<table class="table table-hover">
				<thead>
					<tr>
						<th >参数</th>
						<th>字段类型</th>
						<th>说明</th>
					</tr>
				</thead>
				<tbody>
				<tr>
					<td >id</td>
					<td>int</td>
					<td>主键</td>
				</tr>
				<?php
				foreach($listKey as $key){
					?>
					<tr>
						<td><?php echo $key;?></td>
						<td><?php echo isset($keySqlType[$key]) ? $keySqlType[$key]: 'varchar'  ?></td>
						<td><?php echo $keyNameList[$key];?></td>

					</tr>
					<?php
				}
				?>
				</tbody>

			</table>



			<h4 id="#<?php echo $className.'_add';?>"><?php echo $controllerName; ?>添加项</h4>
			<pre>请求地址：/<?php echo $className;?>/add</pre>

			<p>请求参数说明  某些请求需要先请求次添加项来获取所需要添加的字段</p>
			<table class="table table-hover">
				<thead>
				<tr>
					<th width="150">参数</th>
					<th width="150">字段类型</th>
					<th>说明</th>
					<th>是否必须</th>
					<th>选项内容</th>
				</tr>
				</thead>
				<tbody >


				</tbody>
			</table>
			<p>返回样例</p>
			<pre><?php echo $addJson;?></pre>
			<table class="table table-hover">
				<thead>
				<tr>
					<th width="150">参数</th>
					<th>字段类型</th>
					<th>说明</th>
				</tr>
				</thead>
				<tbody>
				<tr>
					<td>key</td>
					<td>varchar</td>
					<td>需要提交的键名</td>
				</tr>
				<tr>
					<td>type</td>
					<td>varchar</td>
					<td>数据类型</td>
				</tr>
				<tr>
					<td>name</td>
					<td>varchar</td>
					<td>说明</td>
				</tr>
				<tr>
					<td>value</td>
					<td>varchar</td>
					<td>默认值</td>
				</tr>
				</tbody>

			</table>



			<h4 id="#<?php echo $className.'_addSave';?>"><?php echo $controllerName; ?>添加保存</h4>
			<pre>请求地址：/<?php echo $className;?>/addSave</pre>
			<p>请求参数说明</p>
			<table class="table table-hover">
				<thead>
				<tr>
					<th width="150">参数</th>
					<th width="150">字段类型</th>
					<th>说明</th>
					<th>是否必须</th>
					<th>选项内容</th>
				</tr>
				</thead>
				<tbody >
				<tr>
					<td>per_page</td>
					<td>int</td>
					<td>分页offset</td>
					<td>否</td>
					<td></td>
				</tr>
				<?php
				foreach($addKey as $key){

					if( in_array($keyTypeList[$key],$skipType) ){
						continue;
					}
					?>
					<tr>
						<td><?php echo $key;?></td>
						<td><?php echo isset($keySqlType[$key]) ? $keySqlType[$key]: ''  ?></td>
						<td><?php echo $keyNameList[$key];?></td>
						<td>否</td>
						<td>
							<?php
							if(isset($keySelectData[$key]) && is_array($keySelectData[$key])){
								foreach($keySelectData[$key] as $v=>$n){
									echo "$v  =>  $n <br/>";
								}
							}
							?>
						</td>
					</tr>
					<?php
				}
				?>

				</tbody>
			</table>
			<p>返回样例</p>
			<pre><?php echo json_encode(array('status'=>'success','msg'=>'操作成功'));?></pre>
			<table class="table table-hover">
				<thead>
				<tr>
					<th width="150">参数</th>
					<th>字段类型</th>
					<th>说明</th>
				</tr>
				</thead>
				<tbody>
					<tr>
						<td>status</td>
						<td>varchar</td>
						<td>成功 success 失败 failed</td>
					</tr>
					<tr>
						<td>msg</td>
						<td>varchar</td>
						<td>提示内容</td>
					</tr>
				</tbody>

			</table>



			<h4 id="#<?php echo $className.'_editSave';?>"><?php echo $controllerName; ?>编辑保存</h4>
			<pre>请求地址：/<?php echo $className;?>/editSave</pre>
			<p>请求参数说明</p>
			<table class="table table-hover">
				<thead>
				<tr>
					<th width="150">参数</th>
					<th width="150">字段类型</th>
					<th>说明</th>
					<th>是否必须</th>
					<th>选项内容</th>
				</tr>
				</thead>
				<tbody >
				<tr>
					<td>id</td>
					<td>int</td>
					<td>主键盘</td>
					<td>是</td>
					<td></td>
				</tr>
				<?php
				foreach($editKey as $key){

					if( in_array($keyTypeList[$key],$skipType) ){
						continue;
					}
					?>
					<tr>
						<td><?php echo $key;?></td>
						<td><?php echo isset($keySqlType[$key]) ? $keySqlType[$key]: ''  ?></td>
						<td><?php echo $keyNameList[$key];?></td>
						<td>否</td>
						<td>
							<?php
							if(isset($keySelectData[$key]) && is_array($keySelectData[$key])){
								foreach($keySelectData[$key] as $v=>$n){
									echo "$v  =>  $n <br/>";
								}
							}
							?>
						</td>
					</tr>
					<?php
				}
				?>

				</tbody>
			</table>
			<p>返回样例</p>
			<pre><?php echo json_encode(array('status'=>'success','msg'=>'操作成功'));?></pre>
			<table class="table table-hover">
				<thead>
				<tr>
					<th width="150">参数</th>
					<th>字段类型</th>
					<th>说明</th>
				</tr>
				</thead>
				<tbody>
				<tr>
					<td>status</td>
					<td>varchar</td>
					<td>成功 success 失败 failed</td>
				</tr>
				<tr>
					<td>msg</td>
					<td>varchar</td>
					<td>提示内容</td>
				</tr>
				</tbody>

			</table>



			<hr/>
			<h3>模块所有字段</h3>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>键名</th>

						<th>字段说明</th>
					</tr>
				</thead>
				<tbody>
					<?php
					if (count($keyNameList) > 0) {
						foreach ($keyNameList as $k => $each) {
							?>
							<tr>
								<td><?php echo $k; ?></td>
								<td><?php echo $each; ?></td>

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