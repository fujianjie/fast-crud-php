<?php

/**
 * 信息跳转工具 
 */
class Msg {

        /**
         * 直接跳转信息提示在目的页显示
         * @param string $url   最终跳转的地址是 /$url
         * @param string $content 需要提示的内容
         * @param string $title 跳转需要提示的标题
         */
        public function to($url, $content = '', $title = '信息提示') {

                $CI = & get_instance();
                $sql = $CI->db->get_compiled_select();
                $CI->session->set_flashdata('Msg', array(
                    'content' => $content,
                    'title' => $title
                ));
                if(strpos($url,'/') === 0){
                         header('Location:' . $url);
                }else{
                         header('Location:/' . $url);
                }
                
        }

        /**
         * 带信息的中转跳转，会在跳转页停留指定时间
         */
        public function msgto() {
                
        }

        /**
         * 只显示一次的错误信息
         * 保存在session flash
         * @param $string  错误信息
         */
        public function error($msg) {
                $CI = & get_instance();
                $CI->session->set_userdata('errorInfo', $msg);
        }

        public function getError() {
                $CI = & get_instance();
                return $CI->session->get_userdata('errorInfo');
        }

        /**
         * 只显示一次的信息
         * 保存在session flash
         * @param $string  错误信息
         */
        public function success($msg) {
                $CI = & get_instance();
                $CI->session->set_userdata('success', $msg);
        }

        public function content($msg) {
                $CI = & get_instance();
                $CI->session->set_userdata('content', $msg);
        }

        public function info($msg) {
                self::content($msg);
        }

        public function unsetError() {
                $this->error('');
        }

}

?>