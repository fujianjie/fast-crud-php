<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * the start page of the site
 * need login
 *
 * @author jian-jie.fu <fulusu@vip.sina.com>
 */
class Site extends MY_Controller
{

    public function index()
    {
        if (isset($_SESSION['nowUrl'])) {
            $defaultUrl = $_SESSION['nowUrl'];
        } else {
            $defaultUrl = '/site/dashboard';
        }
        //$this->db->where('id!=1');
        //$this->db->where('pid!=1');

        $navData = $this->cache->get('navData');
        if ($navData === false) {
            $this->db->order_by('pid asc,sort desc');
            $this->db->where('isDelete', 0);
            $query = $this->db->get('nav');
            $navData = $query->result_array();
            $this->load->model('NavData');
            $navData = $this->NavData->_sonSort($navData);
            $this->cache->save('navData', $navData);
        }

        $this->_setNavAccess($navData);

        $this->load->view('site/index', array(
            'nowUrl' => $defaultUrl,
            'navData' => $navData
        ));
    }


    public function _setNavAccess(&$data)
    {

        if (count($data) > 0) {
            foreach ($data as $k => $parent) {
                $hasAccessLi = 0;
                if (isset($parent['son']) && count($parent['son']) > 0) {
                    foreach ($parent['son'] as $k1 => $son) {
                        if ($this->usersystem->checkHasAccess($son['access'])) {
                            $hasAccessLi++;
                        } else {
                            unset($data[$k]['son'][$k1]);
                        }
                    }
                }
                if ($hasAccessLi == 0) {
                    if ($parent['access'] != '' && $parent['url'] != '') {
                        if ($this->usersystem->checkHasAccess($parent['access'])) {

                        } else {
                            unset($data[$k]);
                        }
                    }
                    if ($parent['access'] == '' && $parent['url'] == '') {
                        unset($data[$k]);
                    }
                }
            }
        }
    }

    public function dashboard()
    {
        $this->load->view('site/dashboard');
    }

    public function setting()
    {
        $query = $this->db->get('nav');
        $navData = $query->result_array();
        $this->load->model('NavData');
        $navData = $this->NavData->_sonSort($navData);
        $this->_setNavAccess($navData);
        $this->load->view('site/setting', array(
            'navData' => $navData
        ));
    }

    public function session()
    {
        $sys = $this->usersystem->sys();

        if ($_SESSION[$sys]['isSuperAdmin']) {
            $this->load->view('site/session', array());
        } else {
            $this->msg->to('site/index');
        }
    }



}

?>