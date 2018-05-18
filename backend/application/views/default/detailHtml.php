
	<form class="form-horizontal" role="form">
		<?php
		if (count($detailKey) > 0) {
			foreach ($detailKey as $k) {
				if($keyTypeList[$k] =='shopFloor'){
							echo  TpForm::shopFloorValue( $data[$k], $keySelectData[$k]);
							continue;
						}
						if($keyTypeList[$k] =='hr'||$keyTypeList[$k] =='hrFirst'){
							$fname = $keyTypeList[$k] . 'Value';
							echo  TpForm::$fname( $keyNameList[$k], $keySelectData[$k]);
							continue;
						}
				?>
				<div class="form-group">
					<label  class="col-sm-5 text-right"><?php echo $keyNameList[$k]; ?></label>
					<div class="col-sm-7">
						<?php
						if (in_array($keyTypeList[$k], $needChangeType)) {
							$fname = $keyTypeList[$k] . 'Value';
							echo "<div class=' text-left'>" . TpForm::$fname($data[$k], $keySelectData[$k]) . "</div>";
						} else {
							echo "<div class=' text-left'>{$data[$k]}</div>";
						}
						?>
					</div>
				</div>
				<?php
			}
		}
		?>

	</form>

<style>
	.detailHtml{width: 45%;float:left; border-left: 1px solid #ccc;}
	#data-form{width:50%; float:left;}
	.hrBlock{margin-left:5px; margin-right:5px; padding-left: 5px; padding-right: 5px;}
</style>
<script>
$(document).ready(function(){
	$("#data-form").find('.col-sm-9').each(function(){
		$(this).find('div.col-sm-8').removeClass('col-sm-8').addClass('col-sm-12');
	});
	$(".hrBlock").find('label.col-sm-5').removeClass('col-sm-5').addClass('col-sm-3')
	$(".hrBlock").find('div.form-group').find('div.col-sm-7').removeClass('col-sm-7').addClass('col-sm-9');
});</script>