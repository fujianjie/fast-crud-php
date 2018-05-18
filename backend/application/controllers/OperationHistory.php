<?php

/*
 * Setting Data
{"line":[{"colName":"controllerName","colComment":"模块名称","dataType":"middleText","verify":[]},{"colName":"uid","colComment":"用户","dataType":"number","verify":[]},{"colName":"realname","colComment":"姓名","dataType":"middleText","verify":[]},{"colName":"addTime","colComment":"操作时间","dataType":"timestamp","verify":[]},{"colName":"actionInfo","colComment":"操作内容","dataType":"middleText","verify":[]},{"colName":"backup","colComment":"备注","dataType":"textarea","verify":[]},{"colName":"dataId","colComment":"数据id","dataType":"number","verify":[]}],"total":{"addKey[]":["controllerName","uid","realname","addTime","actionInfo","backup","dataId"],"detailKey[]":["controllerName","uid","realname","addTime","actionInfo","backup","dataId"],"editKey[]":["controllerName","uid","realname","addTime","actionInfo","backup","dataId"],"searchKey[]":["controllerName"],"listKey[]":["controllerName","uid","realname","addTime","actionInfo","backup","dataId"]}}
*/
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 操作历史
 * @author jian-jie.fu <fulusu@vip.sina.com>
 * @addTime  2017-06-27 04:28:47
 */
class OperationHistory extends MY_Data
{

    public  $listSql = false;
    public function __construct()
    {
        parent::__construct();
        $this->controllerName = '操作历史';
        $this->tableName = 'we_operation_history';
        $this->keyNameList = array(
            "id" => "序号",
            "controllerName" => "模块名称",
            "uid" => "用户",
            "realname" => "姓名",
            "addTime" => "操作时间",
            "actionInfo" => "操作内容",
            "backup" => "备注",
            "dataId" => "数据id"
        );
        $this->keyTypeList = array(
            "id" => "middleText",
            "controllerName" => "middleText",
            "uid" => "number",
            "realname" => "middleText",
            "addTime" => "timestamp",
            "actionInfo" => "middleText",
            "backup" => "textarea",
            "dataId" => "number"
        );
        $this->keyVerifyList = array(
            "id" => "numeric",
            "controllerName" => "",
            "uid" => "",
            "realname" => "",
            "addTime" => "",
            "actionInfo" => "",
            "backup" => "",
            "dataId" => ""
        );
        //关键词模糊搜索 searchType = total   分词搜索  searchType = key
        $this->searchType= 'key';
        $this->searchKey = array(
            "controllerName",
            'dataId',
            'uid',
            'realname'
        );
        $this->keySqlType = array(
            "id" => "int",
            "controllerName" => "varchar",
            "uid" => "int",
            "realname" => "varchar",
            "addTime" => "timestamp",
            "actionInfo" => "varchar",
            "backup" => "text",
            "dataId" => "int"
        );
        $this->keyImportant = array();
        $this->detailKey = array(
            "controllerName",
            "uid",
            "realname",
            "addTime",
            "actionInfo",
            "backup",
            "dataId"
        );
        $this->addKey = array(
            "controllerName",
            "uid",
            "realname",
            "addTime",
            "actionInfo",
            "backup",
            "dataId"
        );
        $this->editKey = array(
            "controllerName",
            "uid",
            "realname",
            "addTime",
            "actionInfo",
            "backup",
            "dataId"
        );
        $this->listKey = array(
            "controllerName",
            "uid",
            "realname",
            "actionInfo",
            "backup",
            "dataId",
            "addTime"
        );
        $this->keySelectData = array();
        //关闭综合搜索
        $this->searchPageOpen = true;
        //关闭排序
        $this->listSortOpen = false;
        $this->load->model('OperationHistoryData');
        $this->addOpen = false;
        $this->editOpen = false;
        $this->removeOpen = false;
    }

}


?>