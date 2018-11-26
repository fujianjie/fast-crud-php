<?php 
/*
{"line":[{"colName":"typeid","colComment":"所属栏目id","dataType":"select","verify":["required"]},{"colName":"sortrank","colComment":"栏目排序序号","dataType":"shortText","verify":[]},{"colName":"click","colComment":"文章点击数","dataType":"shortText","verify":[]},{"colName":"title","colComment":"文章标题","dataType":"middleText","verify":["required"]},{"colName":"shorttitle","colComment":"文章短标题","dataType":"middleText","verify":[]},{"colName":"color","colComment":"文章标题链接颜色","dataType":"shortText","verify":[]},{"colName":"writer","colComment":"文章作者","dataType":"middleText","verify":[]},{"colName":"source","colComment":"文章来源","dataType":"middleText","verify":[]},{"colName":"litpic","colComment":"缩略图","dataType":"images","verify":[]},{"colName":"pubdate","colComment":"创建日期","dataType":"datetime","verify":[]},{"colName":"senddate","colComment":"发布日期","dataType":"datetime","verify":["required"]},{"colName":"keywords","colComment":"文章关键字","dataType":"middleText","verify":[]},{"colName":"lastpost","colComment":"修改日期","dataType":"datetime","verify":[]},{"colName":"description","colComment":"描述","dataType":"middleText","verify":[]},{"colName":"filename","colComment":"文件名","dataType":"files","verify":[]},{"colName":"template","colComment":"独立模版页","dataType":"middleText","verify":[]},{"colName":"isDelete","colComment":"是否删除","dataType":"middleText","verify":[]}],"total":{"addKey[]":["typeid","sortrank","click","title","shorttitle","color","writer","source","litpic","pubdate","senddate","keywords","lastpost","description","filename","template","isDelete"],"detailKey[]":["typeid","sortrank","click","title","shorttitle","color","writer","source","litpic","pubdate","senddate","keywords","lastpost","description","filename","template","isDelete"],"editKey[]":["typeid","sortrank","click","title","shorttitle","color","writer","source","litpic","pubdate","senddate","keywords","lastpost","description","filename","template","isDelete"],"searchKey[]":["typeid","title","shorttitle","writer","source","keywords","description"],"listKey[]":["typeid","sortrank","title","pubdate"],"keyVerify[]":["required","required","required"]}}
*/
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 数据模型说明
 * 文章管理
 * @author jian-jie.fu <fulusu@vip.sina.com>
 * @addTime  2018-05-30 04:04:45
 */
class ArchivesData extends MY_Model {

	public $tableName = 'we_archives';

	public function __construct() {
		parent::__construct();
	}
	
}

 ?>