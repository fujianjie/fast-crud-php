<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * the Login Part
 * @author jian-jie.fu <fulusu@vip.sina.com>
 */
class Login extends MY_Controller {

    //cookie 生存期 (四周)
    static $cookieLife = 2419200;

    public function __construct() {
        parent::__construct();
    }

    public static $rootFilePath = 'config/.hasAdmin';

    /**
     * 判断是否已有超级管理员用户
     * 通过两重方式 1.判断有没有.hasAdmin文件 2.判断数据库用户数量是否为0
     * @return bool
    */
    public function _hasRoot(){
        $status =  file_exists(APPPATH.self::$rootFilePath);
        if($status === false){
            $this->load->model('User');
            $num = $this->User->getCount();
            if($num === 0){
                return false;
            }
        }
        return true;
    }

    public function _setRoot($mobile,$password){

    }

    /**
     * 用于创建超级管理员用户
    */
    public function doCreatRoot(){

        if($this->_hasRoot()){
            $this->msg->to('login/index', '请先登陆');
            die();
        }

        $this->load->library('form_validation');
        $this->load->library('Uuid');
        $this->form_validation->set_rules('username', 'username', 'callback__username_check');
        $this->form_validation->set_rules('password', 'password', 'callback__password_check');
        $this->form_validation->set_rules('newpassword', 'newpassword', 'callback__password_check');
        $password = $this->input->post('password');
        $newpassword = $this->input->post('newpassword');

        if ($newpassword !== $password) {
            $this->msg->error('两次密码输入不一致');
            $this->msg->to('login/index', '');
            die();
        }
        if ($this->form_validation->run() == FALSE ) {
            $this->msg->to('login/index', '');
            die();
        }

        $username = $this->input->post('username');
        $data = array(
            'account'=>$username,
            'password'=>$this->usersystem->encrypt($password),
            'uuid'=>$this->uuid->create(),
            'realname'=>"超级管理员",
            'mobile'=>$username,
            'hasChange'=>1,
            'group'=>1,
            'status'=>1
        );
        $status = $this->db->insert('we_user', $data);
        if($status){
            file_put_contents(APPPATH.self::$rootFilePath,'1');
            $this->msg->error('超级管理员创建成功');
        }

        $this->msg->to('login/index', '');

    }

    /**
     * 登录页
     */
    public function index() {
        if ($this->usersystem->checkHasLogin()) {
            $this->msg->to('site/index', '您已经登录');
        }
        $this->_cookie_login();
        $this->load->library('form_validation');
        if($this->_hasRoot()){
            $this->load->view('login/index');
        }else{
            $this->load->view('login/reg');
        }
    }

    /**
     * 登出
     */
    public function logout() {
        $this->usersystem->logout();
        $this->msg->to('login/index', '您已经登出');
    }

    /**
     * 重置密码
     * 登陆前界面
     */
    public function resetPassword() {
        if (!$this->usersystem->checkHasLogin()) {
            $this->msg->to('login/index', '请先登陆');
        }
        if ($this->config->item('resetPassword') != 'TRUE') {
            $this->msg->to('site/index', '首次登陆系统修改密码已经关闭');
        }
        if ($this->usersystem->get('hasChange') == 1) {
            $this->msg->to('site/index', '请到设定中修改密码');
        }

        $this->load->view('login/resetPassword');
    }

    /**
     * 重置密码
     * 数据提交
     */
    public function doResetPassword() {
        if (!$this->usersystem->checkHasLogin()) {
            $this->msg->to('login/index', '请先登陆');
        }
        $this->load->library('form_validation');
        $this->form_validation->set_rules('password', 'password', 'callback__password_check');
        $this->form_validation->set_rules('newpassword', 'newpassword', 'callback__password_check');
        if ($this->form_validation->run() == FALSE) {
            $this->msg->error('输入错误');
            $this->msg->to('login/resetPassword', '');
        }
        $password = $this->input->post('password');
        $newpassword = $this->input->post('newpassword');
        if ($newpassword !== $password) {
            $this->msg->error('两次密码输入不一致');
            $this->msg->to('login/resetPassword', '');
        }
        if ($this->usersystem->setNewPassword($newpassword)) {
            $this->msg->to('site/index', '密码修改成功！');
        }
    }

    /**
     * 判断登录
     */
    public function doLogin() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'username', 'callback__username_check');
        $this->form_validation->set_rules('password', 'password', 'callback__password_check');
        if ($this->form_validation->run() == FALSE) {

            $this->msg->to('login/index', '请先登录');
        }
        if ($this->usersystem->checkHasLogin()) {
            $this->msg->to('site/index', '您已经登录');
        }
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        if ($this->usersystem->verifyUser($username, $password)) {
            $this->usersystem->login();

            if ($this->input->post('remember') == 1) {
                $this->load->helper('cookie');
                set_cookie('username', $username, time() + self::$cookieLife);
                set_cookie('password', urlencode($password), time() + self::$cookieLife);
            }
            $this->msg->to('site/index', '登录成功');
        } else {
            $this->msg->error('用户名或密码错误');
            $this->msg->to('login/index', '');
        }
    }

    /**
     * cookie 登录
     */
    public function _cookie_login() {
        $username = $this->input->cookie('username');
        $password = $this->input->cookie('password');
        $this->load->helper('cookie');
        if ($this->_username_check($username, FALSE) && $this->_password_check($password, FALSE)) {
            if ($this->usersystem->verifyUser($username, $password)) {
                $this->usersystem->login();
                $this->msg->to('site/index', '登录成功');
            } else {
                delete_cookie('username');
                delete_cookie('password');
            }
        }
    }

    public function _username_check($str, $errorMsg = TRUE) {
        if (!isMobile($str)) {
            if ($errorMsg) {
                $this->msg->error('请输入正确的手机号码');
            }

            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function _password_check($str, $errorMsg = TRUE) {
        if (!isPassword($str)) {
            if ($errorMsg) {
                $this->msg->error('请输入正确的密码');
            }
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function apiDocument() {
        $this->load->view('api/document');
    }

    public function apiLogin() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('username', 'username', 'callback__username_check');
        $this->form_validation->set_rules('password', 'password', 'callback__password_check');
        $json = array(
            'status' => '',
            'msg' => '',
            'data' => array()
        );
        if ($this->form_validation->run() == FALSE) {
            $json['status'] = 'failed';
            $json['msg'] = '提交数据验证失败';
            echo json_encode($json);
            die();
        }
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        if ($this->usersystem->verifyUser($username, $password)) {
            $userInfo = (array) $this->usersystem->userInfo;

            $json['status'] = 'success';
            $json['data']['token'] = md5($userInfo['id'] . date('Y-m-d'));
            $json['data']['expire'] = strtotime(date("Y-m-d") . ' 23:59:59');
            $json['data']['mobile'] = $userInfo['mobile'];
            $json['data']['realname'] = $userInfo['realname'];
            $save = array(
                'uid' => $userInfo['id'],
                'expire' => $json['data']['expire'],
                'token' => $json['data']['token']
            );
            $this->db->replace('we_token', $save);
            echo json_encode($json);
            die();
        } else {
            $json['status'] = 'failed';
            $json['msg'] = '用户名或密码错误';
            echo json_encode($json);
            die();
        }
    }

}

?>
