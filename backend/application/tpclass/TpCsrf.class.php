<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * TpCsrf
 * 用于生成防止跨站脚本攻击的安全FORM 信息
 * 以Tp 为前缀的对象都是用于在模板层面的各种调用
 */
class TpCsrf {
	/**
	 * 获取指定的键值
	 * @param string $key
	 * @return string 
	 */
	static public function hidden(){
		$CI =& get_instance();
		$name =$CI->security->get_csrf_token_name();
		$hash =$CI->security->get_csrf_hash();
		return "<input type='hidden' name='{$name}' value='{$hash}' />";
	}
}
?>