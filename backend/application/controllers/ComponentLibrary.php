<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 组件库
 * @addTime  2018-05-30 03:19:43
 * @author  #name<#email>
 */
class ComponentLibrary extends MY_Data
{

    public function __construct()
    {
        parent::__construct();
        $this->controllerName = '组件库';
        $this->tableName = 'we_component_library';
        $this->keyNameList = array(
            "id" => "序号",
            "title" => "名称",
            "description" => "使用说明",
            "filesCheck" => "文件核对",
            "filesInfo" => "文件信息",
            "sqlCheck" => "数据库核对",
            "sqlStruct" => "数据库信息",
            "sqlData" => "基础数据",
            "version" => "版本号",
            "status"=>"状态",
            "basic"=>"依赖"
        );
        $this->keyTypeList = array(
            "id" => "middleText",
            "title" => "middleText",
            "description" => "textarea",
            "filesCheck" => "textarea",
            "filesInfo" => "textarea",
            "sqlCheck" => "textarea",
            "sqlStruct" => "textarea",
            "sqlData" => "textarea",
            "version" => "middleText",
            "status"=>"select",
            "basic"=>"textarea"
        );
        $this->keyVerifyList = array(
            "id" => "numeric",
            "title" => "",
            "description" => "",
            "filesCheck" => "",
            "filesInfo" => "",
            "sqlCheck" => "",
            "sqlStruct" => "",
            "sqlData" => "",
            "version" => "",
            "status"=>"",
            "basic"=>""
        );
        //关键词模糊搜索 searchType = total   分词搜索  searchType = key
        //$this->searchType= 'key';
        $this->searchKey = array('title','description');
        $this->keySqlType = array(
            "id" => "int",
            "title" => "varchar",
            "description" => "text",
            "filesCheck" => "text",
            "filesInfo" => "text",
            "sqlCheck" => "text",
            "sqlStruct" => "text",
            "sqlData" => "text",
            "version" => "varchar",
            "status"=>"int",
            "basic"=>"text"
        );
        $this->keyImportant = array();
        $this->detailKey = array(
            "title",
            "description",
            "filesCheck",
            "filesInfo",
            "sqlCheck",
            "sqlStruct",
            "sqlData",
            "version",
            "status",
            "basic"
        );
        $this->addKey = array(
            "title",
            "description",
            "filesCheck",
            "filesInfo",
            "sqlCheck",
            "sqlStruct",
            "sqlData",
            "version",
            "status",
            "basic"
        );

        $this->editKey = array(
            "title",
            "description",
            "filesCheck",
            "filesInfo",
            "sqlCheck",
            "sqlStruct",
            "sqlData",
            "version",
            "status",
            "basic"
        );

        $this->listKey = array(
            "title",
            "description",
            "version",
            "status"
        );

        $this->keySelectData = array(
            "status"=>array(
                0=>'未安装',
                1=>'已安装'
            )
        );

        //关闭综合搜索
        $this->searchPageOpen = false;
        //关闭排序
        $this->listSortOpen = false;
        $this->load->model('ComponentLibraryData');
    }

}


?>
