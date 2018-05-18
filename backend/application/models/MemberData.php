<?php 
/*
{"line":[{"colName":"openid","colComment":"openid","dataType":"middleText","verify":[]},{"colName":"nickname","colComment":"昵称","dataType":"middleText","verify":[]},{"colName":"mobile","colComment":"手机","dataType":"middleText","verify":[]},{"colName":"status","colComment":"用户状态，0可用，1禁用","dataType":"select","verify":[]},{"colName":"loginTime","colComment":"最后一次登录时间","dataType":"middleText","verify":[]},{"colName":"userType","colComment":"用户类型","dataType":"middleText","verify":[]},{"colName":"regTime","colComment":"注册日期","dataType":"middleText","verify":[]},{"colName":"referrer","colComment":"推荐人手机","dataType":"middleText","verify":[]}],"total":{"addKey[]":["openid","nickname","mobile","status","loginTime","userType","regTime","referrer"],"detailKey[]":["openid","nickname","mobile","status","loginTime","userType","regTime","referrer"],"editKey[]":["openid","nickname","mobile","status","loginTime","userType","regTime","referrer"],"searchKey[]":["openid","nickname","mobile"],"listKey[]":["openid","nickname","mobile"]}}
*/
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 数据模型说明
 * 会员管理
 * @author jian-jie.fu <fulusu@vip.sina.com>
 * @addTime  2017-08-14 01:37:24
 */
class MemberData extends MY_Model {

	public $tableName = 'we_member';

	public function __construct() {
		parent::__construct();
	}
	
}

 ?>