<?php

/**
 * TpFlash 用于读取 原生的flashData
 * CodeIgniter 支持 "flashdata" ，它指的是一种只对下一次请求有效的 session 数据， 之后将会自动被清除。
 * 以Tp 为前缀的对象都是用于在模板层面的各种调用
 */
class TpFlash {

	/**
	 * 获取指定的键值
	 * 默认键值 Msg 
	 * 返回一个数组：['title'=>'','content'=>'']
	 * @param string $key
	 * @return string 
	 */
	static public function get($string = 'Msg') {
		$CI = & get_instance();
		return $CI->session->flashdata($string);
	}

	/**
	 * 获取错误提示
	 */
	static public function getError() {
		$CI = & get_instance();
		$str = $CI->session->userdata('errorInfo');
		$CI->session->unset_userdata('errorInfo');
		return $str;
	}

	static public function getSuccess($string = 'success') {
		$CI = & get_instance();
		$str = $CI->session->userdata($string);
		$CI->session->unset_userdata($string);
		return $str;
	}
	
	static public function getContent($string ='content'){
		$CI = & get_instance();
		$str = $CI->session->userdata($string);
		$CI->session->unset_userdata($string);
		return $str;
	}
}

?>