<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 导航信息控制器
 * @author jian-jie.fu <fulusu@vip.sina.com>
 */
class UserGroup extends MY_Data
{


    public function __construct()
    {
        parent::__construct();
        $this->controllerName = '角色管理';
        $this->tableName = 'we_group';
        $this->keyNameList = array(
            'id' => '序号',
            'name' => '用户组名称',
            'access' => '组权限',
            'keyname' => '组关键字',

        );
        $this->keyTypeList = array(
            'id' => 'number',
            'name' => 'middleText',
            'access' => 'checkbox',
            'keyname' => 'middleText',
            'hr' => 'hrFirst',
            'hr1' => 'hr'
        );

        $this->keyVerifyList = array(
            'id' => 'required|integer',
            'name' => 'required',
            'access' => 'required',
            'keyname' => 'alpha',
        );
        $this->searchType = 'total';
        $this->searchKey = array("name");
        $this->keySqlType = array(
            'id' => 'int',
            'name' => 'varchar',
            'access' => 'varchar',
            'keyname' => 'varchar'
        );

        $this->keyImportant = array(
            'name'
        );

        $this->addKey = array(
            'name', 'access'
        );
        $this->editKey = array('name', 'access');
        $this->listKey = array('id', 'name');
        $this->listNoBorder = false;
        $this->load->model('AccessData');
        $this->keySelectData['access'] = $this->AccessData->joinSelect('keyset', 'name', "", 'keyset', 'DESC');

        
        if (count($this->keySelectData['access']) > 0) {
            foreach ($this->keySelectData['access'] as $k => $v) {
                if ($k == '') {
                    continue;
                }
                if (!$this->usersystem->checkHasAccess($k)) {
                    unset($this->keySelectData['access'][$k]);
                }
            }
        }
    }


    public function _beforeAdd(&$data)
    {
        parent::_beforeAdd($data);
        $data['keySelectData']['access'] = $this->_reFormatAccess();
        $data['keyTypeList']['access'] = 'groupCheckbox';
    }

    public function _beforeEdit(&$data)
    {
        parent::_beforeEdit($data);
        $data['keySelectData']['access'] = $this->_reFormatAccess();
        $data['keyTypeList']['access'] = 'groupCheckbox';
    }

    public function _reFormatAccess()
    {
        /*
         * array(
         *       'groupName'=>array(
         *               'key'=>value
         *       )
         * )
         */
        $accessArray = $this->keySelectData['access'];

        $this->db->from("nav");
        //$this->db->where('isDelete',0);
        $query = $this->db->get();
        $data = $query->result_array();
        $groupKey = array();
        $topNav = array();
        if (count($data) > 0) {
            foreach ($data as $each) {
                if ($each['pid'] == 0) {
                    $topNav[] = $each;
                    $groupKey[$each['id']] = array(
                        'key' => array(),
                        'name' => $each['name'],
                        'data' => array()
                    );
                }
            }

            $groupKey['other'] = array(
                'key' => array(),
                'name' => '其它权限',
                'data' => array()
            );

            foreach ($data as $each) {
                if ($each['pid'] == 0 && $each['access'] == '') {
                    continue;
                }


                $accessName = $each['access'];
                $accessName = str_replace('view', '', $accessName);
                $accessName = str_replace('opt', '', $accessName);
                $accessName = str_replace('del', '', $accessName);
                if (count($accessArray) > 0) {
                    foreach ($accessArray as $k => $v) {
                        if (!empty($accessName) && strpos($k, $accessName) === 0 && $k != '') {
                            if ($each['pid'] != 0) {
                                $id = $each['pid'];
                            } else {
                                $id = $each['id'];
                            }
                            $groupKey[$id]['data'][$k] = $v;
                            $groupKey[$id]['key'] [] = $k;
                        }else{
                        }
                    }
                }
            }


            foreach ($groupKey as $k => $v) {
                if (empty($v['data']) && $k != 'other') {
                    unset($groupKey[$k]);
                }
            }
        }

        $this->keySelectData['access'] = $groupKey;
        return $groupKey;
    }

}

?>