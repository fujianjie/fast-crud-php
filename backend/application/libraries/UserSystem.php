<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * 用户登录以及权限系统
 * @author jian-jie.fu <fulusu@vip.sina.com>
 * @modifyTime  2017-03-25 11:27:30
 */
class UserSystem {

	public $CI;

	/**
	 * 在SESSION 的关键字
	 */
	public static $sys = 'UserSystem';
	public $userInfo;

	/**
	 * 返回SESSION关键字
	 * @return string
	*/
	public function sys() {
		return self::$sys;
	}

	public function __construct() {
		$this->CI = & get_instance();
	}

	/**
	 * 返回用户ID
	 */
	public function uid() {
		return $_SESSION[self::$sys]['UserInfo']['id'];
	}

	/**
     * 返回用户姓名
     * @return string
	*/
	public function realname(){
	    return $this->get('realname');
    }

    /**
     * 返回用户EMAIL 邮箱
     * @return string email
    */
    public function email(){
        return $this->get('email');
    }

	/**
	 * 返回用户信息数组
	 */
	public function info() {
		return $_SESSION[self::$sys]['UserInfo'];
	}

	/**
	 * 返回用户信息内的指定字段
	 */
	public function get($name) {
		if (isset($_SESSION[self::$sys]['UserInfo'][$name]))
			return $_SESSION[self::$sys]['UserInfo'][$name];
		else
			return NULL;
	}

	/**
	 * 设定用户信息
	 */
	public function set($name, $value) {
		$_SESSION[self::$sys]['UserInfo'][$name] = $value;
	}

	/**
	 * 验证用户的用户名以及密码
	 * @param $username
	 * @param $password
	 * @return bool
	 */
	public function verifyUser($username, $password) {
		$this->CI->load->model('User');
		$userInfo = $this->CI->User->mobile($username);
                
		if ($userInfo !== NULL && $password == $this->decrypt($userInfo->password)) {
			$this->userInfo = $userInfo;
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function isSuperAdmin(){
		return $_SESSION[self::$sys]['isSuperAdmin'];
	}

	/**
	 * 登录操作
	 */
	public function login() {
		$userInfo = (array) $this->userInfo;
		unset($userInfo['password']);
		$isSuperAdmin = false;
		if (isset($_SESSION[self::$sys]['isSuperAdmin'])) {
			$isSuperAdmin = $_SESSION[self::$sys]['isSuperAdmin'];
		}

		$_SESSION[self::$sys] = array();
		$_SESSION[self::$sys]['UserInfo'] = $userInfo;
		$_SESSION[self::$sys]['Access'] = array();
		$_SESSION[self::$sys]['Group'] = $this->setGroup();
		$_SESSION[self::$sys]['Access'] = $_SESSION[self::$sys]['Group'] ['access'];
		if ($userInfo['id'] == 1 && $userInfo['group'] == 1) {
			$_SESSION[self::$sys]['isSuperAdmin'] = true;
		} else {
			$_SESSION[self::$sys]['isSuperAdmin'] = false;
		}
		if ($isSuperAdmin) {
			$_SESSION[self::$sys]['isSuperAdmin'] = true;
		}
	}




	/**
	 * 获取分组权限信息
	 * @return array
	 */
	public function setGroup() {
		$this->CI->db->where('id', $this->get('group'));
		$query = $this->CI->db->get('group');
		$data = $query->row_array();
		$access = array();
		if (intval($data['id']) === 1 && $data['keyname'] == 'root') {
			$this->CI->db->select('keyset');
			$query = $this->CI->db->get('access');
			$array = $query->result_array();
			if (count($array) > 0) {
				foreach ($array as $each) {
					$access[] = strtolower($each['keyset']);
				}
			}
			$data['access'] = $access;
		} else {
			$data['access'] = explode(',', strtolower($data['access']));
		}

		return $data;
	}

	/**
	 * 判断是否已经登录
	 * @return bool
	 */
	public function checkHasLogin() {
		if (isset($_SESSION[self::$sys]) && isset($_SESSION[self::$sys]['UserInfo'])) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	/**
	 * 手动登出
	*/
	public function logout() {
		$this->CI->session->unset_userdata(self::$sys);
		$this->CI->load->helper('cookie');
		$_SESSION = array();

		delete_cookie('username');
		delete_cookie('password');
	}

	/**
	 * 给用户添加某个权限
	 * @param string $name
	 */
	public function setAccess($name) {
		$name = strtolower($name);
		if (!in_array($_SESSION[self::$sys]['Access'], $name)) {
			$_SESSION[self::$sys]['Access'][] = $name;
		}
	}

	/**
	 * 判断该用户是否有该权限
     * //InspectionUser 巡检员
	 * @param string $accessName
	 * @param bool isApi default is 'false'
	 * @param bool $return
	 * @return bool
	 */
	public function hasAccess($accessName,$isApi = false,$return = false) {
		$accessName = strtolower($accessName);


		if (!in_array($accessName, $_SESSION[self::$sys]['Access'])) {

			$json = array(
					'status'=>'failed',
					'msg'=>'你没有使用该模块的权限',
					'data'=>array()
			);
			if($return){
				return $json;
			}
			if($isApi){
				echo json_encode($json);
			}else{
				$this->CI->msg->error('你没有使用该模块的权限');
				$this->CI->msg->to('site/dashboard');
			}
			die();
		}

		return true;
	}

	/**
	 * 判断该用户是否有该权限
	 * 超级管理员默认获得所有权限
	 * 超级管理员唯一判定办法 Uid  = 1 && Group id = 1
	 * @param string $accessName
	 * @return bool
	 */
	public function checkHasAccess($accessName) {
		if ($_SESSION[self::$sys]['Group']['id'] == 1 && $this->get('id') == 1) {
			return true;
		}
		//var_dump($_SESSION[self::$sys]['Access']);
		$accessName = strtolower($accessName);
		return in_array($accessName, $_SESSION[self::$sys]['Access']);
	}

	/**
	 * 创建用于用户密码的密文
	 * @param string $password
	 * @return string
	 */
	public function encrypt($password) {
		$this->CI->load->library('encryption');
		return $this->CI->encryption->encrypt($password);
	}

	/**
	 * 解密用于用户密码的密文
	 * @param string $password
	 * @return string
	 */
	public function decrypt($password) {
		$this->CI->load->library('encryption');
		return $this->CI->encryption->decrypt($password);
	}

	/**
	 * 设置新密码
	 */
	public function setNewPassword($password) {
		$this->CI->load->model('User');
		$status = $this->CI->User->setNewPassword($this->encrypt($password), $this->uid());
		$this->set('hasChange', 1);
		return $status;
	}

	/**
	 * 登录为指定ID 的用户
	 * @param int $uid
	 * @return void
	*/
	public function loadUser($uid){
		$this->CI->load->model('User');
		$this->userInfo = $this->CI->User->id($uid);
		$this->login();
	}
}

?>