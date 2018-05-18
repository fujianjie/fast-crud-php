<?php

/*
 * Setting Data
  {"line":[{"colName":"account","colComment":"用户帐号","dataType":"middleText","verify":["required","checkMobile"]},{"colName":"password","colComment":"用户密码","dataType":"middleText","verify":["required"]},{"colName":"realname","colComment":"姓名","dataType":"middleText","verify":[]},{"colName":"email","colComment":"邮箱","dataType":"shortText","verify":["valid_email"]},{"colName":"mobile","colComment":"手机","dataType":"middleText","verify":["checkMobile"]},{"colName":"status","colComment":"状态","dataType":"shortText","verify":[]},{"colName":"uuid","colComment":"","dataType":"longText","verify":[]},{"colName":"group","colComment":"用户组","dataType":"shortText","verify":["required"]},{"colName":"hasChange","colComment":"是否修改过密码","dataType":"shortText","verify":[]},{"colName":"companyId","colComment":" 公司ID","dataType":"shortText","verify":[]}],"total":{"addKey[]":["account","password","realname","email","mobile","status","uuid","group","hasChange","companyId"],"detailKey[]":["account","password","realname","email","mobile","status","uuid","group","hasChange","companyId"],"editKey[]":["account","password","realname","email","mobile","status","uuid","group","hasChange","companyId"],"listKey[]":["account","password","realname","email","mobile","status","uuid","group","hasChange","companyId"],"keyImportant[]":["account"],"keyVerify[]":["required","checkMobile","required","valid_email","checkMobile","required"]}}
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 全局用户管理
 * @author jian-jie.fu <fulusu@vip.sina.com>
 * @addTime  2016-11-14 06:09:56
 */
class UserManagement extends MY_Data
{


    public function __construct()
    {
        parent::__construct();
        $this->removeOpen = true;
        $this->controllerName = '用户管理';
        $this->tableName = 'we_user';
        $this->keyNameList = array("id" => "序号",
            "account" => "用户帐号",
            "password" => "用户密码",
            "realname" => "姓名",
            "email" => "邮箱",
            "mobile" => "手机",
            "status" => "状态",
            "uuid" => "用户UUID",
            "group" => "用户组",
            "hasChange" => "是否修改过密码",
            "passwordAgain" => "再次输入密码",
            'resetPassword' => "重置密码");
        $this->keyTypeList = array("id" => "middleText",
            "account" => "showText",
            "passwordAgain" => "middleText",
            "password" => "middleText",
            "realname" => "middleText",
            "email" => "middleText",
            "mobile" => "middleText",
            "status" => "bool",
            "uuid" => "longText",
            "group" => "select",
            "hasChange" => "bool",
            "resetPassword" => 'bool');
        $this->keyVerifyList = array("id" => "numeric",
            "account" => "checkMobile|is_unique[we_user.mobile]|required",
            "password" => "",
            "realname" => "",
            "email" => "valid_email",
            "mobile" => "checkMobile|is_unique[we_user.mobile]|required",
            "status" => "",
            "uuid" => "",
            "group" => "required",
            "hasChange" => "",
            "resetPassword" => '');
        $this->searchKey = array("mobile", "realname", "account", "email", "uuid");
        $this->keySqlType = array("id" => "int",
            "account" => "varchar",
            "password" => "varchar",
            "realname" => "varchar",
            "email" => "varchar",
            "mobile" => "varchar",
            "status" => "varchar",
            "uuid" => "varchar",
            "group" => "varchar",
            "hasChange" => "varchar");
        $this->keyImportant = array("account");
        $this->detailKey = array("account",
            "realname",
            "email",
            "mobile",
            "status",
            "uuid",
            "group",
            "hasChange");
        $this->addKey = array(
            "mobile",
            "realname",
            'email',
            "group");
        $this->editKey = array(
            "realname",
            "email",
            "status",
            'resetPassword',
            "group");
        $this->listKey = array("id",
            "realname",
            "group",
            "mobile",
            "email",
            "status");
        $this->load->model('Group');
        $this->keySelectData['group'] =  $this->Group->joinSelect('id','name');
        $this->keySelectData['status'] = array(0 => '禁止', 1 => '开启');
        $this->keySelectData['hasChange'] = array(0 => '否', 1 => '是');
    }

    private $defaultPassword = '!qazXSW23edc';

    public function _beforeAdd(&$data)
    {
        parent::_beforeAdd($data);
        $this->msg->content('默认密码为: &nbsp;' . $this->defaultPassword);
    }


    public function _beforeAddSave(&$data)
    {
        parent::_beforeAddSave($data);
        $data['status'] = 1;
        $data['password'] = $this->usersystem->encrypt($this->defaultPassword);
        $this->load->model('User');
        $info = $this->User->checkMobile($data['mobile']);
        if (!empty($info) || count($info) > 0) {
            $this->msg->error('该手机号码已存在');
            $this->msg->to($this->router->class . '/add');
            die;
        }
        if ($this->usersystem->uid() != 1) {
            if (!isset($this->keySelectData['group'][$data['group']])) {
                $this->msg->error('您没有权限将用户加入这个用户组');
                $this->msg->to($this->router->class . '/index');
                die;
            }
        }
     
        $this->load->library('Uuid');
        $data['uuid'] = $this->uuid->create();
        $data['account'] = $data['mobile'];
    }

    public function _beforeEditSave(&$data)
    {
        parent::_beforeEditSave($data);
        if ($this->usersystem->uid() != 1) {
            if (!isset($this->keySelectData['group'][$data['group']])) {
                $this->msg->error('您没有权限将用户加入这个用户组');
                $this->msg->to($this->router->class . '/index');
                die;
            }
        }

        if ($data['resetPassword'] == 1) {
            $data['password'] = $this->usersystem->encrypt($this->defaultPassword);
            $data['hasChange'] = 0;
            $this->msg->content('用户' . $data['realname'] . ' 新密码为: &nbsp;' . $this->defaultPassword);
        }
        unset($data['resetPassword']);
    }

    public function changeUser()
    {
        $sys = $this->usersystem->sys();
        if (!$_SESSION[$sys]['isSuperAdmin']) {
            $this->msg->error('您没有使用用户切换功能的权限');
            $this->msg->to($this->router->class . '/index');
            die;
        }
        $userModel = $this->load->model('User');
        $this->usersystem->userInfo = $this->User->id($this->input->get('id'));
        $this->usersystem->login();
        unset($_SESSION['urlHistory']);
        $this->msg->to('userManagement/index');
    }

    public function _beforeList(&$data)
    {
        if (count($data) > 0) {
            foreach ($data as $each) {
                $a = '';
                if (!empty($each)) {
                    $a = "<a title=\"角色变更\" href=\"/{$this->router->class}/changeUser?id={$each['id']}\" class=\"btn btn-default\"><span class=\"glyphicon glyphicon-change\"></span></a>";
                }
                $this->addonButton[$each['id']] = $a;
            }
        }
    }

    public function _setListViewData(&$viewData)
    {
        $viewData['addonButton'] = $this->addonButton;
    }
}

?>