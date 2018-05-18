<?php
$msg = TpFlash::getError();
if (!empty($msg)) {
	?>
	<div class="alert alert-danger" role="alert">
		<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<p><?php echo $msg; ?></p>
	</div>
	<script>var autofill = true;</script>
	<?php
} else {
	$msg = TpFlash::getSuccess();
	if (!empty($msg)) {
		?>
		<div class="alert alert-success" role="alert">
			<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			<p><?php echo $msg; ?></p>
		</div>
		<?php
	}
}
$msg = TpFlash::getContent();
        if (!empty($msg)) {
                ?>
                <div class="alert alert-info" role="alert">
                        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <p><?php echo $msg; ?></p>
                </div>
                <?php
        }
?>