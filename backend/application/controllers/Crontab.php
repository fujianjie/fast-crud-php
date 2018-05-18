<?php

/**
 * Created by PhpStorm.
 * User: fighterblue1228
 * Date: 2017/3/29
 * Time: 下午5:33
 *
 *
 * 0 2 * * * wget -O http://happy.we-ideas.com/crontab/index
 * 用于轮循器定期运行的程序
 */
class Crontab extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
        $this->load->model('Systemconfig');
        $this->Systemconfig->load_settings(1);
    }

    public function index()
    {
        ob_start();

        $data = ob_get_contents();
        $this->_writeFile($data);
        $this->cache->clean();
        ob_flush();
    }

    public function _writeFile($data)
    {
        $logPath = APPPATH . '/logs/' . date('Y-m-d') . '.txt';
        file_put_contents($logPath, $data, FILE_APPEND);
    }


}
