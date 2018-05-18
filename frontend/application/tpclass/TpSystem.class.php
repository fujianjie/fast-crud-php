<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * TpSystem
 * 用于获取systemconfig表中的系统配置信息
 * 以Tp 为前缀的对象都是用于在模板层面的各种调用
 */
class TpSystem {

        /**
         * 获取指定的键值
         * @param string $key
         * @return string 
         */
        static public function getParam($key) {
                if(!isset($_SESSION['systemConfig'])){
                        $_SESSION['systemConfig'] = array();
                }
                
                if(isset( $_SESSION['systemConfig'][$key])){
                        return  $_SESSION['systemConfig'][$key];
                }
                
                $CI = & get_instance();
                $value = $CI->config->item($key);
                if ($value !== NULL) {
                        $_SESSION['systemConfig'][$key] = $value;
                        return $value;
                }
               // $CI->load->model('Systemconfig');
                return NULL;
        }

        /**
         * 获取用户SESSION 里面信息
         */
        static public function getSession($key) {
                if (isset($_SESSION['UserSystem']['UserInfo'][$key])) {
                        return $_SESSION['UserSystem']['UserInfo'][$key];
                } else {
                        return '';
                }
        }

}

?>