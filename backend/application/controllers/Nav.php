<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 权限信息控制器
 * @author jian-jie.fu <fulusu@vip.sina.com>
 */
class Nav extends MY_Data
{

    public function __construct()
    {
        parent::__construct();
        $this->controllerName = '导航栏管理';
        $this->tableName = 'nav';
        $this->keyNameList = array(
            'id' => '序号',
            'name' => '名称',
            'iconClass' => '导航图标',
            'url' => '访问路径',
            'access' => '访问权限关键字',
            'pid' => '导航分类', //pid = 0  顶部分类
            'sort' => '排序'
        );
        $this->keyTypeList = array(
            'id' => 'number',
            'iconClass' => 'middleText',
            'name' => 'middleText',
            'url' => 'middleText',
            'access' => 'middleText',
            'pid' => 'select',
            'sort' => 'middleText'
        );

        $this->keyVerifyList = array(
            'id' => 'required|integer',
            'name' => 'required',
            'iconClass' => '',
            'url' => '',
            'access' => 'alpha',
            'pid' => 'required|integer',
            'sort' => 'integer'
        );
        $this->searchType = 'total';
        $this->searchKey = array("name", "url");
        $this->keySqlType = array(
            'id' => 'int',
            'name' => 'varchar',
            'url' => 'varchar',
            'access' => 'varvchar',
            'pid' => 'int',
            'iconClass' => 'varchar',
            'sort' => 'int'
        );
        $this->keyImportant = array(
            'name'
        );

        $this->addKey = array(
            'name', 'iconClass', 'url', 'access', 'pid', 'sort'
        );
        $this->load->model('NavData');
        $this->keySelectData['pid'] = $this->NavData->joinSelect('id', 'name', 'pid=0');
        $this->keySelectData['pid']['0'] = '顶层栏目';
        ksort($this->keySelectData['pid']);
        $this->orderBy = 'pid';
        $this->orderWay = 'asc';
        $this->perPage = 0;
        $this->listKey = array('id', 'name', 'url', 'access');
        $this->listNoBorder = false;
        $this->editKey = array('name', 'iconClass', 'url', 'access', 'pid', 'sort');
    }

    public function _beforeList(&$data)
    {
        parent::_beforeList($data);
        $data = $this->NavData->_arraySort($data);
    }

    public function _beforeAddSave(&$data)
    {
        parent::_beforeAddSave($data);
        $this->cache->delete('navData');
    }

    public function _beforeEditSave(&$data)
    {
        parent::_beforeEditSave($data);
        $this->cache->delete('navData');
    }

    public function _beforeRemove(&$data)
    {
        parent::_beforeRemove($data);
        $this->cache->delete('navData');
    }

    public function _beforeListQuery()
    {
        $this->db->order_by('id', 'asc');
    }

}

?>