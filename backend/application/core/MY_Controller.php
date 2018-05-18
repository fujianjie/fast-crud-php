<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 系统初始化加载器
 * 用于初始化系统所必须一些信息
 */
class MY_Controller extends CI_Controller {

        /**
         * 性能分析器开关
         */
        public static $profilerStatus = false;

        /**
         * 用户所属公司
         */
        public $cid;

        /**
         * 是否是API 模式
         */
        public $isApi = false;
        public $apiResponse = array(
            'status' => '',
            'msg' => '',
            'data' => array()
        );

        /**
         * 用于记录在日志中显示中文的具体操作名称
        */
        public $actionName = '';

        /**
         * 初始化
         */
        public function __construct() {
                parent::__construct();
                $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
                //加载系统必须的配置信息
                $this->load->model('Systemconfig');
                $this->load->model('LogData');
                $this->load->model('OperationHistoryData');
                $this->Systemconfig->load_settings(1);
                
                //加载库
                $this->load->library('Msg');
                $this->load->library('session');
                $this->load->library('UserSystem');

                if ($this->router->class !== 'login' && $this->input->post_get('token') === NULL) {
                        self::_checkUserLogin();
                        if ($this->config->item('resetPassword') == 'TRUE' && $this->usersystem->get('hasChange') == 0) {
                                $this->msg->to('login/resetPassword', '您需要重置密码');
                        }
                }


                if ($this->input->post_get('token') !== NULL) {
                        $token = $this->input->post_get('token');
                        $this->db->where('token', $token);
                        $this->db->where('expire >', time());
                        $this->db->limit(1);
                        $this->db->select('uid');
                        $query = $this->db->get('we_token');
                        $data = $query->row_array();

                        if ($data === NULL) {
                                $this->apiResponse['status'] = 'failed';
                                $this->apiResponse['msg'] = 'TOKEN错误';
                                echo json_encode($this->apiResponse);
                                die();
                        }
                        $this->isApi = true;
                        $this->usersystem->loadUser($data['uid']);
                }
                if ($this->usersystem->checkHasLogin()) {
                        $this->cid = $this->usersystem->get('companyId');
                }


                //性能分析
                $this->output->enable_profiler(self::$profilerStatus);
        }

        /**
         * 判断用户是否登录
         */
        private function _checkUserLogin() {
                if (!$this->usersystem->checkHasLogin()) {
                        $this->msg->to('login/index', '请先登录！');
                }
        }

        /**
         * 获取对象的所有属性
         */
        public function toArray($obj) {
                $_arr = is_object($obj) ? get_object_vars($obj) : $obj;
                foreach ($_arr as $key => $val) {
                        if (is_object($val)) {
                                unset($_arr[$key]);
                        }
                }
                return $_arr;
        }



}

?>