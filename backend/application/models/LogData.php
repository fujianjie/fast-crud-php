<?php
/*
{"line":[{"colName":"uid","colComment":"用户","dataType":"number","verify":[]},{"colName":"addTime","colComment":"操作时间","dataType":"timestamp","verify":[]},{"colName":"classAndMethod","colComment":"页面","dataType":"middleText","verify":[]},{"colName":"actionName","colComment":"操作内容","dataType":"middleText","verify":[]},{"colName":"paramsData","colComment":"参数","dataType":"textarea","verify":[]},{"colName":"ip","colComment":"IP地址","dataType":"middleText","verify":[]},{"colName":"html","colComment":"页面显示内容","dataType":"textarea","verify":[]}],"total":{"addKey[]":["uid","addTime","classAndMethod","actionName","paramsData","ip","html"],"detailKey[]":["uid","addTime","classAndMethod","actionName","paramsData","ip","html"],"searchKey[]":["uid","classAndMethod","actionName","paramsData","ip"],"listKey[]":["uid","addTime","classAndMethod","actionName","ip"]}}
*/
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 数据模型说明
 * 系统日志
 * @author jian-jie.fu <fulusu@vip.sina.com>
 * @addTime  2017-06-12 02:18:09
 */
class LogData extends MY_Model
{

    public $tableName = 'we_log';

    public function __construct()
    {
        parent::__construct();
    }

    public function saveData($actionName = '', $html = '')
    {
        if(ENVIRONMENT === 'development'){
            return;
        }
        $this->load->library('UserSystem');

        if ($this->usersystem->checkHasLogin()) {
            $uid = $this->usersystem->uid();
            $realname = $this->usersystem->get('realname');
            $mobile = $this->usersystem->get('mobile');
        } else {
            $uid = 0;
            $realname = '';
            $mobile = '';
        }

        $class = $this->router->class;
        $method = $this->router->method;

        $classAndMethod = $class.'-'.$method;
        $keyParam = '';
        if ($this->input->post_get('id') !== null) {
            $keyParam = (int)$this->input->post_get('id');
        }
        if (empty($keyParam) && $this->input->post_get('sn') !== null) {
            $keyParam = $this->input->post_get('sn');
        }


        $ip = $this->input->ip_address();

        $request = array_merge($_POST, $_GET);


        $saveData = array(
            'uid' => $uid,
            'realname' => $realname,
            'mobile' => $mobile,
            'classAndMethod' => $classAndMethod,
            'actionName' => $actionName,
            'paramsData' => json_encode($request),
            'ip' => $ip,
            'keyParam'=>$keyParam,
            'html' => $html,
            'addTime' =>  date('Y-m-d h:i:s')
        );

        $this->db->insert($this->tableName,$saveData);

    }

}

?>
