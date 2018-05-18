<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * system config model
 * 系统配置数据模块
 * 用于提供配置整个站点的信息模块的数据对象
 */
class Systemconfig extends CI_Model {

        public function __construct() {
                parent::__construct();
               
        }

        /**
         * 获取指定类型的系统配置，在数据库读取以后保存到系统配置里面去
         * @param int $basic 0 非必须的系统参数 | 1 必须的系统参数
         */
        public function load_settings($basic = 0) {
                $data = $this->cache->get('Systemconfig');
                if ($data === false) {
                        $this->db->select('name, content');
                        $this->db->where('basic', 1);
                        $this->db->order_by('sort', 'ASC');
                        $this->db->from('systemconfig');
                        $query = $this->db->get();
                        $data = $query->result_array();
                        $this->cache->save('Systemconfig',$data);
                }
                
                foreach ($data as $row) {
                        $this->config->set_item($row['name'], $row['content']);
                }
        }

}

?>