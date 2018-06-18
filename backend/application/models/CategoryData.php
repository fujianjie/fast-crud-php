<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 数据模型说明
 * 栏目管理
 * @author jian-jie.fu <fulusu@vip.sina.com>
 * @addTime  2018-06-05 09:20:15
 */
class CategoryData extends MY_Model {

	public $tableName = 'we_category';

	public function __construct() {
		parent::__construct();
	}

	public function sortSelect(){
	    $list =  $this->sortCategory();
	    $select = array();
	    foreach($list as $k=>$each){
	        $select[$each['id']] = $each['typename'];
        }
        return $select;
    }

	public function sortCategory(){

        $cacheKey = $this->tableName . '__sortCategory' ;
        $result = $this->cache->get($cacheKey);
        if($result !== false){
            return $result;
        }

	    $data =  $this->getAll(1000);
        if (is_array($data)) {
            foreach ($data as $each) {
                if ($each['reId'] != 0) {
                    continue;
                }
                $this->_typeTree($each, $data);
                $topTypeList[] = $each;
            }
        }

        $list = array();
        foreach($topTypeList as $each){
            $r =  $this->_getSon($each);
            $list = array_merge($list,$r);
        }
        $this->cache->save($cacheKey, $list);
        return $list;
    }

    public function _getSon($data){
        $return = array();
        $return[] =  $data;
        if(isset($data['son']) && count($data['son'])>0){
            $son = array();
            foreach($data['son'] as $each){
                $son = array_merge($son,$this->_getSon($each));
            }
            foreach ($son as $k=>$v){
                $son[$k]['typename'] = "　".$son[$k]['typename'];
            }
            unset($data['son']);
            foreach($son as $each){
                $return[] = $each;
            }
        }



        return $return;

    }

    /*
	 * 在栏目列表里面寻找栏目的子栏目    按照深度优先 递归
	 */
    public function _typeTree(&$type, &$typeArray) {
        if (!isset($type['son'])) {
            $type['son'] = array();
        }

        foreach ($typeArray as $k => $v) {
            if ($v['reId'] == $type['id']) {
                unset($typeArray[$k]);
                $this->_typeTree($v, $typeArray);
                $type['son'][] = $v;
            }
        }
    }

}

 ?>
