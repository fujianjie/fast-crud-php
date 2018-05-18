<?php

/**
 * 全局函数库
 * 添加部分必须要的东西
 */

/**
 * 注册自动加载器
 * 模板层面的数据加载器
 */
function tpAutoLoader($name) {
	$regex = '/^Tp\w+/';
	$search = preg_match($regex, $name);
	if (!preg_match($regex, $name)) {
		return FALSE;
	}
	$path = APPPATH . 'tpclass' . DIRECTORY_SEPARATOR . $name . '.class.php';
	if (file_exists($path)) {
		return include_once $path;
	}
	return FALSE;
}

spl_autoload_register('tpAutoLoader');

/**
 * 注册自动加载器
 * 控制器层面的核心加载
 */
function myAutoLoader($name) {
	$regex = '/^MY\w+/';
	$search = preg_match($regex, $name);
	if (!preg_match($regex, $name)) {
		return FALSE;
	}
	$path = APPPATH . 'core' . DIRECTORY_SEPARATOR . $name . '.php';
	if (file_exists($path)) {
		return include_once $path;
	}
	return FALSE;
}

spl_autoload_register('myAutoLoader');

/**
 * is 系列验证函数库
 */
/*
 * 验证用户名
 * 5-19位带下划线的中英文数字
 */
function isUsername($str) {
	return preg_match('/^[a-zA-Z][\w\d_]{5,19}/', $str);
}

/**
 * 验证手机号码
 */
function isMobile($str) {
	return preg_match('/^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/', $str);
}

/**
 * 验证手机号码
 */
function checkMobile($str) {
	$CI = & get_instance();
	if (!isMobile($str)) {
		$CI->msg->error('请输入正确的手机号码');

		return FALSE;
	} else {
		return TRUE;
	}
}

/**
 * 验证密码
 */
function isPassword($str) {
	return preg_match('/(?=.*[0-9])(?=.*[a-zA-Z])(?=.*[^a-zA-Z0-9]).{6,20}/', $str);
}

function checkPassword($str) {
	$CI = & get_instance();
	if (!isPassword($str)) {
		$CI->msg->error('您使用的密码需要包含符号，英文大小写字母，6-20位字符');

		return FALSE;
	} else {
		return TRUE;
	}
}

/**
 * 
 */
function isContent($str) {
	return preg_match('/^[\w~!@#$%^&*\uFF00-\uFFFF]\s/', $str);
}

function isQq($str) {
	return preg_match("/^[1-9]\d{4,9}$/", $str);
}

function isZip($str) {
	return preg_match("/^[1-9]\d{5}$/", $str);
}

function isIdcard($str) {
	return preg_match("/^\d{15}(\d{2}[A-Za-z0-9])?$/", $str);
}

function isChinese($str) {
	return preg_match("/^[" . chr(0xa1) . "-" . chr(0xff) . "]+$/", $str);
}

function isEmail($str) {
	return preg_match("/^[a-z0-9]+([._\-]*[a-z0-9])*@([a-z0-9]+[-a-z0-9]*[a-z0-9]+.){2,63}[a-z0-9]+$/", $str);
}

function isAccount($str) {
	return preg_match("/^[a-zA-Z][a-zA-Z0-9_]{4,15}$/", $str);
}

function isNumber($val) {
	return preg_match("/^[0-9]+$/", $val);
}

function isPhone($val) {
	//eg: xxx-xxxxxxxx-xxx | xxxx-xxxxxxx-xxx ...
	return preg_match("/^((0\d{2,3})-)(\d{7,8})(-(\d{3,}))?$/", $val);
}

function isPostcode($val) {
	return preg_match("/^[0-9]{4,6}$/", $val);
}

function isName($val) {
	return preg_match("/^[\x80-\xffa-zA-Z0-9]{3,60}$/", $val);
}

function isNumLength($val, $min, $max) {
	$theelement = trim($val);
	return preg_match("/^[0-9]{" . $min . "," . $max . "}$/", $val);
}

function isEngLength($val, $min, $max) {
	$theelement = trim($val);
	return preg_match("/^[a-zA-Z]{" . $min . "," . $max . "}$/", $val);
}

function isEnglish($theelement) {
	return preg_match("/[\x80-\xff]./", $theelement);
}

function isDate($sDate) {
	if (ereg("^[0-9]{4}\-[][0-9]{2}\-[0-9]{2}$", $sDate)) {
		Return true;
	} else {
		Return false;
	}
}

function isTime($sTime) {
	if (ereg("^[0-9]{4}\-[][0-9]{2}\-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}$", $sTime)) {
		Return true;
	} else {
		Return false;
	}
}

function isMoney($val) {
	if (preg_match("/^[0-9]{1,}$/", $val))
		return true;
	if (preg_match("/^[0-9]{1,}\.[0-9]{1,2}$/", $val))
		return true;
	return false;
}

function isIp($val) {
	return (bool) ip2long($val);
}

/**
 * 逐字遍历中文字符串
 */
function str_split_unicode($str, $l = 0) {
	if ($l > 0) {
		$ret = array();
		$len = mb_strlen($str, "UTF-8");
		for ($i = 0; $i < $len; $i += $l) {
			$ret[] = mb_substr($str, $i, $l, "UTF-8");
		}
		return $ret;
	}
	return preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY);
}

function downFile($file_name,$name)
{
    $file_path =  $file_name;
    $buffer = 102400; //一次返回102400个字节
    if (!file_exists($file_path)) {
        echo "<script type='text/javascript'> alert('对不起！该文件不存在或已被删除！'); </script>";

        return;
    }
    $fp = fopen($file_path, "r");
    $file_size = filesize($file_path);
    $file_data = '';
    while (!feof($fp)) {
        $file_data .= fread($fp, $buffer);
    }
    fclose($fp);

    //Begin writing headers
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: public");
    header("Content-Description: File Transfer");
    header("Content-type:application/octet-stream;");
    header("Accept-Ranges:bytes");
    header("Accept-Length:{$file_size}");
    header("Content-Disposition:attachment; filename={$name}");
    header("Content-Transfer-Encoding: binary");
    echo $file_data;
}

?>