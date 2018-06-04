<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 文章管理
 * @addTime  2018-05-30 04:04:45
 * @author  #name<#email>
 */
class Archives extends MY_Data
{

    public function __construct()
    {
        parent::__construct();
        $this->controllerName = '文章管理';
        $this->tableName = 'we_archives';
        $this->keyNameList = array(
            "id" => "序号",
            "typeid" => "所属栏目",
            "sortrank" => "栏目排序序号",
            "click" => "文章点击数",
            "title" => "文章标题",
            "shorttitle" => "文章短标题",
            "color" => "文章标题链接颜色",
            "writer" => "文章作者",
            "source" => "文章来源",
            "litpic" => "缩略图",
            "pubdate" => "创建日期",
            "senddate" => "发布日期",
            "keywords" => "文章关键字",
            "lastpost" => "修改日期",
            "description" => "描述",
            "filename" => "文件名",
            "template" => "独立模版页",
            "isDelete" => "是否删除",
            "hr1"=>"基本信息",
            "hr2"=>"附件",
            "hr3"=>"SEO",
            "hr4"=>"其它"
        );
        $this->keyTypeList = array(
            "id" => "middleText",
            "typeid" => "select",
            "sortrank" => "shortText",
            "click" => "shortText",
            "title" => "middleText",
            "shorttitle" => "middleText",
            "color" => "shortText",
            "writer" => "middleText",
            "source" => "middleText",
            "litpic" => "images",
            "pubdate" => "date",
            "senddate" => "datetime",
            "keywords" => "middleText",
            "lastpost" => "datetime",
            "description" => "textarea",
            "filename" => "files",
            "template" => "middleText",
            "isDelete" => "middleText",
            "hr1"=>"hrFirst",
            "hr2"=>"hr",
            "hr3"=>"hr",
            "hr4"=>"hr"
        );
        $this->keyVerifyList = array(
            "id" => "numeric",
            "typeid" => "required",
            "sortrank" => "",
            "click" => "",
            "title" => "required",
            "shorttitle" => "",
            "color" => "",
            "writer" => "",
            "source" => "",
            "litpic" => "",
            "pubdate" => "required",
            "senddate" => "",
            "keywords" => "",
            "lastpost" => "",
            "description" => "",
            "filename" => "",
            "template" => "",
            "isDelete" => ""
        );
        //关键词模糊搜索 searchType = total   分词搜索  searchType = key
        //$this->searchType= 'key';
        $this->searchKey = array(
            "typeid",
            "title",
            "shorttitle",
            "writer",
            "source",
            "keywords",
            "description"
        );
        $this->keySqlType = array(
            "id" => "int",
            "typeid" => "varchar",
            "sortrank" => "varchar",
            "click" => "varchar",
            "title" => "varchar",
            "shorttitle" => "varchar",
            "color" => "varchar",
            "writer" => "varchar",
            "source" => "varchar",
            "litpic" => "varchar",
            "pubdate" => "date",
            "senddate" => "datetime",
            "keywords" => "varchar",
            "lastpost" => "datetime",
            "description" => "varchar",
            "filename" => "varchar",
            "template" => "varchar",
            "isDelete" => "varchar"
        );
        $this->keyImportant = array();
        $this->detailKey = array(

            "title",
            "shorttitle",
            "typeid",
            "sortrank",
            "click",
            "color",
            "writer",
            "source",
            "litpic",
            "pubdate",
            "senddate",
            "keywords",
            "lastpost",
            "description",
            "filename",
            "template"
        );
        $this->addKey = array(
            "hr1",
            "title",
            "typeid",
            "pubdate",
            "hr2",
            "litpic",
            "filename",
            "hr3",
            "keywords",
            "description",
            "hr4",
            "shorttitle",
            "writer",
            "source",
            "color",
            "sortrank",
            "template",
        );
        $this->editKey = array(
            "typeid",
            "sortrank",
            "click",
            "title",
            "shorttitle",
            "color",
            "writer",
            "source",
            "litpic",
            "pubdate",
            "senddate",
            "keywords",
            "lastpost",
            "description",
            "filename",
            "template",
        );
        $this->listKey = array(
            "id",
            "typeid",
            "title",
            "source",
            "click",
            "pubdate"
        );
        $this->keySelectData = array(
            "typeid" => "",
            "litpic" => "",
            "filename" => ""
        );
        //关闭综合搜索
        $this->searchPageOpen = false;
        //关闭排序
        $this->listSortOpen = false;
        $this->load->model('ArchivesData');
    }

}


?>
