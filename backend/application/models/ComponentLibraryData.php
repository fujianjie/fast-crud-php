<?php 
/*
{"line":[{"colName":"title","colComment":"名称","dataType":"middleText","verify":[]},{"colName":"description","colComment":"使用说明","dataType":"textarea","verify":[]},{"colName":"filesCheck","colComment":"文件核对","dataType":"textarea","verify":[]},{"colName":"filesInfo","colComment":"文件信息","dataType":"textarea","verify":[]},{"colName":"sqlCheck","colComment":"数据库核对","dataType":"textarea","verify":[]},{"colName":"sqlStruct","colComment":"数据库信息","dataType":"textarea","verify":[]},{"colName":"sqlData","colComment":"基础数据","dataType":"textarea","verify":[]},{"colName":"version","colComment":"版本号","dataType":"middleText","verify":[]}],"total":{"addKey[]":["title","description","filesCheck","filesInfo","sqlCheck","sqlStruct","sqlData","version"],"detailKey[]":["title","description","filesCheck","filesInfo","sqlCheck","sqlStruct","sqlData","version"],"editKey[]":["title","description","filesCheck","filesInfo","sqlCheck","sqlStruct","sqlData","version"]}}
*/
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 数据模型说明
 * 组件库
 * @author jian-jie.fu <fulusu@vip.sina.com>
 * @addTime  2018-05-30 03:19:43
 */
class ComponentLibraryData extends MY_Model {

	public $tableName = 'we_component_library';

	public function __construct() {
		parent::__construct();
	}
	
}

 ?>