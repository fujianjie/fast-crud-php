<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 导航配置数据模块
 * 用于创建用户导航栏
 */
class NavData extends MY_Model {

	public $tableName = 'we_nav';

	public function __construct() {
		parent::__construct();
	}

	public function _arraySort($data) {
		$tmp = array();
		$now = 0;
		if (count($data) > 0) {
			while ( count($data) > 0  ) {

				$startCount =  count($data);
				foreach ($data as $k => $each) {
					if($each['id'] ==1 || $each['id'] == 1){
						unset($data[$k]);continue;
					}
					if ($each['pid'] == $now) {
						if($now == 0 ){
							$now = $each['id'];
						}else{
							$each['name'] = '　　'.$each['name'];
						}
						$tmp[] = $each;
						unset($data[$k]);
					}
				}
				$endCount =  count($data);
				if($startCount == $endCount){
					break;
				}
				$now = 0;
			}
			if(count($data)>0){
				$tmp = array_merge($tmp,$data);
			}
		}
		return $tmp;
	}
	
	public function _sonSort($data){
		$tmp = array();
		$now = 0;
		if (count($data) > 0) {
			while ( count($data) > 0  ) {
				$startCount =  count($data);
				foreach ($data as $k => $each) {
					if ($each['pid'] == $now) {
						if($now == 0 ){
							$now = $each['id'];
						}else{
							$each['name'] = '　　'.$each['name'];
						}
						if($each['pid'] == 0){
							$each['son'] =array();
							$tmp[$each['id']] = $each;
						}else{
							
							$tmp[$each['pid']]['son'][] = $each;
						}
						unset($data[$k]);
					}
				}
				$endCount =  count($data);
				if($startCount == $endCount){
					break;
				}
				$now = 0;
			}
			if(count($data)>0){
				$tmp = array_merge($tmp,$data);
			}
		}
		return $tmp;
	}

}

?>