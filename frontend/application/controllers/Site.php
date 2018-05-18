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
        $this->load->view('site/index');
    }

}

?>
