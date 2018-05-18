<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<nav class="navbar navbar-default  navbar-fixed-top" id="topnav" role="navigation">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			

			<button id="sidebar-toggle" type="button" class=" sidebar-toggle mobile-hide btn btn-default"><span class="glyphicon glyphicon-th-list"></span></button>

			<a class="navbar-brand" href="/"><?php echo TpSystem::getParam('sitename'); ?></a>
		</div>

		<div id="navbar" class="navbar-collapse collapse">
			
			<ul class="nav navbar-nav navbar-right">
				<li><a href='/site/dashboard' target="iframe">您好，<?php echo TpSystem::getSession('realname');?></a></li>
                                                                        <li><a href="/site/index">管理系统</a></li>
				<li><a href="/site/setting">个人设定</a></li>
				<li><a href="/login/logout">退出</a></li>
			</ul>
			
			<?php
	if (count($navData) > 0) {
		foreach ($navData as $parent) {
			?>
			<ul class="nav navbar-nav navbar-right mobile-only">
				<li >
					<?php
					if (!empty($parent['url'])) {
						?>
						<a href="/<?php echo $parent['url']; ?>" target="iframe" ><?php echo $parent['name']; ?> </a>
						<?php
					} else {
						?>
						<a href="#" ><?php echo $parent['name']; ?> <span class="caret"></span></a>
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
						?>
						<li class="son"><a href="/<?php echo $son['url']; ?>" target="iframe"><?php echo $son['name']; ?></a></li>
						<?php
					}
				}
				?>

			</ul>
			<?php
		}
	}
	?>
			
			<form class="navbar-form navbar-right form-inline" style="display:none;">
				<input type="text" class="form-control" placeholder="搜索">
				<button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>
			</form>
		</div>
	</div>
</nav>