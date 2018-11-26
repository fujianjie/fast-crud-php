<?php 
/*
{"line":[{"colName":"title","colComment":"名称","dataType":"middleText","verify":[]},{"colName":"description","colComment":"简介","dataType":"textarea","verify":[]},{"colName":"owner","colComment":"介绍人","dataType":"middleText","verify":[]},{"colName":"price","colComment":"项目金额","dataType":"money","verify":[]},{"colName":"status","colComment":"状态","dataType":"select","verify":[]},{"colName":"contract","colComment":"合同","dataType":"middleText","verify":[]},{"colName":"quotation","colComment":"报价单","dataType":"middleText","verify":[]},{"colName":"localAddress","colComment":"本地地址","dataType":"middleText","verify":[]},{"colName":"onlineAddress","colComment":"线上测试地址","dataType":"middleText","verify":[]},{"colName":"productAddress","colComment":"正式环境","dataType":"middleText","verify":[]},{"colName":"createDate","colComment":"创建日期","dataType":"date","verify":[]},{"colName":"onlineDate","colComment":"上线日期","dataType":"date","verify":[]}],"total":{"addKey[]":["title","description","owner","price","status","contract","quotation","localAddress","onlineAddress","productAddress","createDate","onlineDate"],"detailKey[]":["title","description","owner","price","status","contract","quotation","localAddress","onlineAddress","productAddress","createDate","onlineDate"],"editKey[]":["title","description","owner","price","status","contract","quotation","localAddress","onlineAddress","productAddress","createDate","onlineDate"],"listKey[]":["title","owner","price","status"]}}
*/
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 数据模型说明
 * 项目管理
 * @author jian-jie.fu <fulusu@vip.sina.com>
 * @addTime  2018-05-28 01:25:17
 */
class ProjectsData extends MY_Model {

	public $tableName = 'we_projects';

	public function __construct() {
		parent::__construct();
	}
	
}

 ?>