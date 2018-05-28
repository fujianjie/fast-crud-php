<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * ORM
 * 资源管理中心
 * 用于生成数据表以及基本的CRUDS 编辑后台
 * 功能分成几个部分
 * 操作界面
 * 1. 数据库建表
 * 2. 已有数据表的操作
 * 3. 建立MODEL 文件
 * 4. 建立CONTROLLER 文件
 *
 * @author jian-jie.fu<jian-jie.fu@we-ideas.com>
 * @version  1.0
 */
class Orm extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        if(ENVIRONMENT === 'development'){
            return;
        }
    }

    /**
     * 验证器类型
     */
    public $verifyType = array(
        'alpha' => '字母',
        'required' => '必填',
        'integer' => '整数',
        'valid_email' => '邮箱',
        'alpha_numeric' => '字母和数字',
        'checkMobile' => '手机'
    );

    /**
     * shortText|middleText|longText|textarea|image|images|file|files|select|radio|checkbox|url|number|bool|hidden|date|time|datetime|timestamp
     */
    public $dataType = array(
        'shortText' => 'varchar(50)',
        'middleText' => 'varchar(100)',
        'longText' => 'varchar(200)',
        'textarea' => 'text',
        'image' => 'varchar(255)',
        'images' => 'text',
        'file' => 'varchar(255)',
        'files' => 'text',
        'select' => 'varchar(255)',
        'radio' => 'varchar(255)',
        'checkbox' => 'varchar(255)',
        'url' => 'varchar(255)',
        'number' => 'int(7)',
        'money'=>'DECIMAL(11,2)',
        'bool' => 'tinyint(1)',
        'hidden' => 'varchar(255)',
        'date' => 'date',
        'datetime' => 'datetime',
        'timestamp' => 'timestamp',
        'htmlEditor' =>'text'
    );

    public $dataTypeName = array(
    );

    public $sqlType = array(
        'shortText' => 'varchar',
        'middleText' => 'varchar',
        'longText' => 'varchar',
        'textarea' => 'text',
        'image' => 'varchar',
        'images' => 'varchar',
        'file' => 'varcha',
        'files' => 'varchar',
        'select' => 'varchar',
        'radio' => 'varchar',
        'checkbox' => 'varchar',
        'url' => 'varchar',
        'number' => 'int',
        'bool' => 'int',
        'hidden' => 'varchar',
        'date' => 'date',
        'datetime' => 'datetime',
        'timestamp' => 'timestamp',
        'htmlEditor'=>'text'
    );

    public function index()
    {
        $sql = "select database()";

        $query = $this->db->query($sql);
        $dbData = $query->row_array();
        $dbname = $dbData['database()'];

        $sql = "select TABLE_NAME as name,TABLE_COMMENT as comment from information_schema.TABLES where TABLE_SCHEMA='{$dbname}' ";
        $query = $this->db->query($sql);
        $tableData = $query->result_array($query);
        $this->load->library('form_validation');
        $this->load->view('orm/index', array(
            'table' => $tableData,
            'dataType' => $this->dataType,
            'verifyType' => $this->verifyType,
            'dataTypeName' => $this->dataTypeName
        ));
    }

    /**
     * 获取表结构
     */
    public function getCol()
    {
        $tablename = $this->input->post_get('tablename');
        $sql = 'SHOW FULL COLUMNS FROM ' . $tablename;
        $query = $this->db->query($sql);
        echo json_encode($query->result_array());
    }

    public function checkInfo()
    {
        $status = true;
        $msg = '成功';
        $hash = $this->security->get_csrf_hash();

        /**
         * 数据表检查
         */
        $tableName = $this->input->post('tableName');
        if ($this->input->post('createTable') == 'true') {
            $sql = "select database()";
            $query = $this->db->query($sql);
            $dbData = $query->row_array();
            $dbname = $dbData['database()'];
            $sql = "select TABLE_NAME as name,TABLE_COMMENT as comment from information_schema.TABLES where TABLE_SCHEMA='{$dbname}' ";
            $query = $this->db->query($sql);
            $tableData = $query->result_array($query);
            if (count($tableData) > 0) {
                foreach ($tableData as $each) {
                    if ($each['name'] == $tableName) {
                        $status = false;
                        $msg = '表名已存在';
                    }
                }
            }

        }

        /**
         * 文件检查
         */
        $className = $this->input->post('className');
        $modelName = $this->input->post('modelName');

        $className = ucfirst($className);
        $modelName = ucfirst($modelName);
        $filePath = APPPATH . '/controllers/' . $className . '.php';

        if (file_exists($filePath)) {
            $status = false;
            $msg = '控制器文件' . $filePath . '已存在,';
        }


        $filePath = APPPATH . '/models/' . $modelName . '.php';
        if (file_exists($filePath)) {
            $status = false;
            $msg = '模型文件' . $filePath . '已存在,';
        }


        $json = array(
            'status' => $status,
            'hash' => $hash,
            'msg' => $msg
        );
        echo json_encode($json);
    }

    /**
     * 需要转义的数据类型
     */
    public $needChangeType = array(
        'file','files', 'image', 'images', 'select', 'radio', 'checkbox', 'bool'
    );

    public function getHash()
    {
        echo $this->security->get_csrf_hash();
    }

    /**
     * 构造器
     * 1. 数据表
     * 2. 控制器文件
     * 3. 模型文件
     * 4. 导航
     * 5. 权限
     */
    public function create()
    {
        $lineData = json_decode($this->input->post('content'));
        $sqlContent = "";
        $createTable = $this->input->post('createTable');

        if ($createTable == 'true') {
            $tableName = $this->input->post('tableName');
        } else {
            $tableName = $this->input->post('selectTableName');
        }

        $tableComment = $this->input->post('tableComment');
        $modelComment = $this->input->post('modelComment');
        $controllerComment = $this->input->post('controllerComment');
        if (empty($modelComment)) {
            $modelComment = $tableComment;
        }
        if (empty($controllerComment)) {
            $controllerComment = $tableComment;
        }
        if ($createTable == 'true') {
            $sqlContent .= $this->_createTable($tableName, $tableComment, $lineData->line);
        }

        $className = $this->input->post('className');
        $modelName = $this->input->post('modelName');
        //
        $template = file_get_contents(APPPATH . '/views/orm/controller.txt');
        $template = str_replace('#postData', $this->input->post('content'), $template);
        $template = str_replace('#controllerComment', $controllerComment, $template);

        $template = str_replace('#addTime', date("Y-m-d h:i:s"), $template);
        $template = str_replace('#className', $className, $template);
        $template = str_replace('#modelName', $modelName, $template);
        $template = str_replace('#tableName', $tableName, $template);
        $keyNameList = array('id' => "序号");
        $keyTypeList = array('id' => "middleText");
        $keyVerifyList = array('id' => 'numeric');
        $keySqlType = array('id' => 'int');
        $keySelectData = array();
        if (count($lineData->line) > 0) {
            foreach ($lineData->line as $each) {
                $keyNameList[$each->colName] = $each->colComment;
                $keyTypeList[$each->colName] = $each->dataType;
                $keyVerifyList[$each->colName] = implode('|', $each->verify);
                $keySqlType[$each->colName] = $this->sqlType[$each->dataType];
                if (in_array($each->dataType, $this->needChangeType)) {
                    $keySelectData[$each->colName] = '';
                }
            }
        }

        $template = str_replace('#keyNameList', $this->toArrayStr($keyNameList), $template);
        $template = str_replace('#keyTypeList', $this->toArrayStr($keyTypeList), $template, $keyNameList);
        $template = str_replace('#keyVerifyList', $this->toArrayStr($keyVerifyList), $template);
        $template = str_replace('#keySqlType', $this->toArrayStr($keySqlType), $template);
        $template = str_replace('#keySelectData', $this->toArrayStr($keySelectData), $template);

        $searchKey = 'searchKey[]';
        $addKey = 'addKey[]';
        $listKey = 'listKey[]';
        $editKey = 'editKey[]';
        $detailKey = 'detailKey[]';
        $keyImport = 'keyImportant[]';
        if (isset($lineData->total->$searchKey)) {
            $template = str_replace('#searchKey', $this->toArrayStr($lineData->total->$searchKey, false), $template);
        } else {
            $template = str_replace('#searchKey', '', $template);
        }

        if (isset($lineData->total->$listKey)) {
            $template = str_replace('#listKey', $this->toArrayStr(array_merge(array('id'), $lineData->total->$listKey), false), $template);
        } else {
            $template = str_replace('#listKey', '', $template);
        }

        if (isset($lineData->total->$addKey)) {
            $template = str_replace('#addKey', $this->toArrayStr($lineData->total->$addKey, false), $template);
        } else {
            $template = str_replace('#addKey', '', $template);
        }
        if (isset($lineData->total->$editKey)) {
            $template = str_replace('#editKey', $this->toArrayStr($lineData->total->$editKey, false), $template);
        } else {
            $template = str_replace('#editKey', '', $template);
        }
        if (isset($lineData->total->$detailKey)) {
            $template = str_replace('#detailKey', $this->toArrayStr($lineData->total->$detailKey, false), $template);
        } else {
            $template = str_replace('#detailKey', '', $template);
        }
        if (isset($lineData->total->$keyImport)) {
            $template = str_replace('#keyImportant', $this->toArrayStr($lineData->total->$keyImport, false), $template);
        } else {
            $template = str_replace('#keyImportant', '', $template);
        }

        $saveControllerStr = "<" . "?php \n" . $template . "\n ?" . ">";
        $savePath = APPPATH . '/controllers/' . $className . '.php';
        file_put_contents($savePath, $saveControllerStr);



        $template = file_get_contents(APPPATH . '/views/orm/model.txt');
        $template = str_replace('#postData', $this->input->post('content'), $template);

        $template = str_replace('#modelComment', $modelComment, $template);
        $template = str_replace('#addTime', date("Y-m-d h:i:s"), $template);
        $template = str_replace('#modelName', $modelName, $template);
        $template = str_replace('#tableName', $tableName, $template);
        $savePath = APPPATH . '/models/' . $modelName . '.php';
        $saveModelStr = "<" . "?php \n" . $template . "\n ?" . ">";
        file_put_contents($savePath, $saveModelStr);
        $saveArray = array(
            'name' => $controllerComment . '查看',
            'keyset' => $className . 'view'
        );
        $this->db->insert('access', $saveArray);
        $sqlContent .= $this->db->set($saveArray)->get_compiled_insert('access');
        $sqlContent .= ";\n";
        $saveArray = array(
            'name' => $controllerComment . '编辑',
            'keyset' => $className . 'opt'
        );
        $this->db->insert('access', $saveArray);
        $sqlContent .= $this->db->set($saveArray)->get_compiled_insert('access');
        $sqlContent .= ";\n";
        $saveArray = array(
            'name' => $controllerComment . '删除',
            'keyset' => $className . 'del'
        );
        $this->db->insert('access', $saveArray);
        $sqlContent .= $this->db->set($saveArray)->get_compiled_insert('access');
        $sqlContent .= ";\n";
        $this->db->where('name', $controllerComment);
        $query = $this->db->get('nav');
        $data = $query->row_array();
        if ($data != null) {
            $this->db->where('id', $data['id']);
            $this->db->update('nav', array(
                'url' => $className . '/index',
                'access' => $className . 'view'
            ));
        } else {
            $saveArray = array(
                'name' => $controllerComment,
                'url' => $className . '/index',
                'access' => $className . 'view'
            );
            $this->db->insert('nav', $saveArray);

            $sqlContent .= $this->db->set($saveArray)->get_compiled_insert('nav');
            $sqlContent .= ";\n";
        }
        file_put_contents(APPPATH . '/sql/' . $tableName . '.sql', $sqlContent);
        $this->usersystem->setAccess($className . 'view');
        $this->usersystem->setAccess($className . 'opt');
        $this->msg->to($className . '/index');
    }

    public function _createTable($tableName, $tableComment, $cols)
    {
        $query = 'CREATE TABLE IF NOT EXISTS `' . $tableName . '` ( ' . "\n";
        $query .= "`id` int(7) NOT NULL AUTO_INCREMENT,   \n";
        if (count($cols) > 0) {
            foreach ($cols as $each) {
                $query .= "`{$each->colName}` {$this->dataType[$each->dataType]} NOT NULL COMMENT '{$each->colComment}' ,\n ";
            }
        }
        ////ALTER TABLE `{$tableName}`  ADD `isDelete` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '是否删除';
        $query .= "`isDelete` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '是否删除' ,\n";
        $query .= "PRIMARY KEY (`id`) \n";
        $query .= ") ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='{$tableComment}' AUTO_INCREMENT=1 ; \n";
        $this->db->query($query);
        return $query;
    }


    public function toArrayStr($array, $key = true, $notesArray = NULL)
    {
        $str = '';
        $a = array();
        if (count($array) > 0) {
            foreach ($array as $k => $v) {
                $v = str_replace('"', '\"', $v);
                if ($key) {
                    $tmp = '"' . $k . '"=>"' . $v . '"';
                } else {
                    $tmp = '"' . $v . '"';
                }
                if ($notesArray !== NULL) {
                    if (isset($notesArray[$k])) {
                        $tmp .= '/' . '*' . $notesArray[$k] . '*' . '/';
                    }
                }

                $a[] = $tmp;
            }
            $str = implode(",\n", $a);

        }
        return "\n" . $str . "\n";
    }


}

?>
