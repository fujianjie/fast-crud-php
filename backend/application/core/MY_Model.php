<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 数据模型对象
 * 增加一系列需要的方法
 */
class MY_Model extends CI_Model {

        public $tableName = '';

        /**
         * 系统CID 所属公司关联
         */
        public $cid = false;
        public $cidName = 'cid';
        
        public $hasCache = false;

        public $isDelete = 'isDelete';

        /**
         * 通过指定查询方式生成用于SELECT 表单的数据
         */
        public function joinSelect($kName = 'id', $vName = 'name', $where = '', $orderKey = '', $orderBy = 'ASC', $limitFrom = 0, $limitRow = '') {


                $this->db->select($kName);
                if (is_array($vName)) {
                        foreach ($vName as $each) {
                                $this->db->select($each);
                        }
                } else {
                        $this->db->select($vName);
                }
                $this->db->where($this->tableName . '.'.$this->isDelete, 0);
                if ($where) {
                        if (is_array($where)) {
                                foreach ($where as $each) {
                                        $this->db->where($each);
                                }
                        } else {
                                $this->db->where($where);
                        }
                }
                
                if ($orderKey) {
                        $this->db->order_by($orderKey, $orderBy);
                }
                if ($limitRow) {
                        if ($limitFrom) {
                                $this->db->limit($limitFrom, $limitRow);
                        } else {
                                $this->db->limit($limitRow);
                        }
                }
                $this->db->from($this->tableName);
                $sql = $this->db->get_compiled_select();
                $cacheKey = md5($sql);
                $data = $this->cache->get($cacheKey);
                if ($data === false) {
                        $query = $this->db->query($sql);
                        $data = $query->result_array();
                        $status = $this->cache->save($cacheKey, $data);
                }
                $tmp = array();
                if (count($data) > 0) {
                        foreach ($data as $row) {
                                if (is_array($vName)) {
                                        $str = '';
                                        foreach ($vName as $each) {
                                                $str .= $row[$each] . '  ';
                                        }
                                        $tmp[$row[$kName]] = $str;
                                } else {
                                        $tmp[$row[$kName]] = $row[$vName];
                                }
                        }
                }
                return $tmp;
        }

        /**
         * 通过指定SQL方式生成用于SELECT 表单的数据
         */
        public function joinSelectQuery($sql, $kName, $vName) {
               $this->db->from($this->tableName);
                $query = $this->db->get($sql);
                $tmp = array();
                foreach ($query->result_array() as $row) {
                        $tmp[$row[$kName]] = $row[$vName];
                }
                return $tmp;
        }

        /**
         * 检查指定字段的输入 的内容是否唯一
         */
        public function checkUnique($key, $value) {
                $this->db->select('count(1) as total');
                $this->db->limit(1);
                $this->db->where($key, $value);

                $query = $this->db->get($this->tableName);
                $row = $query->row_array();

                if ($row['total'] == 0) {
                        return true;
                } else {
                        return false;
                }
        }

        /**
         * 通过ID 获得数据
         */
        public function getIdData($id, $kname = 'id') {
                $this->db->from($this->tableName);
                $this->db->where($this->tableName . '.'.$this->isDelete, 0);
                $this->db->where($kname, $id);
                $this->db->limit(1);
                $sql = $this->db->get_compiled_select();
                $cacheKey = $this->tableName . '__' . md5($sql);
                $result = $this->cache->get($cacheKey);
                if ($result === false||!$this->hasCache) {
                        $query = $this->db->query($sql);
                        $result = $query->row_array();
                        $this->cache->save($cacheKey, $result);
                }
                return $result;
                //$query = $this->db->get();
                //return $query->row_array();
        }

        /**
         * 通过一个字段搜索获取所有数据
         */
        public function getData($key, $value, $limit = NULL) {
                $this->db->from($this->tableName);
                $this->db->where($this->tableName . '.'.$this->isDelete, 0);
                $this->db->where($key, $value);
                if ($limit !== NULL) {
                        $this->db->limit($limit);
                }
                $sql = $this->db->get_compiled_select();
                $cacheKey = $this->tableName . '__' . md5($sql);
                $result = $this->cache->get($cacheKey);
                if ($result === false||!$this->hasCache) {
                        $query = $this->db->query($sql);
                        $result = $query->result_array();
                        $this->cache->save($cacheKey, $result);
                }
                return $result;
                //$query = $this->db->get();
                //return $query->result_array();
        }

        public function getAll($limit = 50) {
                $this->db->where($this->tableName . '.'.$this->isDelete, 0);
                $this->db->from($this->tableName);
                $this->db->limit($limit);
                $sql = $this->db->get_compiled_select();
                $cacheKey = $this->tableName . '__' . md5($sql);
                $result = $this->cache->get($cacheKey);
                if ($result === false||!$this->hasCache) {
                        $query = $this->db->query($sql);
                        $result = $query->result_array();
                        $this->cache->save($cacheKey, $result);
                }
                return $result;
                //$query = $this->db->get();
                //return $query->result_array();
        }

        /**
         * 取数据表的单条记录的单个字段
         * @param $keyName  列名
         * @param $key  搜索条件`
         * @param $value 搜索条件内容
         * @return string | null
         */
        public function getKey($keyName, $key, $value) {
                $this->db->from($this->tableName);
                $this->db->where($this->tableName . '.'.$this->isDelete, 0);
                $this->db->where($key, $value);
                $this->db->limit(1);
                $sql = $this->db->get_compiled_select();
                $cacheKey = $this->tableName . '__' . md5($sql);
                $result = $this->cache->get($cacheKey);
                if ($result === false) {
                        $query = $this->db->query($sql);
                        $result = $query->result_array();
                        $this->cache->save($cacheKey, $result);
                }
                if (isset($result[0]) && isset($result[0][$keyName])) {
                        return $result[0][$keyName];
                } else {
                        return null;
                }
        }
        
        public function getCount($key,$value){
                $this->db->from($this->tableName);
                $this->db->where($this->tableName . '.'.$this->isDelete, 0);
                $this->db->where($key, $value);
               return  $this->db->count_all_results();
        }

}

?>