<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 用户组模块
 */
class Group extends MY_Model {
	public $tableName = 'we_group';
	
	public function __construct() {
		parent::__construct();
	}
	
	public function toSelect(){
		return  $this->joinSelect('keyname','name');
	}
	
	public function selectData(){
		return  $this->joinSelect('id','name');
	}
	
	public function selectDataCompany($cid){
		return  $this->joinSelect('id','name',"id != 1 and (cid=0 or cid={$cid})");
	}
}

?>