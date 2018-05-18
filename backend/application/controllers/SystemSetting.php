<?php

/*
 * Setting Data
  {"line":[{"colName":"name","colComment":"字段名称","dataType":"shortText","verify":[]},{"colName":"type","colComment":"字段填充类型","dataType":"shortText","verify":[]},{"colName":"content","colComment":"字段内容","dataType":"shortText","verify":[]},{"colName":"select","colComment":"选择框数据","dataType":"shortText","verify":[]},{"colName":"comments","colComment":"注释","dataType":"shortText","verify":[]},{"colName":"sort","colComment":"排序","dataType":"shortText","verify":[]},{"colName":"basic","colComment":"必须","dataType":"shortText","verify":[]}],"total":{"addKey[]":["name","type","content","select","comments","sort","basic"],"detailKey[]":["name","type","content","select","comments","sort","basic"],"editKey[]":["name","type","content","select","comments","sort","basic"],"listKey[]":["name","type","content","select","comments","sort","basic"]}}
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 系统配置
 * @author jian-jie.fu <fulusu@vip.sina.com>
 * @addTime  2016-11-13 09:00:03
 */
class SystemSetting extends MY_Data {

        public function __construct() {
                parent::__construct();
                $this->removeOpen = true;
                $this->controllerName = '系统配置';
                $this->tableName = 'systemconfig';
                $this->keyNameList = array("name" => "字段名称",
                    "type" => "字段填充类型",
                    "content" => "字段内容",
                    "select" => "选择框数据",
                    "comments" => "字段名称",
                    "sort" => "排序",
                    "basic" => "必须");
                $this->keyTypeList = array("name" => "middleText",
                    "type" => "select",
                    "content" => "textarea",
                    "select" => "textarea",
                    "comments" => "middleText",
                    "sort" => "middleText",
                    "basic" => "middleText");
                $this->keyVerifyList = array("name" => "",
                    "type" => "",
                    "content" => "",
                    "select" => "",
                    "comments" => "",
                    "sort" => "",
                    "basic" => "");
                $this->searchKey = array();
                $this->keySqlType = array("name" => "varchar",
                    "type" => "varchar",
                    "content" => "varchar",
                    "select" => "varchar",
                    "comments" => "varchar",
                    "sort" => "varchar",
                    "basic" => "varchar");
                $this->keyImportant = array("comments");
                $this->addKey = array("name",
                    "type",
                    "content",
                    "select",
                    "comments",
                    "sort",
                    "basic");
                $this->editKey = array("name",
                    "type",
                    "content",
                    "select",
                    "comments",
                    "sort",
                    "basic");
                $this->listKey = array("comments",
                    "content");
                $this->removeOpen = false;
                if ($this->usersystem->isSuperAdmin()) {
                        $this->addOpen = true;
                        $this->detailOpen = true;
                } else {
                        $this->addOpen = false;
                        $this->detailOpen = false;
                }
                $dataType = array();
                foreach($this->dataType as $k=>$v){
                        $dataType[$k] = $k;
                }
                $this->keySelectData['type'] =  $dataType;
        }

        public $dataType = array(
            'middleText' => 'varchar(100)',
            'textarea' => 'text',
            'image' => 'varchar(255)',
            'images' => 'text',
            'file' => 'varcha(255)',
            'files' => 'text',
            'select' => 'varchar(255)',
            'checkbox' => 'varchar(255)',
            'number' => 'int(7)',
            'bool' => 'tinyint(1)',
            'date' => 'date'
        );

        public function _beforeAddSave(&$data) {
                parent::_beforeAddSave($data);
                $this->cache->delete('Systemconfig');
        }

        public function _beforeEditSave(&$data) {
                parent::_beforeEditSave($data);
                $this->cache->delete('Systemconfig');
        }

        public function _beforeRemove(&$data) {
                parent::_beforeRemove($data);
                $this->cache->delete('Systemconfig');
        }

        public function _setListViewData(&$viewData) {
                $viewData['addonButton'] = $this->addonButton;
        }

        public function _beforeList(&$data) {
                parent::_beforeList($data);
                if (count($data) > 0) {
                        foreach ($data as $k => $each) {
                                $select = $this->_readSelect($each['select']);
                                if (isset($select[$each['content']])) {
                                        $data[$k]['content'] = $select[$each['content']];
                                }
                                $a = '';
                                if ($this->usersystem->isSuperAdmin()) {
                                        $a .= "<a href=\"/SystemSetting/edit?id={$each['id']}&superAdmin=1\" title=\"开发人员编辑\"><span class=\"glyphicon glyphicon-list-alt\"></span></a>";
                                }
                                $this->addonButton[$each['id']] = $a;
                        }
                }
        }

        public function _beforeEdit(&$data) {
                parent::_beforeEdit($data);
                if ($this->usersystem->isSuperAdmin() && $this->input->post_get('superAdmin') == 1) {
                        
                } else {
                        //用户模式
                        $data['editKey'] = array('content');
                        $data['keyTypeList']['content'] = $data['data']['type'];
                        $data['keyNameList']['content'] = $data['data']['comments'];
                        $data['keySelectData']['content'] = $this->_readSelect($data['data']['select']);
                }
        }

        public function _readSelect($str) {
                if (empty($str)) {
                        return array();
                }
                $returnArray = array();
                $array = explode("\n", $str);
                if (count($array) > 0) {
                        foreach ($array as $each) {
                                if (strstr($each, '=>') != -1) {
                                        list($key, $value) = explode('=>', $each);
                                        $returnArray[$key] = $value;
                                } else {
                                        $returnArray[$each] = $each;
                                }
                        }
                }
                return $returnArray;
        }

}

?>