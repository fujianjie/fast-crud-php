<?php 
/*
{"line":[{"colName":"date","colComment":"日期","dataType":"date","verify":[]},{"colName":"filename","colComment":"文件名","dataType":"middleText","verify":[]},{"colName":"addTime","colComment":"添加时间","dataType":"timestamp","verify":[]},{"colName":"uid","colComment":"用户","dataType":"shortText","verify":[]},{"colName":"cid","colComment":"公司","dataType":"shortText","verify":[]},{"colName":"sourcename","colComment":"原文件名","dataType":"middleText","verify":[]}],"total":{"detailKey[]":["date","filename","addTime","uid","cid","sourcename"],"listKey[]":["date","filename","addTime","sourcename"],"searchKey[]":["sourcename"],"keyImportant[]":["sourcename"]}}
*/
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 数据模型说明
 * 文件存储信息
 * @author jian-jie.fu <fulusu@vip.sina.com>
 * @addTime  2016-11-23 01:42:35
 */
class FilesData extends MY_Model {

	public $tableName = 'we_files';

	public function __construct() {
		parent::__construct();
	}
	
	public function addFile($filename,$source,$date=''){
		if(empty($date)){
			$date = date("Y-m-d");
		}
		$saveData = array(
			"date"=>$date,
			'filename'=>$filename,
			'sourcename'=>$source,
			'cid'=>$this->cid,
			'uid'=>$this->usersystem->get('id')
		);
		$query = $this->db->insert($this->tableName, $saveData);
	}
	
	public function sourcename ($filepath){
		if(empty($filepath)){
			return  '';
		}
		$p = pathinfo($filepath);
		$this->db->where('filename',$p['basename']);
		$this->db->where('date',  str_replace('/uploads/', '', $p['dirname']));
		$this->db->select('sourcename');
		$this->db->limit(1);
		$query =  $this->db->get($this->tableName);
		$data =  $query->row_array();
		if(!empty($data)){
			return $data['sourcename'];
		}
		return '';
	}
	
}

 ?>