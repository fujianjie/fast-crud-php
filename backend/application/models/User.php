<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User model
 * 用户信息模块
 * 用于查询获取数据库中的用户资料
 */
class User extends CI_Model {

	public $tableName = 'we_user';

	public function __construct() {
		parent::__construct();
	}

	public function toLastest() {
		$query = $this->db->get('user', 10);
		return $query->result_array();
	}

	public function checkMobile($mobile) {
		$this->db->from('user');
		$this->db->where('mobile', $mobile);
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->row();
	}

	public function realname($id){
		$info =  $this->id($id);
		if($info !== null){
			return $info->realname;
		}else{
			return '';
		}

	}

	/**
	 * 登录信息查询
	 * @params  $mobile
	 * @return array
	 */
	public function mobile($mobile) {
		$this->db->from('user');
		$this->db->where('mobile', $mobile);
		$this->db->where('status', 1);
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->row();
	}

	/**
	 * 通过ID获得用户信息
	 * @params int $id
	 * @return array
	 */
	public function id($id){
		$this->db->from('user');
		$this->db->where('id', $id);
		$this->db->where('status', 1);
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->row();
	}

	/**
	 * 查询密码子串
	 */
	public function password($id) {
		$this->db->from('user');
		$this->db->where('id', $id);
		$this->db->select('password');
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->row();
	}

	/**
	 * 设定新密码
	 * @param  string $newpass
     * @param  int $id
     * @return array
	 */
	public function setNewPassword($newpass, $id) {
		$this->db->where('id', $id);
		$this->db->set('password', $newpass);
		$this->db->set('hasChange', 1);
		$this->db->limit(1);
		$this->db->update('user');
		return $this->db->affected_rows();
	}

    /**
     * 获取当前系统中的用户数量
     * @return integer
    */
	public function getCount(){
	    $this->db->select('count(1) as total');
	    $this->db->from('user');
	    $this->db->where('isDelete',0);
        $query = $this->db->get();
        $row = $query->row_array();
        return intval($row['total']);
    }

}

?>
