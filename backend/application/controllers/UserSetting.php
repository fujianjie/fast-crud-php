<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * the start page of the site
 * need login
 *
 * @author jian-jie.fu <fulusu@vip.sina.com>
 */
class UserSetting extends MY_Controller
{

    public function index()
    {
        $this->changePass();
    }


    public function changePass()
    {
        $this->load->library('form_validation');
        $this->load->view('user/changepass');
    }

    public function information()
    {
        if ($this->isApi) {
            $json = array('status' => 'success', 'msg' => '', 'data' => array());
            $data = array(
                'userId' => $this->usersystem->uid(),
                'username' => $this->usersystem->get('account'),
                'realname' => $this->usersystem->get('realname'),
                'company' => '',
                'group' => '',
                'access' => ''
            );
            if ($this->usersystem->hasAccess('InspectionUser', $this->isApi, true) === true) {
                $sql = "select we_checkgroupuser.*, we_checkgroup.name as gname from we_checkgroup,we_checkgroupuser where we_checkgroupuser.userId = {$data['userId']} and we_checkgroupuser.groupId = we_checkgroup.id limit 1";
                $query = $this->db->query($sql);
                $queryData = $query->result_array();
                if (count($queryData) > 0) {
                    $queryData = $queryData[0];
                    $data['group'] = $queryData['gname'];
                    $data['access'] = $queryData['status'] == 1 ? '组长' : '组员';
                    $this->load->model('GuquanData');
                    $company = $this->GuquanData->getIdData($queryData['company']);
                    $data['company'] = $company['name'];
                }


            }
            $json['data'] = $data;
            echo json_encode($json);
            die();
        }

        $this->load->library('form_validation');
        $this->load->view('user/changeinfo', $this->usersystem->info());
    }

    public function doChangePass()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('oldpassword', 'oldpass', 'callback__password_check');
        $this->form_validation->set_rules('newpassword', 'password', 'callback__password_check');
        $this->form_validation->set_rules('password', 'password', 'callback__password_check');
        if ($this->form_validation->run() == FALSE) {
            $this->msg->error('您提交的密码错误');
            $this->msg->to('UserSetting/changePass', '');
        }
        $newpassword = $this->input->post('newpassword');
        $oldpassword = $this->input->post('oldpassword');
        $password = $this->input->post('password');
        $this->load->model('User');
        $data = $this->User->password($this->usersystem->uid());
        if ($this->usersystem->decrypt($data->password) != $oldpassword) {
            $this->msg->error('您提交的密码错误');
            $this->msg->to('UserSetting/changePass', '');
        }
        if ($newpassword != $password) {
            $this->msg->error('您提交的密码两次输入不一致');
            $this->msg->to('UserSetting/changePass', '');
        }
        $status = $this->usersystem->setNewPassword($newpassword);
        if ($status) {
            $this->msg->success('密码修改成功<script>parent.location.href="/site/index";</script>');
        } else {
            $this->msg->error('密码修改失败');
        }
        $this->msg->to('UserSetting/changePass', '');
    }

    public function _password_check($str, $errorMsg = TRUE)
    {
        if (!isPassword($str)) {
            if ($errorMsg) {
                $this->msg->error('请输入正确的密码');
            }
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function doChangeInfo()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'email', 'trim|required|valid_email');
        if ($this->form_validation->run() == FALSE) {
            $this->msg->error('您提交信息有误');
            $this->msg->to('UserSetting/information', '');
        }
        $email = $this->input->post('email');
        $realname = $this->input->post('realname');
        $this->load->model('User');
        $uid = $this->usersystem->uid();
        $this->db->where('id', $uid);
        $updateData = array(
            'email' => $email,
            'realname' => $realname
        );
        $status = $this->db->update('user', $updateData);
        if ($status) {
            $this->msg->success('修改成功<script>parent.location.href="/site/index";</script>');

            $this->usersystem->set('email', $email);
            $this->usersystem->set('realname', $realname);
        } else {
            $this->msg->error('修改失败');
        }
        $this->msg->to('UserSetting/information', '');
    }

}

?>