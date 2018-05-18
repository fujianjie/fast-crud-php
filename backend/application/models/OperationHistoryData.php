<?php 
/*
{"line":[{"colName":"controllerName","colComment":"模块名称","dataType":"middleText","verify":[]},{"colName":"uid","colComment":"用户","dataType":"number","verify":[]},{"colName":"realname","colComment":"姓名","dataType":"middleText","verify":[]},{"colName":"addTime","colComment":"操作时间","dataType":"timestamp","verify":[]},{"colName":"actionInfo","colComment":"操作内容","dataType":"middleText","verify":[]},{"colName":"backup","colComment":"备注","dataType":"textarea","verify":[]},{"colName":"dataId","colComment":"数据id","dataType":"number","verify":[]}],"total":{"addKey[]":["controllerName","uid","realname","addTime","actionInfo","backup","dataId"],"detailKey[]":["controllerName","uid","realname","addTime","actionInfo","backup","dataId"],"editKey[]":["controllerName","uid","realname","addTime","actionInfo","backup","dataId"],"searchKey[]":["controllerName"],"listKey[]":["controllerName","uid","realname","addTime","actionInfo","backup","dataId"]}}
*/
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 数据模型说明
 * 操作历史
 * @author jian-jie.fu <fulusu@vip.sina.com>
 * @addTime  2017-06-27 04:28:47
 */
class OperationHistoryData extends MY_Model {

	public $tableName = 'we_operation_history';

	public function __construct() {
		parent::__construct();
	}

	/**
     * 保存操作历史
     * 自填充项：用户姓名与ID 取自登陆信息
     * 自填充项：操作时间 系统时间
     * @param  string $controllerName  模块名称
     * @param  string $actionInfo 操作内容
     * @param  string $backup 备注
     * @param  int $dataId 数据ID
     * @return  object db query result
	*/
	public function opt($controllerName='',$actionInfo='',$backup='',$dataId=0){
        $this->load->library('UserSystem');

	    $saveData = array(
	        'controllerName'=>$controllerName,
            'actionInfo'=> $actionInfo,
            'backup'=>$backup,
            'addTime'=>date('Y-m-d h:i:s'),
            'uid'=>$this->usersystem->uid(),
            'realname'=>$this->usersystem->realname(),
            'dataId'=>$dataId
        );

	    return $this->db->insert($this->tableName,$saveData);
    }
	
}

 ?>