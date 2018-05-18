<meta charset="utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<?php
	$staticUrl = TpSystem::getParam('staticurl');
?>
<link rel="stylesheet" href="<?php echo $staticUrl;?>/static/css/bootstrap.min.css"/>
<link rel="stylesheet" href="<?php echo $staticUrl;?>/static/css/bootstrap-theme.min.css"/>
<link rel="stylesheet" href="<?php echo $staticUrl;?>/static/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo $staticUrl;?>/static/css/site.css"/>
<script src="<?php echo $staticUrl;?>/static/js/jquery-3.1.1.min.js"></script>
<script src="<?php echo $staticUrl;?>/static/js/bootstrap.min.js"></script>
<script src="<?php echo $staticUrl;?>/static/js/ajaxUpload.js"></script>
<script src="<?php echo $staticUrl;?>/static/js/jquery.dragsort-0.5.2.min.js"></script>


<link rel="stylesheet" href="<?php echo $staticUrl;?>/static/photoswipe/photoswipe.css"> 
<link rel="stylesheet" href="<?php echo $staticUrl;?>/static/photoswipe/default-skin/default-skin.css"> 
<script src="<?php echo $staticUrl;?>/static/photoswipe/photoswipe.min.js"></script> 
<script src="<?php echo $staticUrl;?>/static/photoswipe/photoswipe-ui-default.min.js"></script> 

<script src="<?php echo $staticUrl; ?>/static/js/formverify.js"></script>
<script src="<?php echo $staticUrl;?>/static/js/site.js"></script>

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
  <script src="<?php echo $staticUrl;?>/static/js/html5shiv.js"></script>
  <script src="<?php echo $staticUrl;?>/static/js/respond.min.js"></script>
<![endif]-->
<title><?php echo TpSystem::getParam('sitename');?></title>
<meta name="description" content="<?php echo TpSystem::getParam('sitekeywords');?>"/>
<meta name="keywords" content="<?php echo TpSystem::getParam('sitedesc');?>"/>