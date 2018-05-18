<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<meta charset="utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<meta name="viewport" content="width=device-width, initial-scale=1 , user-scalable=no"/>
<?php $staticUrl = TpSystem::getParam('staticurl'); ?>
<link rel="stylesheet" href="<?php echo $staticUrl;?>/static/css/bootstrap.min.css"/>
<link rel="stylesheet" href="<?php echo $staticUrl;?>/static/css/bootstrap-theme.min.css"/>
<link rel="stylesheet" href="<?php echo $staticUrl;?>/static/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo $staticUrl;?>/static/css/main.css?v=1"/>
<script src="<?php echo $staticUrl;?>/static/js/jquery-3.1.1.min.js"></script>
<script src="<?php echo $staticUrl;?>/static/js/bootstrap.min.js"></script>
<script src="<?php echo $staticUrl;?>/static/js/main.js"></script>
<title><?php echo isset($title)?$title: TpSystem::getParam('sitename');?></title>
<meta name="description" content="<?php echo isset($description)?$description: TpSystem::getParam('sitekeywords');?>"/>
<meta name="keywords" content="<?php echo isset($keywords)?$keywords:TpSystem::getParam('sitedesc');?>"/>