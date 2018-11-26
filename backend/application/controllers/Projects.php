<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 项目管理
 * @addTime  2018-05-28 01:25:17
 * @author  #name<#email>
 */
class Projects extends MY_Data
{

    public function __construct()
    {
        parent::__construct();
        $this->controllerName = '项目管理';
        $this->tableName = 'we_projects';
        $this->keyNameList = array(
            "id" => "序号",
            "title" => "名称",
            "description" => "简介",
            "owner" => "介绍人",
            "price" => "项目金额",
            "status" => "状态",
            "contract" => "合同",
            "quotation" => "报价单",
            "localAddress" => "本地地址",
            "onlineAddress" => "线上测试地址",
            "productAddress" => "正式环境",
            "createDate" => "创建日期",
            "onlineDate" => "上线日期",
            "realPrice"=>"实际金额"
        );
        $this->keyTypeList = array(
            "id" => "middleText",
            "title" => "middleText",
            "description" => "textarea",
            "owner" => "middleText",
            "price" => "money",
            "realPrice"=>"money",
            "status" => "select",
            "contract" => "files",
            "quotation" => "files",
            "localAddress" => "middleText",
            "onlineAddress" => "middleText",
            "productAddress" => "middleText",
            "createDate" => "date",
            "onlineDate" => "date"
        );
        $this->keyVerifyList = array(
            "id" => "numeric",
            "title" => "",
            "description" => "",
            "owner" => "",
            "price" => "",
            "status" => "",
            "contract" => "",
            "quotation" => "",
            "localAddress" => "",
            "onlineAddress" => "",
            "productAddress" => "",
            "createDate" => "",
            "onlineDate" => "",
            "realPrice"=>""
        );
        //关键词模糊搜索 searchType = total   分词搜索  searchType = key
        //$this->searchType= 'key';
        $this->searchKey = array('title','description','owner');
        $this->keySqlType = array(
            "id" => "int",
            "title" => "varchar",
            "description" => "text",
            "owner" => "varchar",
            "price" => "float",
            "realPrice"=>"float",
            "status" => "varchar",
            "contract" => "varchar",
            "quotation" => "varchar",
            "localAddress" => "varchar",
            "onlineAddress" => "varchar",
            "productAddress" => "varchar",
            "createDate" => "date",
            "onlineDate" => "date"
        );
        $this->keyImportant = array();
        $this->detailKey = array(
            "title",
            "owner",
            "price",
            "realPrice",
            "status",
            "contract",
            "quotation",
            "localAddress",
            "onlineAddress",
            "productAddress",
            "createDate",
            "onlineDate",
            "description",
        );
        $this->addKey = array(
            "title",
            "description",
            "owner",
            "price",
            "realPrice",
            "status",
            "contract",
            "quotation",
            "localAddress",
            "onlineAddress",
            "productAddress",
            "createDate",
            "onlineDate"
        );
        $this->editKey = array(
            "title",
            "description",
            "owner",
            "price",
            "realPrice",
            "status",
            "contract",
            "quotation",
            "localAddress",
            "onlineAddress",
            "productAddress",
            "createDate",
            "onlineDate"
        );
        $this->listKey = array(
            "id",
            "title",
            "owner",
            "realPrice",
            "price",
            "status",
            "createDate"
        );
        $this->keySelectData = array(
            "status" => array(
                0=>'洽谈中',
                1=>'待签约',
                2=>'已签约',
                3=>'设计中',
                4=>'开发中',
                5=>'测试上线',
                6=>'结款中',
                7=>'运行中',
                8=>'已结款'
            )
        );
        //关闭综合搜索
        $this->searchPageOpen = false;
        //关闭排序
        $this->listSortOpen = false;
        $this->load->model('ProjectsData');
    }

}


?>
