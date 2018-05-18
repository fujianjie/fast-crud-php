<?php 
/*
{"line":[{"colName":"name","colComment":"字段名称","dataType":"shortText","verify":[]},{"colName":"type","colComment":"字段填充类型","dataType":"shortText","verify":[]},{"colName":"content","colComment":"字段内容","dataType":"shortText","verify":[]},{"colName":"select","colComment":"选择框数据","dataType":"shortText","verify":[]},{"colName":"comments","colComment":"注释","dataType":"shortText","verify":[]},{"colName":"sort","colComment":"排序","dataType":"shortText","verify":[]},{"colName":"basic","colComment":"必须","dataType":"shortText","verify":[]}],"total":{"addKey[]":["name","type","content","select","comments","sort","basic"],"detailKey[]":["name","type","content","select","comments","sort","basic"],"editKey[]":["name","type","content","select","comments","sort","basic"],"listKey[]":["name","type","content","select","comments","sort","basic"]}}
*/
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 数据模型说明
 * 系统配置
 * @author jian-jie.fu <fulusu@vip.sina.com>
 * @addTime  2016-11-13 09:00:03
 */
class SystemSettingData extends MY_Model {

	public $tableName = 'we_systemconfig';

	public function __construct() {
		parent::__construct();
	}
	
}

 ?>