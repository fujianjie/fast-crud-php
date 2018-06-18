<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 栏目管理
 * @addTime  2018-06-05 09:20:15
 * @author  jian-jie.fu<jian-jie.fu@qq.com>
 */
class Category extends MY_Data
{
    public $categorySelect;

    public function __construct()
    {
        parent::__construct();
        $this->controllerName = '栏目管理';
        $this->tableName = 'we_category';
        $this->keyNameList = array(
            "id" => "序号",
            "reId" => "上级id",
            "topId" => "顶级id",
            "sortrank" => "排序号",
            "isdefault" => "是否默认",
            "defaultname" => "默认名称",
            "channeltype" => "数据模型类型",
            "maxpage" => "数据总数",
            "ispart" => "部分显示",
            "corank" => "优先等级",
            "tempindex" => "栏目主页",
            "templist" => "栏目列表",
            "temparticle" => "栏目单页",
            "namerule" => "栏目页命名规则",
            "namerule2" => "单页命名规则",
            "modname" => "数据类型",
            "description" => "栏目描述",
            "keywords" => "关键词",
            "seotitle" => "seo标题",
            "moresite" => "外部链接",
            "sitepath" => "网站路径",
            "ishidden" => "是否隐藏",
            "content" => "栏目介绍",
            "smalltypes" => "小栏目",
            "typename" => "栏目名称",
            "typedir" => "栏目生成文件夹",
            "modifyTime" => "修改时间",
            "hr1"=>"基本信息",
            "hr2"=>"SEO",
            "hr3"=>"其它",
            "hr4"=>"开发者"
        );
        $this->keyTypeList = array(
            "id" => "middleText",
            "reId" => "select",
            "topId" => "select",
            "sortrank" => "middleText",
            "isdefault" => "bool",
            "defaultname" => "middleText",
            "channeltype" => "select",
            "maxpage" => "middleText",
            "ispart" => "middleText",
            "corank" => "middleText",
            "tempindex" => "middleText",
            "templist" => "middleText",
            "temparticle" => "middleText",
            "namerule" => "middleText",
            "namerule2" => "middleText",
            "modname" => "middleText",
            "description" => "middleText",
            "keywords" => "middleText",
            "seotitle" => "middleText",
            "moresite" => "middleText",
            "sitepath" => "middleText",
            "ishidden" => "middleText",
            "content" => "middleText",
            "smalltypes" => "middleText",
            "typename" => "middleText",
            "typedir" => "middleText",
            "modifyTime" => "middleText",
            "hr1"=>"hrFirst",
            "hr2"=>"hr",
            "hr3"=>"hr",
            "hr4"=>"hr"
        );
        $this->keyVerifyList = array(
            "id" => "numeric",
            "reId" => "required",
            "topId" => "",
            "sortrank" => "",
            "isdefault" => "",
            "defaultname" => "",
            "channeltype" => "",
            "maxpage" => "",
            "ispart" => "",
            "corank" => "",
            "tempindex" => "",
            "templist" => "",
            "temparticle" => "",
            "namerule" => "",
            "namerule2" => "",
            "modname" => "",
            "description" => "",
            "keywords" => "",
            "seotitle" => "",
            "moresite" => "",
            "sitepath" => "",
            "ishidden" => "",
            "content" => "",
            "smalltypes" => "",
            "typename" => "required",
            "typedir" => "",
            "modifyTime" => "",
            "hr1"=>"",
            "hr2"=>"",
            "hr3"=>"",
            "hr4"=>""
        );
        //关键词模糊搜索 searchType = total   分词搜索  searchType = key
        //$this->searchType= 'key';
        $this->searchKey = array(
            "description",
            "keywords",
            "seotitle",
            "typename"
        );
        $this->keySqlType = array(
            "id" => "int",
            "reId" => "varchar",
            "topId" => "varchar",
            "sortrank" => "varchar",
            "isdefault" => "int",
            "defaultname" => "varchar",
            "channeltype" => "varchar",
            "maxpage" => "varchar",
            "ispart" => "varchar",
            "corank" => "varchar",
            "tempindex" => "varchar",
            "templist" => "varchar",
            "temparticle" => "varchar",
            "namerule" => "varchar",
            "namerule2" => "varchar",
            "modname" => "varchar",
            "description" => "varchar",
            "keywords" => "varchar",
            "seotitle" => "varchar",
            "moresite" => "varchar",
            "sitepath" => "varchar",
            "ishidden" => "varchar",
            "content" => "varchar",
            "smalltypes" => "varchar",
            "typename" => "varchar",
            "typedir" => "varchar",
            "modifyTime" => "varchar",
            "hr1"=>"varchar",
            "hr2"=>"varchar",
            "hr3"=>"varchar"
        );
        $this->keyImportant = array(
            "typename"
        );
        $this->detailKey = array(
            "hr1",
            "typename",
            "reId",
            "hr2",
            "seotitle",
            "keywords",
            "description",
            "hr3",
            "sortrank",
            "maxpage",
            "modifyTime"
        );
        $this->addKey = array(
            "hr1",
            "typename",
            "reId",
            "hr2",
            "seotitle",
            "keywords",
            "description",
            "hr3",
            "sortrank",
            "maxpage",
            "modifyTime"
        );
        $this->editKey = array(
            "hr1",
            "typename",
            "reId",
            "hr2",
            "seotitle",
            "keywords",
            "description",
            "hr3",
            "sortrank",
            "maxpage",
            "modifyTime"
        );
        $this->listKey = array(
            "id",
            "typename"
        );
        $this->keySelectData = array(
            "reId" => "",
            "topId" => "",
            "isdefault" => "",
            "channeltype" => ""
        );
        //关闭综合搜索
        $this->searchPageOpen = false;
        //关闭排序
        $this->listSortOpen = false;
        $this->load->model('CategoryData');
        $this->perPage = 1000;
        $this->orderBy = 'reId';
        $this->orderWay = 'desc';
        $this->listPage = 'category/list';
        $this->keyAddDefault = array(
            'reId' => 0,
            'topId' => 0,
            'sortrank' => 50,
            'isdefault' => 1,
            'defaultname' => 'index.html',
            'issend' => 1,
            'channeltype' => 'article',
            'maxpage' => 0,
            'tempindex' => 'type/index',
            'templist' => 'type/list',
            'temparticle' => 'type/article',
            'namerule' => '{typedir}/{Y}/{M}{D}/{aid}.html',
            'namerule2' => '{typedir}/list_{tid}_{page}.html',
            'description' => '',
            'keywords' => '',
            'seotitle' => '',
            'content' => ''
        );
        $this->load->model('CategoryData');
        $this->categorySelect = $this->CategoryData->sortSelect();
        $this->keySelectData['reId'] = $this->categorySelect;

        if(ENVIRONMENT === 'development'&&$this->usersystem->uid() == 1 && false){
            $this->detailKey = array_merge($this->addKey,$this->addOnKey);
            $this->addKey = $this->detailKey;
            $this->editKey =  $this->addKey;
        }
    }

    public $addOnKey = array(
        "hr4",
        "modname",
        "isdefault",
        "defaultname",
        "channeltype",
        "tempindex",
        "templist",
        "temparticle",
        "namerule",
        "namerule2",
        "moresite",
        "sitepath",
        "ishidden",
        "smalltypes",
        "typedir"
    );

    public function _setSelect(){

    }


    public function _beforeList(&$data){
        $topTypeList = array();
        if (is_array($data)) {
            foreach ($data as $each) {
                if ($each['reId'] != 0) {
                    continue;
                }
                $this->_typeTree($each, $data);
                $topTypeList[] = $each;
            }
        }

        $list = array();
        foreach($topTypeList as $each){
            $r =  $this->_getSon($each);
            $list = array_merge($list,$r);
        }
        $data = $list;

    }

    public function _getSon($data){
        $return = array();
        $return[] =  $data;
        if(isset($data['son']) && count($data['son'])>0){
            $son = array();
            foreach($data['son'] as $each){
                $son = array_merge($son,$this->_getSon($each));
            }
            foreach ($son as $k=>$v){
                $son[$k]['typename'] = "　".$son[$k]['typename'];
            }
            unset($data['son']);
            foreach($son as $each){
                $return[] = $each;
            }
        }



        return $return;

    }

    /*
	 * 在栏目列表里面寻找栏目的子栏目    按照深度优先 递归
	 */
    public function _typeTree(&$type, &$typeArray) {
        if (!isset($type['son'])) {
            $type['son'] = array();
        }

        foreach ($typeArray as $k => $v) {
            if ($v['reId'] == $type['id']) {
                unset($typeArray[$k]);
                $this->_typeTree($v, $typeArray);
                $type['son'][] = $v;
            }
        }
    }

}


?>
