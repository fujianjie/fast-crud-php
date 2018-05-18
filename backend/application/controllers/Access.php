<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 导航信息控制器
 * @author jian-jie.fu <fulusu@vip.sina.com>
 */
class Access extends MY_Data
{

    public function __construct()
    {
        parent::__construct();
        $this->controllerName = '权限管理';
        $this->tableName = 'access';
        $this->keyNameList = array(
            'id' => '序号',
            'name' => '名称',
            'keyset' => '键值'
        );
        $this->keyTypeList = array(
            'id' => 'number',
            'name' => 'middleText',
            'keyset' => 'middleText'
        );
        $this->keyVerifyList = array(
            'id' => 'required|integer',
            'name' => 'required',
            'keyset' => 'required|alpha'
        );
        $this->searchType = 'total';
        $this->searchKey = array("name", "keyset");
        $this->keySqlType = array(
            'id' => 'int',
            'name' => 'varchar',
            'keyset' => 'varchar'
        );
        $this->keyImportant = array(
            'name'
        );
        $this->addKey = array(
            'name', 'keyset'
        );
        $this->editKey = array(
            'name', 'keyset'
        );
        $this->listKey = array('id', 'name', 'keyset');
        $this->removeOpen = true;
    }



}

?>