<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 文章管理
 * @addTime  2018-05-30 04:04:45
 * @author  #name<#email>
 */
class Archives extends MY_Data
{
    public $listSql  = false;

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
            "body"=>"文章内容",
            "hr1"=>"基本信息",
            "hr2"=>"附件",
            "hr3"=>"SEO",
            "hr4"=>"其它",
            "hr5"=>"内容"
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
            "body"=>"htmlEditor",
            "hr1"=>"hrFirst",
            "hr2"=>"hr",
            "hr3"=>"hr",
            "hr4"=>"hr",
            "hr5"=>"hr"
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
            "isDelete" => "",
            "body"=>"",
        );
        //关键词模糊搜索 searchType = total   分词搜索  searchType = key
        $this->searchType= 'key';
        $this->searchKey = array(
            "typeid",
            "title"
        );
        $this->keySqlType = array(
            "id" => "int",
            "typeid" => "int",
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
            "isDelete" => "varchar",
            "body"=>"varchar"
        );
        $this->keyImportant = array();

        $this->detailKey = array(
            "hr1",
            "title",
            "typeid",
        );
        $this->addKey = array(
            "hr1",
            "title",
            "typeid",
            "hr5",
            "body"
        );
        $this->editKey = array(
            "hr1",
            "title",
            "typeid",
            "hr5",
            "body"
        );
        $this->listKey = array(
            "id",
            "typeid",
            "title",
            "source",
            "click",
            "pubdate",
            "sortrank"
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
        $this->load->model('CategoryData');
        $this->categorySelect = $this->CategoryData->sortSelect();
        $this->keySelectData['typeid'] =  $this->categorySelect;
    }

    public $body;

    public $categorySelect;

    public $addOnKey = array(
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

    public function _beforeAddSave(&$data)
    {
        parent::_beforeAddSave($data);
        $this->body = $data['body'];
        unset($data['body']);
        $data['pubdate'] = date('Y-m-d');
    }

    public function _afterAddSave(&$data)
    {
        $save = array(
            'aid'=>$data['id'],
            'body'=>$this->body,
            'typeid'=>$data['typeid']
        );
        $this->db->insert('we_addonarticle',$save);
    }

    public function _beforeDetail(&$data)
    {

        $query =  $this->db->select('body')->from('we_addonarticle')->where('aid',$data['data']['id'])->limit(1)->get();
        $row = $query->row_array();
        $data['data']['body'] = $row['body'];
    }

    public function _beforeEdit(&$data)
    {
        $query =  $this->db->select('body')->from('we_addonarticle')->where('aid',$data['data']['id'])->limit(1)->get();
        $row = $query->row_array();
        $data['data']['body'] = $row['body'];
    }

    public function _beforeEditSave(&$data)
    {
        if($this->input->post('body')!== NULL){
            $this->body = $data['body'];
            unset($data['body']);
        }
    }

    public function _afterEditSave(&$data)
    {
        if($this->input->post('body')!== NULL) {
            $save = array(
                'body' => $this->body
            );
            $this->db->where('aid', $data['id'])->limit(1);
            $this->db->update('we_addonarticle', $save);
        }
    }

}


?>
