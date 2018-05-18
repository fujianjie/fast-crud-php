<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php $this->load->view('common/meta'); ?>
	</head>
	<body class="inframe">
		<div class="container inframe">
			<div class="page-header row">
				<div class="col-lg-4">
					<h3 class="m-top-0">ORM 管理工具</h3>
				</div>
			</div>

			<form class="form-horizontal" method="post" action="/orm/create" id="ormcreate">
				<input type="hidden" name="createTable" value="true" id="createTable"/>
				<?php echo TpCsrf::hidden(); ?>
				<textarea style="display:none;" name="content" id="content"></textarea>
				<div class="row container">
					<div class="step1 form-group">
						<h3>第一步：数据表</h3>
						<label class="col-sm-3 control-label">
							新数据表：
						</label>
						<div class="col-sm-3">
							<input type="text" class=" form-text form-control" name="tableName" id="tableName"/>
							<p class="warning">如果使用已有数据表，此处请留空</p>
						</div>
						<label class="col-sm-3 control-label">
							注释：
						</label>
						<div class="col-sm-3">
							<input type="text" class=" form-text form-control" name="tableComment" id="tableComment"/>
							<p class="warning"></p>
						</div>
						<div class="clearfix"></div>
						<label class="col-sm-3 control-label">
							已有数据表：
						</label>
						<div class="col-sm-6">
							<select class="form-control" name="selectTableName"id="selectTableName">
								<option value="">无</option>
								<?php
								foreach ($table as $each) {
									if ($each['name'] == 'we_sessions') {
										continue;
									}
									echo "<option value=\"{$each['name']}\">{$each['comment']} - {$each['name']}</option>";
								}
								?>
							</select>

						</div>
						<div class="col-sm-3">
							<button type="button" id="confirmStep1" class="btn btn-info">选定</button>
						</div>
					</div>
					<div class="step2 form-group">
						<h3>第二步：数据类型 <button type="button" id="addLine" class="btn btn-info" ><span class="glyphicon glyphicon-plus"></span></button></h3>
						<div class="baseLine" id="baseLine">
							<div class="col-sm-2">
								<input type="text"  class=" form-text form-control" name="colName[]" node="colName" placeholder="列名" />
							</div>
							<div class="col-sm-2">
								<input type="text"  class=" form-text form-control" name="colComment[]" node="colComment" placeholder="注释" />
							</div>
							<div class="col-sm-2">
								<select class="form-control" name="dataType[]" node="dataType">
									<?php
									foreach ($dataType as $k => $v) {
										if(isset($dataTypeName[$k])){
											$kname = $dataTypeName[$k];
										}else{
											$kname = $k;
										}
										if($k == 'middleText'){
                                            echo "<option value=\"{$k}\" selected>{$kname}</option>";
                                        }else{
                                            echo "<option value=\"{$k}\">{$kname}</option>";
                                        }

									}
									?>
								</select>
							</div>
							<div class="col-sm-5">
								<label class="checkbox-inline">
									<input type="checkbox" name="addKey[]" checked="checked" node="checkbox" value="">添加
								</label>
								<label class="checkbox-inline">
									<input type="checkbox" name="detailKey[]"  checked="checked"  node="checkbox"  value="">详细
								</label>
								<label class="checkbox-inline">
									<input type="checkbox" name="editKey[]"   checked="checked" node="checkbox"  value=""> 编辑
								</label>
								<label class="checkbox-inline">
									<input type="checkbox" name="searchKey[]"  node="checkbox"  value="">搜索
								</label>
								
								<label class="checkbox-inline">
									<input type="checkbox" name="listKey[]"   node="checkbox"  value="" > 列表
								</label>
								<label class="checkbox-inline">
									<input type="checkbox" name="keyImportant[]"  node="checkbox"  value=""> 手机
								</label>
							</div>
							<div class="col-sm-1">
								<button type="button" node="removeLine" class="btn btn-danger" ><span class="glyphicon glyphicon-remove"></span></button>
							</div>
							<div class="clearfix"></div>
							<div class="col-sm-2">
								<label class="checkbox-inline">验证器：</label>
							</div>
							<div class="col-sm-10">
								<?php
									foreach($verifyType as $k=>$v){
										?>
								
								<label class="checkbox-inline">
									<input type="checkbox" name="keyVerify[]" value="<?php echo $k;?>"><?php echo $v;?>
								</label>
										<?php
									}
								?>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="main" id="main">

						</div>
					</div>
					<div class="step2 form-group">
						<h3>第三步：控制器以及模型配置</h3>
						<div>
							<label class="col-sm-2 control-label">
								控制器名称：
							</label>
							<div class="col-sm-2">
								<input type="text" name="className" id="className" class="form-text form-control" />
							</div>
							<label class="col-sm-2 control-label">
								控制器说明：
							</label>
							<div class="col-sm-4">
								<input type="text" name="controllerComment" class="form-text form-control" />
							</div>
							
							<div class="clearfix"></div>
							<p></p>
							<div class="clearfix"></div>
							<label class="col-sm-2 control-label">
								模型名称：
							</label>
							<div class="col-sm-2">
								<input type="text" name="modelName" id="modelName" class="form-text form-control" />
							</div>
							<label class="col-sm-2 control-label">
								模型说明：
							</label>
							<div class="col-sm-4">
								<input type="text" name="modelComment" class="form-text form-control" />
							</div>
							<div class="clearfix"></div>
						</div>
					</div>
					<div class="step2 form-group">
						<h3>第四步：检查与提交</h3>
						<div id="testContent"></div>
						<div class="text-center">
							<button type="button" class="btn btn-info btn-lg" id="test">内容检查</button>
							<button type="submit" class="btn btn-info btn-lg" id="submit">内容提交</button>
						</div>
					</div>
				</div>
			</form>

		</div>
	</body>
</html>
<?php $this->load->view('common/iframefooter'); ?>
<style>
	.baseLine{display:none;}
	.line { display: block; border-bottom: 1px solid #ccc; padding-top:10px;padding-bottom: 10px;}
	.col-xs-1, .col-sm-1, .col-md-1, .col-lg-1, .col-xs-2, .col-sm-2, .col-md-2, .col-lg-2, .col-xs-3, .col-sm-3, .col-md-3, .col-lg-3, .col-xs-4, .col-sm-4, .col-md-4, .col-lg-4, .col-xs-5, .col-sm-5, .col-md-5, .col-lg-5, .col-xs-6, .col-sm-6, .col-md-6, .col-lg-6, .col-xs-7, .col-sm-7, .col-md-7, .col-lg-7, .col-xs-8, .col-sm-8, .col-md-8, .col-lg-8, .col-xs-9, .col-sm-9, .col-md-9, .col-lg-9, .col-xs-10, .col-sm-10, .col-md-10, .col-lg-10, .col-xs-11, .col-sm-11, .col-md-11, .col-lg-11, .col-xs-12, .col-sm-12, .col-md-12, .col-lg-12{padding-left:5px; padding-right:5px;}
	#submit{display:none;}
</style>
<script>
	var hasConfirmTable = false;
	$(document).ready(function () {
		function resetHeight() {
			var parentIframe = parent.$('#iframe');
			parentIframe.height($('body').height());
		}
		if (parent) {
			resetHeight();
			$(window).resize(function () {
				resetHeight();
			});
			parent.$('body,html').animate({ scrollTop: 0 }, 'fast');
		}
		$("#confirmStep1").bind('click', function () {
			var val = $("input[name=tableName]").val();
			var type = 'create';
			if (val == '') {
				val = $("select[name=selectTableName]").val();
				type = 'load';
			}
			if (val == '') {
				alert('至少创建或者指定一张数据表');
				return;
			}
			$("#confirmStep1").hide();
			$(this).prop('disable', 'disable');
			$("input[name=tableName]").prop('disabled', 'disabled');
			$("select[name=selectTableName]").prop('disabled', 'disabled');
			
			hasConfirmTable =true;
			if (type == 'load') {
				$.ajax({
					type: 'get',
					url: '/orm/getCol',
					data: {tablename: val},
					dataType: 'json',
					success: function (msg) {
						$("#createTable").val('false');
						for(var i in msg ){
							var each = msg[i];
							if(each['Key'] == 'PRI'){
								continue;
							}
							addLine();
							var line = $("#main .line:last");
							line.find('input[name*=colName]').val(each.Field).prop('disabled','disabled');
							line.find('input[name*=colComment]').val(each.Comment)
							line.find('[node=checkbox]').attr('value',each.Field);
							line.find('button[node=removeLine]').hide();
						}
						$("#addLine").hide();
					}
				})
			}

		});
		function addLine() {
			if(hasConfirmTable===false){
				alert('你必须选定数据表');
				return;
			}
			var html = "<div class=\"line\" >" + $("#baseLine").html() + '</div>';
			$("#main").append(html);
			var line =$("#main .line:last");
			line.find('[node=removeLine]').bind('click', function (e) {
				e.preventDefault();
				$(this).parents('.line').remove();
			});
			line.find('input[name*=colName]').bind('keyup',function(){
				line.find('[node=checkbox]').attr('value',$(this).val());
			});
			resetHeight() ;
		}
		$("#addLine").bind('click', function (event) {
			event.preventDefault();
			addLine();
		});
		
		$("#test").unbind('click').bind('click',function(){
			var tableName = $("#tableName").val();
			if(tableName==''){
				tableName = $("#selectTableName").val();
			}
			if(tableName==''){
				alert('请设定数据库表名');
				return;
			}
			var className = $("#className").val();
			if(className==''){
				alert('请设定控制器名称');
				return;
			}
			var modelName = $("#modelName").val();
			if(modelName == ''){
				alert('请设定模型的名称');
				return;
			}
			var inputArray = {};
			var inputVerify = true;
			$('input[name*=addKey]').each(function(){
				if(inputArray[$(this).attr('value')] == undefined){
					inputArray[$(this).attr('value')]  = 1;
				}else{
					alert('字段:'+$(this).attr('value')+'有重复');
					inputVerify =false;
				}
			});
			if(inputVerify===false){
				return;
			}
			
			var data = {};
			data['createTable'] = $("#createTable").val();
			data['tableName'] = tableName;
			data['csrf_test_name'] =  $('input[name=csrf_test_name]').val();
			data['className'] = className;
			data['modelName'] = modelName;
			$.ajax({
				type:'post',
				url:'/orm/checkInfo',
				data:data,
				dataType:'json',
				success:function(msg){
					$('input[name=csrf_test_name]').val(msg.hash);
					$("#testContent").html(msg.msg);
					if(msg.status){
						$("#submit").show();
					}
				}
			})
		});
		
		function resetHash(){
			$.ajax({
				type:'get',
				url:'/orm/getHash',
				success:function(msg){
					$('input[name=csrf_test_name]').val(msg);
				}
			})
		}
		$("#className").change(function(){
			if($('#modelName').val()==''){
				$('#modelName').val($("#className").val()+'Data');
			}
		});
		$("#ormcreate").submit(function(){
			if(!confirm('你真的要提交这个模块了吗？')){
				return false;
			}
			$('input,select').each(function(){
				$(this).prop('disabled',null);
			});
			var linedata = [];
			var totalData = {};
			$(".line").each(function(){
				var tmp = {};
				tmp['colName'] =  $(this).find('input[node=colName]').val();
				tmp['colComment'] =  $(this).find('input[node=colComment]').val();
				tmp['dataType'] = $(this).find('select[node=dataType]').val();
				var verify = [];
				
				var _this = $(this);
				_this.find('input[name*=keyVerify]').each(function(){
					if($(this).prop('checked')){
						var val =  $(this).attr('value');
						verify.push(val);
					}
				});
				tmp['verify'] = verify;
				_this.find('input[type=checkbox]').each(function(){
					if(!$(this).prop('checked')){
						return;
					}
					if(totalData[$(this).attr('name')]  ===undefined){
						totalData[$(this).attr('name')] = [];
					}
					totalData[$(this).attr('name')].push($(this).val());
				});
				linedata.push(tmp);
			});
			var content = {line:linedata,total:totalData};
			$("#content").val(JSON.stringify(content));
			
		});
	});
</script>