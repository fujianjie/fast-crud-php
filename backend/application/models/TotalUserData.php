<?php 
/*
{"line":[{"colName":"account","colComment":"用户帐号","dataType":"middleText","verify":["required","checkMobile"]},{"colName":"password","colComment":"用户密码","dataType":"middleText","verify":["required"]},{"colName":"realname","colComment":"姓名","dataType":"middleText","verify":[]},{"colName":"email","colComment":"邮箱","dataType":"shortText","verify":["valid_email"]},{"colName":"mobile","colComment":"手机","dataType":"middleText","verify":["checkMobile"]},{"colName":"status","colComment":"状态","dataType":"shortText","verify":[]},{"colName":"uuid","colComment":"","dataType":"longText","verify":[]},{"colName":"group","colComment":"用户组","dataType":"shortText","verify":["required"]},{"colName":"hasChange","colComment":"是否修改过密码","dataType":"shortText","verify":[]},{"colName":"companyId","colComment":" 公司ID","dataType":"shortText","verify":[]}],"total":{"addKey[]":["account","password","realname","email","mobile","status","uuid","group","hasChange","companyId"],"detailKey[]":["account","password","realname","email","mobile","status","uuid","group","hasChange","companyId"],"editKey[]":["account","password","realname","email","mobile","status","uuid","group","hasChange","companyId"],"listKey[]":["account","password","realname","email","mobile","status","uuid","group","hasChange","companyId"],"keyImportant[]":["account"],"keyVerify[]":["required","checkMobile","required","valid_email","checkMobile","required"]}}
*/
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 数据模型说明
 * 全局用户管理
 * @author jian-jie.fu <fulusu@vip.sina.com>
 * @addTime  2016-11-14 06:09:56
 */
class TotalUserData extends MY_Model {

	public $tableName = 'we_user';

	public function __construct() {
		parent::__construct();
	}

	/**
	 * 搜索id
	 */
	public function searchName($id){
		$this->db->select(array('realname','mobile'));
		$this->db->from($this->tableName);
		$this->db->where('id',$id);
		$this->db->limit(1);
		$query = $this->db->get();
		$row= $query->row_array();
		if(empty($row)){
			return '';
		}else{
			return $row['realname'].'&nbsp;'.$row['mobile'];
		}
	}
	
}

 ?>