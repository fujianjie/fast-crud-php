<?php

/*
 * Setting Data
  {"line":[{"colName":"date","colComment":"日期","dataType":"date","verify":[]},{"colName":"filename","colComment":"文件名","dataType":"middleText","verify":[]},{"colName":"addTime","colComment":"添加时间","dataType":"timestamp","verify":[]},{"colName":"uid","colComment":"用户","dataType":"shortText","verify":[]},{"colName":"cid","colComment":"公司","dataType":"shortText","verify":[]},{"colName":"sourcename","colComment":"原文件名","dataType":"middleText","verify":[]}],"total":{"detailKey[]":["date","filename","addTime","uid","cid","sourcename"],"listKey[]":["date","filename","addTime","sourcename"],"searchKey[]":["sourcename"],"keyImportant[]":["sourcename"]}}
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 文件存储信息
 * @author jian-jie.fu <fulusu@vip.sina.com>
 * @addTime  2016-11-23 01:42:35
 */
class Files extends MY_Data
{

    public function __construct()
    {
        parent::__construct();
        $this->controllerName = '文件存储信息';
        $this->tableName = 'we_files';
        $this->keyNameList = array(
            "id" => "序号",
            "date" => "日期",
            "filename" => "文件名",
            "addTime" => "添加时间",
            "uid" => "用户",
            "cid" => "公司",
            "sourcename" => "原文件名",
            'filesLink' => "文件链接"
        );
        $this->keyTypeList = array(
            "id" => "middleText",
            "date" => "date",
            "filename" => "middleText",
            "addTime" => "timestamp",
            "uid" => "shortText",
            "cid" => "company",
            "sourcename" => "middleText",
            'filesLink' => 'a'
        );
        $this->keyVerifyList = array(
            "id" => "numeric",
            "date" => "",
            "filename" => "",
            "addTime" => "",
            "uid" => "",
            "cid" => "",
            "sourcename" => "",
            'filesLink' => ''
        );
        $this->searchKey = array(
            "sourcename"
        );
        $this->keySqlType = array(
            "id" => "int",
            "date" => "date",
            "filename" => "varchar",
            "addTime" => "timestamp",
            "uid" => "varchar",
            "cid" => "varchar",
            "filesLink" => "varchar",
            "sourcename" => "varchar"

        );
        $this->keyImportant = array(
            "sourcename"
        );
        $this->detailKey = array(
            "date",
            "filename",
            "sourcename",
            "filesLink",
            "addTime"
        );
        $this->addKey = array();
        $this->editKey = array();
        $this->listKey = array(
            "sourcename",
            "filename",
            "addTime"
        );
        $this->keySelectData = array();
        $this->addOpen = false;
        $this->editOpen = false;
        $this->removeOpen = false;

    }

    public function _beforeDetail(&$data)
    {
        parent::_beforeDetail($data);
        $data['data']['filesLink'] = '/uploads/' . $data['data']['date'] . '/' . $data['data']['filename'];
    }

}

?>