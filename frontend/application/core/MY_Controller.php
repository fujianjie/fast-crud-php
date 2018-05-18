<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 系统初始化加载器
 * 用于初始化系统所必须一些信息
 */
class MY_Controller extends CI_Controller
{

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
    public function __construct()
    {
        parent::__construct();
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
        //加载系统必须的配置信息
        $this->load->model('Systemconfig');
        $this->Systemconfig->load_settings(1);
        //加载库
        $this->load->library('Msg');
        $this->load->library('session');
        //性能分析
        $this->output->enable_profiler(self::$profilerStatus);
    }


    /**
     * 获取对象的所有属性
     */
    public function toArray($obj)
    {
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
