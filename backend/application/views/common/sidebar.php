<div class="sidebar" id="sidebar">

	<?php
	if (count($navData) > 0) {
		foreach ($navData as $parent) {
			$num=1;
			?>
			<ul class="nav nav-sidebar">
				<li >
					<?php
					if (!empty($parent['url'])) {
						
						?>
						<a href="/<?php echo $parent['url']; ?>" target="iframe" ><?php
						if(!empty($parent['iconClass'])){
							echo "<i class=\"{$parent['iconClass']}\"></i>";
						}else{
							echo "<i class=\"fa fa-area-chart\"></i>";
						}
						?><?php echo $parent['name']; ?> </a>
						<?php
					} else {
						
						?>
						<a href="#" ><?php
						if(!empty($parent['iconClass'])){
							echo "<i class=\"{$parent['iconClass']}\"></i>";
						}else{
							echo "<i class=\"fa fa-area-chart\"></i>";
						}
						?><?php echo $parent['name']; ?> <span node="caret" class="glyphicon glyphicon-chevron-down font-size-12" ></span></a>
							<?php
						}
						?>

				</li>
				<?php
				if (count($parent['son']) > 0) {
					foreach ($parent['son'] as $son) {
						if ($son['url'] == '') {
							continue;
						}
						$num++;
						?>
						<li class="son"><a href="/<?php echo $son['url']; ?>" target="iframe"><?php echo $son['name']; ?></a></li>
						<?php
					}
				}
				?>
				<li class="son rect" style="height:<?php echo $num*50;?>px;" ></li>
			</ul>
			<?php
		}
	}
	?>


</div>