<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php $this->load->view('common/meta'); ?>
	</head>
	<body>
		<div class="container-fluid inframe">
			<div style="width:1000px; margin: 0px auto;">
			<pre>
			<?php
				
				var_dump($_SESSION);
			?>
			</pre>
			</div>
		</div>
	</body>
</html>
<?php $this->load->view('common/iframefooter'); ?>