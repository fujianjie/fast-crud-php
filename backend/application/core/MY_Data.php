<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 系统数据基本流程控制器
 * 自动化ORM
 * Create Update Delete Search
 * 一个数据流程控制器用于对应一个数据MODEL
 * 用于保存该数据表当中数据的各个列的类型信息
 * 本核心提供了如下的页面功能：
 * 1. 列表页面  包含搜索和分页功能  可以被AJAX 外部调用 搜索有3种模式 KEY TOTAL  SEARCHPAGE
 * 2. 增加和编辑功能  包含被AJAX 调用的模式以弹窗进行编辑
 * 3. 详细页
 * 4. 删除
 * 5. 集成了权限
 *
 * 类型信息种类如下
 * 以字段名作为关键字，类型如下 以TpForm.class.php为准
 * 1.  表单数据类型 shortText|middleText|longText|textarea|text|image|images|file|files|select|radio|checkbox|url|number|bool|hidden|date|time|datetime|timestamp
 * 2.  表单数据 验证器 关联 表单修改以及提交部分的表单验证功能,关联表单数据类型
 * 3.  添加数据列名
 * 4.  编辑数据列名
 * 5.  表单数据详细名称
 * 6.  表单模糊查询搜索字段
 * 7.  表单分列查询搜索字段
 * 8.  序号
 * @author jian-jie.fu <fulusu@vip.sina.com>
 */
class MY_Data extends MY_Controller
{

    /**
     * 分页信息控制
     */
    public $perPage = 10;

    /**
     * 控制器中文名
     */
    public $controllerName = '';

    /**
     * 导航触发名称
     * 一般情况下为控制器中文名，当不为空时触发
     * 会根据触发的名称来处理侧栏导航
     */
    public $navName = '';

    /**
     * 数据库表名
     */
    public $tableName = '';

    /**
     * 序号字段名
     */
    public $primaryKeyName = 'id';

    /**
     * 字段在数据库的类型
     */
    public $keySqlType = array();

    /**
     * 列名对照表
     */
    public $keyNameList = array();

    /**
     * 字段类型对照表
     */
    public $keyTypeList = array();

    /**
     * 字段验证规则对照表
     */
    public $keyVerifyList = array();

    /**
     * 字段默认值
     */
    public $keyAddDefault = array();

    /**
     * 字段选项值
     */
    public $keySelectData = array();

    /**
     * 字段必填值
     */
    public $keyNeed = array();

    /**
     * 重要字段
     * 列表页始终显示
     */
    public $keyImportant = array();

    /**
     * 列表排序类型
     */
    public $orderWay = 'DESC';

    /**
     * 列表排序键名
     */
    public $orderBy = 'id';

    /**
     * 模板页面设定
     */

    /**
     * 列表页
     */
    public $listPage = 'default/list';

    /**
     * 列表页字段
     */
    public $listKey = array();

    /**
     * 列表页需要排序字段
     */
    public $listSortKey = array();

    /**
     * 列表页排序开关
     */
    public $listSortOpen = false;

    /**
     * list toogle
     */
    public $optToggle = true;

    /**
     * 列表页小标题
     */
    public $listTitleSmall = '';

    /**
     * 列表页表格前HTML
     */
    public $listNavHtml = '';

    /**
     * 查看详细页面
     */
    public $detailPage = 'default/detail';

    /**
     * 查看详细开关
     */
    public $detailOpen = true;

    /**
     * Ajax 载入详细信息的HTML
     */
    public $detailAjaxPage = 'default/detailHtml';

    /**
     * 查看页面显示字段
     */
    public $detailKey = array();

    /**
     * 添加按钮开关
     */
    public $addOpen = true;

    /**
     * 编辑按钮开关
     */
    public $editOpen = true;

    /**
     * 删除按钮开关
     */
    public $removeOpen = true;

    /**
     * 搜索开关
     */
    public $searchOpen = true;

    /**
     * 添加页面
     */
    public $addPage = 'default/add';

    /**
     * 添加Ajax Modal 页面
     */
    public $addModalPage = 'default/addModal';

    /**
     * 编辑 Ajax Modal 页面
     */
    public $editModalPage = 'default/editModal';

    /**
     * 删除 Ajax Modal 页面
     */
    public $removeModalPage = 'default/removeModal';

    /**
     * 添加页面字段
     */
    public $addKey = array();

    /**
     * 列表页添加按钮自定义
     */
    public $listAddButton = '';

    /**
     * 编辑页面
     */
    public $editPage = 'default/edit';

    /**
     * 编辑页面字段
     */
    public $editKey = array();

    /**
     * 搜索类型
     * 有两种搜索类型
     * 1. total  按照搜索字段里面的搜索类型进行全局模糊查找 全局OR LIKE
     * 2. key  按照搜索字段里面的搜索关键词进行等于匹配 多个关键字之间AND
     */
    public $searchType = 'total';

    /**
     * 搜索关键词
     */
    public $searchKey = array();

    /**
     * 是否隐藏搜索区域
     */
    public $searchHide = false;

    /**
     * 搜索区域额外文字
     */
    public $searchAddonContent = '';

    /**
     * 编辑权限
     */
    public $editAccess = false;

    /**
     * 删除权限
     */
    public $deleteAccess = false;

    /**
     * 需要转义的数据类型
     */
    public $needChangeType = array(
        'file', 'files', 'image', 'images', 'select', 'radio', 'checkbox', 'bool', 'unitText', 'hr', 'hrFirst','a', 'user', 'intTimeText'
    );

    /**
     * 列表界面配置
     */
    public $listNoBorder = false;

    /**
     * 显示列表页的SQL查询语句
     */
    public $listSql = false;

    /* 列表额外按钮 */
    public $addonButton = array();


    /**
     * 列表页补充搜索条件开关
     */
    public $listWhereOpen = false;

    /**
     * 列表页需要额外载入的内容
     */
    public $listScript = '';

    /**
     * 当前请求的页面路径
     */
    public $nowUrl = '';

    /**
     * Ajax 加载页面
     */
    public $isAjaxPage = false;

    /**
     * 特定跳转URL
     */
    public $specialUrl = '';

    /**
     * delete
     */
    public $isDelete = 'isDelete';

    /**
     * 初始化
     */
    public function __construct()
    {
        parent::__construct();
        $this->_accessCheck();
        $this->_setNowUrl();
        if ($this->input->get('token') !== NULL) {
            $_GET['dontsaveurl'] = 1;
        }
        if (!isset($_SESSION[$this->router->class])) {
            $_SESSION[$this->router->class] = array();
        }
        $this->nowUrl = $_SERVER['REQUEST_URI'];
        if ($this->input->post_get('isAjaxPage')) {
            $this->isAjaxPage = true;
        }

        if ($this->input->post_get('detailOpen') !== null) {
            if ($this->input->post_get('detailOpen') == 1) {
                $this->detailOpen = true;
            } else {
                $this->detailOpen = false;
            }
        }

        if ($this->input->post_get('editOpen') !== null) {
            if ($this->input->post_get('editOpen') == 1) {
                $this->editOpen = true;
            } else {
                $this->editOpen = false;
            }
        }

        if ($this->input->post_get('removeOpen') !== null) {
            if ($this->input->post_get('removeOpen') == 1) {
                $this->removeOpen = true;
            } else {
                $this->removeOpen = false;
            }
        }


    }

    /**
     * 设定操作名称
     */
    public function _setActionName()
    {
        switch ($this->router->method) {
            case 'index':
                $this->actionName = '列表';
                break;
            case 'add':
                $this->actionName = '添加';
                break;
            case 'edit':
                $this->actionName = '编辑';
                break;
            case 'addSave':
                $this->actionName = '添加保存';
                break;
            case 'editSave':
                $this->actionName = '编辑保存';
                break;
            case 'detail':
                $this->actionName = '详情';
                break;
            case 'remove':
                $this->actionName = '移除';
                break;
            case 'dataTable':
                $this->actionName = '数据格式';
                break;
            case 'excel':
                $this->actionName = '导出';
                break;
            case 'search':
                $this->actionName = '综合搜索';
                break;
            default :
                $this->actionName = $this->router->method;
        }
        $this->actionName = $this->controllerName . $this->actionName;
    }

    /**
     * 自动保存当前请求路径
     */
    public function _setNowUrl()
    {

        if ($this->input->post_get('dontsaveurl') != '' || $this->isApi == 1) {

            return;
        }


        if(isset($_SESSION['nowUrl']) && $_SESSION['nowUrl'] == $_SERVER['REQUEST_URI']){
            return;
        }

        $_SESSION['nowUrl'] = $_SERVER['REQUEST_URI'];
        //init
        if (!isset($_SESSION['urlHistory'])) {
            $_SESSION['urlHistory'] = array();
        }
        if (isset($_SERVER['REQUEST_URI'])) {

            $parse = parse_url($_SERVER['REQUEST_URI']);
            if ($parse['path'] !== '/') {
                if ($this->input->get('referer') == 1) {

                    array_pop($_SESSION['urlHistory']);
                    return;
                }
                //可以保存的状态
                $length = count($_SESSION['urlHistory']);
                if ($length > 100) {
                    foreach ($_SESSION['urlHistory'] as $k => $v) {
                        unset($_SESSION['urlHistory'][$k]);
                        break;
                    }
                }
                if ($length > 0) {
                    foreach ($_SESSION['urlHistory'] as $beforeLink) {

                    }
                    if ($beforeLink != $_SERVER['REQUEST_URI']) {
                        //含save 的不保存
                        if (strstr($this->router->method, 'Save') === false) {
                            $_SESSION['urlHistory'][] = $_SERVER['REQUEST_URI'];
                        }
                    }
                } else {
                    if (strstr($this->router->method, 'Save') === false) {
                        $_SESSION['urlHistory'][] = $_SERVER['REQUEST_URI'];
                    }
                }
            }
        }

    }

    /**
     * 上一个访问的链接
     * @return string url
     */
    public function _lastLink()
    {
        if ($this->isApi) {
            return '';
        }
        if (!empty($this->specialUrl)) {
            return $this->specialUrl;
        }
        if ($this->input->post_get('lastLink') !== null) {
            return $this->input->post_get('lastLink');
        }
        $length = count($_SESSION['urlHistory']);

        if ($length < 2) {
            return '/' . $this->router->class . '/';
        }
        $urlArray = $_SESSION['urlHistory'];
        krsort($urlArray);
        $i = 0;
        $url = '';
        foreach ($urlArray as $each) {
            $url = array_shift($urlArray);
            $i++;
            if ($this->input->post_get('dontsaveurl') == 1) {
                if($this->input->post_get('isAjaxPage') === NULL){
                    $_SESSION['urlHistory'][] = $url;
                }

                break;
            } else {
                if ($i > 1) {
                    break;
                }
            }

        }

        if (!empty($url) && $this->input->post_get('dontsaveurl') === NULL) {
            while(1){
                if (strstr($url, '?') === false) {
                    $url .= "?referer=1";
                } else {
                    $url .= "&referer=1";
                }
                if($url == $_SESSION['nowUrl']){
                    array_pop($_SESSION['urlHistory']);
                    $url = array_shift($urlArray);
                    if(count($urlArray) ==0){
                        return $url;
                    }
                }else{
                    return $url;
                }
            }
            return $url;
        } else if(!empty($url)){

            return $url;
        }
        else {
            return '/' . $this->router->class . '/';
        }
    }

    /**
     * 视图层需要调用数据的中转
     */
    public $viewData = array();

    /**
     * 设定视图层所需要用到的变量
     * 从整个控制器对象中读取所有
     */
    public function _setViewData()
    {
        if (count($this->listSortKey) == 0) {
            $this->listSortKey = $this->listKey;
        }
        if (count($this->keyTypeList) > 0) {
            foreach ($this->keyTypeList as $k => $v) {
                if (in_array($v, $this->needChangeType)) {
                    if (!isset($this->keySelectData[$k])) {
                        $this->keySelectData[$k] = array();
                    }
                }
                $verifyStr = '';
                if (isset($this->keyVerifyList[$k])) {
                    $verifyStr = $this->keyVerifyList[$k];
                }

                if (strstr($verifyStr, 'required') !== false) {
                    $this->keyNeed[$k] = true;
                } else {
                    $this->keyNeed[$k] = false;
                }
            }
        }

        $viewData = $this->toArray($this);
        $viewData['primaryKey'] = $this->primaryKeyName;
        $viewData['className'] = $this->router->class;
        $viewData['search'] = '';

        $viewData['referer'] = $this->_lastLink();

        $this->viewData = array_merge($viewData, $this->viewData);
        $this->_setActionName();
    }

    /**
     * 设定列表页补充查询条件
     */
    public function _setListSQL()
    {

    }

    /**
     * 设定列表页搜索
     * 单搜索表单 模糊搜索
     * @param array $viewData 视图层本身所使用的数据
     * @param string $searchUrl
     */
    public function _setListSearchTotal(&$viewData, &$searchUrl)
    {
        $searchKeyWord = '';
        if ($this->input->post_get('search') !== NULL) {
            $searchKeyWord = trim($this->input->post_get('search'));
            $_SESSION[$this->router->class]['search'] = $searchKeyWord;
        } else {
            if (isset($_SESSION[$this->router->class]) && isset($_SESSION[$this->router->class]['search']) && !$this->listAjaxPage) {
                if (!is_array($_SESSION[$this->router->class]['search'])) {
                    $searchKeyWord = $_SESSION[$this->router->class]['search'];
                }
            }
        }
        $keywordArray = $this->_splitKeyword($searchKeyWord);
        if (count($this->searchKey) > 0 && !empty($searchKeyWord)) {
            if (count($this->searchKey) > 0) {
                $this->db->group_start();
                foreach ($keywordArray as $keyword) {
                    foreach ($this->searchKey as $each) {
                        $this->db->or_like($each, $keyword);
                    }
                }
                $this->db->group_end();
            }
            $searchUrl = '?search=' . $searchKeyWord;
            $viewData['search'] = $searchKeyWord;
        }
    }

    /**
     * 设定列表页搜索
     * 所多个搜索表单的指定搜索方式
     * 多字段单独搜索模式
     */
    public function _setListSearchKey(&$viewData, &$searchUrl)
    {

        if (count($this->searchKey) > 0) {
            if ($this->listWhereOpen) {
                $this->db->group_start();
            }

            $this->db->where(1, 1);
            $req = array();
            $searchUrlKey = array();

            foreach ($this->searchKey as $v) {

                if ($this->input->post_get($v) === NULL) {
                    if (isset($_SESSION[$this->router->class]['search'][$v]) && !$this->listAjaxPage) {
                        $_GET[$v] = $_SESSION[$this->router->class]['search'][$v];
                    } else {
                        continue;
                    }
                }
                if ($this->keySqlType[$v] == 'int') {
                    if ($this->input->post_get($v) === '') {
                        continue;
                    }
                    $req[$v] = intval($this->input->post_get($v));
                    if (!empty($req[$v]) || $req[$v] === 0) {
                        $this->db->where($this->tableName . '.' . $v, $req[$v]);
                        $searchUrlKey[] = $v . "=" . urlencode($req[$v]);
                    } else {
                        $req[$v] = '';
                    }
                } else {
                    $req[$v] = $this->input->post_get($v);
                    $req[$v] = trim($req[$v]);

                    if (!empty($req[$v])) {
                        $this->db->like($this->tableName . '.' . $v, $req[$v]);
                        $searchUrlKey[] = $v . "=" . urlencode($req[$v]);
                    }
                }
            }
            if ( $this->listWhereOpen) {
                $this->db->group_end();
            }

            $viewData['search'] = $req;
            $_SESSION[$this->router->class]['search'] = $req;
            $searchUrl = '?' . implode('&', $searchUrlKey);
        }
    }

    /**
     * 设定列表页搜索
     * 所有字段独立搜索
     */
    public function _setListSearchPage(&$viewData, &$searchUrl)
    {
        if (empty($this->searchPageKey)) {
            $this->searchPageKey = $this->addKey;
        }

        $viewData['searchType'] = 'searchPage';
        $viewData['searchData'] = array();
        if (count($this->searchPageKey) > 0) {
            if ( $this->listWhereOpen) {
                $this->db->group_start();
            }

            $this->db->where(1, 1);
            $req = array();
            $searchUrlKey = array('searchType=searchPage');

            foreach ($this->searchPageKey as $v) {

                if ($this->input->post_get($v) === NULL) {
                    if (isset($_SESSION[$this->router->class]['search'][$v]) && !$this->listAjaxPage) {
                        $_GET[$v] = $_SESSION[$this->router->class]['search'][$v];
                    } else {
                        continue;
                    }
                }
                if (!isset($this->keySqlType[$v])) {
                    $this->keySqlType[$v] = 'varchar';
                }
                if ($this->keySqlType[$v] == 'int') {
                    if ($this->input->post_get($v) === '') {
                        continue;
                    }

                    $req[$v] = intval($this->input->post_get($v));
                    if (!empty($req[$v]) || $req[$v] === 0) {
                        $this->db->where($v, $req[$v]);
                        $searchUrlKey[] = $v . "=" . urlencode($req[$v]);
                        $viewData['searchData'][$v] = $this->input->post_get($v);
                    } else {
                        $req[$v] = '';
                    }
                } else {
                    $req[$v] = $this->input->post_get($v);
                    if (!empty($req[$v])) {
                        $this->db->like($v, $req[$v]);
                        $searchUrlKey[] = $v . "=" . urlencode($req[$v]);
                        $viewData['searchData'][$v] = $this->input->post_get($v);
                    }
                }
            }
            if ( $this->listWhereOpen) {
                $this->db->group_end();
            }

            $viewData['search'] = $req;
            $_SESSION[$this->router->class]['search'] = $req;
            $searchUrl = '?' . implode('&', $searchUrlKey);
        }
    }

    /**
     * 判定是否要隐藏列表的操作列
     */
    public function _listOptionHide()
    {
        if ($this->input->post_get('operationHide') == 'hide') {
            $this->searchHide = true;
            $this->addOpen = false;
            $this->addonButton = false;
            $this->listOperation = false;
        }
        if ($this->input->post_get('listAjaxPage') == 1) {
            $this->listAjaxPage = true;
        }
    }

    /**
     * 是否是AJAX 请求
     * 如果是的话需要载入部分页面内容 不是则载入完整页面
     */
    public $listAjaxPage = false;

    /**
     * 列表页操作项开关
     */
    public $listOperation = true;

    /**
     * 搜索页模板路径
     */
    public $searchPage = 'default/searchPage';

    /**
     * 综合搜索页开关
     */
    public $searchPageOpen = true;

    /**
     * 综合搜索页搜索关键字
     */
    public $searchPageKey = array();

    /**
     * 可综合搜索的数据类型
     */
    public $searchPageTypes = array(
        'middleText', 'bool', 'checkbox', 'date', 'longText', 'textarea', 'number', 'radio', 'select', 'shortText', 'unitText', 'a'
    );

    /**
     * 综合搜索页
     */
    public function search()
    {
        if (!$this->searchPageOpen) {
            $this->msg->error('该模块的综合搜索已关闭');
            $this->msg->to($this->router->class . '/index');
        }
        if (empty($this->searchPageKey)) {
            $this->searchPageKey = $this->addKey;
        }
        $this->msg->content('所有文本搜索输入内容为模糊搜索');
        $keyNeed = array();
        //预处理 剔除不需要的字段
        foreach ($this->searchPageKey as $k => $each) {
            if (!in_array($this->keyTypeList[$each], $this->searchPageTypes)) {
                unset($this->searchPageKey[$k]);
            }
            if ($this->keyTypeList[$each] == 'textarea') {
                $this->keyTypeList[$each] = 'middleText';
            }
            $keyNeed[$each] = false;
        }
        $this->_setViewData();
        $viewData = $this->viewData;

        $viewData['keyNeed'] = $keyNeed;
        $this->load->view($this->searchPage, $viewData);
    }

    /**
     * 基本列表页
     */
    public function index()
    {

        $this->load->library('Pages');
        $this->load->library('form_validation');
        $this->_listOptionHide();
        $this->_setViewData();
        $viewData = $this->viewData;
        /**
         * 列表信息准备
         */
        if (empty($this->listKey) || count($this->listKey) == 0) {
            foreach ($this->keyNameList as $k => $v) {
                $this->listKey[] = $k;
            }
            $viewData['listKey'] = $this->listKey;
        }
        /**
         * 可以通过提交listKey 来定制列表页
         * 字段项必须是 表内有的
         */
        if ($this->input->post_get('listKey') !== NULL) {
            $listKey = $this->input->post_get('listKey');
            if (is_array($listKey)) {
                $tmp = array();
                foreach ($listKey as $each) {
                    if (in_array($each, $this->listKey)) {
                        $tmp[] = $each;
                    }
                }
                if (count($tmp) > 0) {
                    $viewData['listKey'] = $tmp;
                }
            }
        }

        /**
         * 搜索信息准备
         */
        $this->db->start_cache();


        $searchUrl = '';

        if ($this->input->post_get('clearSearch') === '1' || $this->isApi) {

            if (isset($_SESSION[$this->router->class]) && isset($_SESSION[$this->router->class]['search'])) {
                unset($_SESSION[$this->router->class]['search']);
            }
        }


        if ($this->input->post_get('searchType') == 'searchPage') {
            //综合搜索页面
            $this->_setListSearchPage($viewData, $searchUrl);
        } else {
            if ($this->searchType == 'total') {
                //单输入框模糊字段查找
                $this->_setListSearchTotal($viewData, $searchUrl);
            } else if ($this->searchType == 'key') {
                //多输入框并行查找
                $this->_setListSearchKey($viewData, $searchUrl);
            }
        }

        $baseUrl = $searchUrl;
        if ($this->input->post_get('pageNum') !== null) {
            $pageNum = (int)$this->input->post_get('pageNum');
            $this->perPage = $pageNum;
        }
        if ($this->perPage != 0 && $this->perPage != 10) {
            if (strlen($searchUrl) == 0) {
                $searchUrl .= '?';
            }
            if (strlen($searchUrl) > 1) {
                $searchUrl .= '&';
            }
            $searchUrl .= 'pageNum=' . $this->perPage;
        }
        //处理排序
        if ($this->input->post_get('orderBy') !== NULL) {
            $orderBy = $this->input->post_get('orderBy');
            if (in_array($orderBy, $this->listKey)) {
                if (strlen($searchUrl) == 0) {
                    $searchUrl .= '?';
                }
                $this->orderBy = $orderBy;
                if (strlen($searchUrl) > 1) {
                    $searchUrl .= '&';
                }
                $searchUrl .= "orderBy={$orderBy}";
            }
        }
        //排序方式
        if ($this->input->post_get('orderWay') !== NULL) {
            $orderWay = $this->input->post_get('orderWay');
            if ($orderWay == 'DESC' || $orderWay == 'ASC') {
                if (strlen($searchUrl) == 0) {
                    $searchUrl .= '?';
                }
                $this->orderWay = $orderWay;
                if (strlen($searchUrl) > 1) {
                    $searchUrl .= '&';
                }
                $searchUrl .= "orderWay={$orderWay}";
            }
        }

        if (!$this->isApi) {
            $this->db->where($this->tableName . '.' . $this->isDelete, 0);
        }

        /**
         * 需要补充的搜索条件
         */
        $this->_setListSQL();

        //缓存当前搜索条件
        $this->db->stop_cache();
        //SQL 检查
        //分页部分的查询数据行数并进行配置
        // $this->db->select('count(1) as total');
        $this->db->from($this->tableName);

        $total = $this->db->count_all_results();

        if ($this->perPage == 0) {
            $this->perPage = $total;
        }
        if ($this->input->post_get('pageNum') !== null) {
            $pageNum = (int)$this->input->post_get('pageNum');
            $this->perPage = $pageNum;
        }
        //生成分页配置
        $baseUrl = '/' . $this->router->class . '/' . $this->router->method . $baseUrl;
        $pageConfig = array(
            'base_url' => '/' . $this->router->class . '/' . $this->router->method . $searchUrl,
            'total_rows' => $total,
            'per_page' => $this->perPage,
            'uri_segment' => 5
        );
        $this->pages->initialize(array_merge($pageConfig, $this->pageConfig));
        $offset = $this->input->post_get('per_page') ? $this->input->post_get('per_page') : 0;
        if ($offset == 0) {
            $viewData['pageNum'] = 0;
        } else {
            $viewData['pageNum'] = floor($offset / $this->perPage);
        }

        $viewData['pageTotal'] = $total;
        $this->db->limit($this->perPage, $offset);
        $this->db->order_by($this->tableName . '.' . $this->orderBy, $this->orderWay);
        //在最终列表查询前还需要补充的搜索条件
        $this->_beforeListQuery();
        if ($this->listSql) {
            $this->db->from($this->tableName);
            $sql = $this->db->get_compiled_select();
            $query = $this->db->query($sql);
            $viewData['listSql'] = $sql;
        } else {
            $query = $this->db->get($this->tableName);
        }
        $this->db->flush_cache();
        $listData = $query->result_array();
        $this->_beforeList($listData);
        $viewData['listData'] = $listData;
        $viewData['page'] = $this->pages->create_links();
        $viewData['baseUrl'] = $baseUrl;
        $viewData['orderBy'] = $this->orderBy;
        $viewData['orderWay'] = $this->orderWay;
        $strlen = strlen($searchUrl);
        if ($strlen > 0) {
            $exportStrUrl = substr($searchUrl, 1, $strlen - 1);
        } else {
            $exportStrUrl = '';
        }
        $viewData['exportUrl'] = $exportStrUrl;
        //重设定来源页面
        if (!$this->listAjaxPage) {
            if (!empty($searchUrl)) {
                $_SESSION['HTTP_REFERER'] = '/' . $this->router->class . '/' . $this->router->method . $searchUrl . "&per_page=" . $offset;
            } else {
                $_SESSION['HTTP_REFERER'] = '/' . $this->router->class . '/' . $this->router->method . "?per_page=" . $offset;
            }
        }
        $this->_setListViewData($viewData);
        if ($this->isApi) {
            $this->apiResponse['status'] = 'success';
            $list = array();
            $this->listKey[] = 'id';
            if (count($listData) > 0) {
                foreach ($listData as $each) {

                    $tmp = array();
                    foreach ($this->listKey as $k) {
                        $fname = $this->keyTypeList[$k] . 'Value';
                        if (!isset($this->keySelectData[$k])) {
                            $this->keySelectData[$k] = array();
                        }

                        if (in_array($this->keyTypeList[$k], $this->needChangeType)) {

                            if (isset($each[$k . '_id'])) {
                                $tmp[$k . '_id'] = $each[$k . '_id'];
                                $tmp[$k] = $each[$k];
                            } else {
                                $tmp[$k] = strip_tags(TpForm::$fname($each[$k], $this->keySelectData[$k]));

                                $tmp[$k . '_id'] = $each[$k];
                            }
                        } else {
                            $tmp[$k] = $each[$k];
                        }
                    }
                    if (isset($each[$this->isDelete])) {
                        $tmp[$this->isDelete] = $each[$this->isDelete];
                    }
                    $list[] = $tmp;
                }
            }
            $this->_setApiData($list);
            $this->apiResponse['data'] = $list;
            $this->apiResponse['offset'] = $offset;
            $this->apiResponse['total'] = $total;
            if ($this->listSql) {
                $this->apiResponse['listSql'] = $viewData['listSql'];
            }
            echo json_encode($this->apiResponse);
        } else {

            $html = $this->load->view($this->listPage, $viewData, TRUE);
            $this->LogData->saveData($this->actionName, $html);
            echo $html;
        }
    }

    public function _setListWhere()
    {

    }

    public function _setListViewData(&$viewData)
    {

    }

    public function _setApiData(&$data)
    {

    }

    /**
     * 保存前的预处理
     * 在三处（ADD EXCEL EDIT） 的制作保存数据时候被调用
     */
    public function _setSaveFix(&$data)
    {

    }

    /**
     * 详细页的SQL 查询
     */
    public function _detailSql()
    {
        $primaryData = $this->input->post_get($this->primaryKeyName);
        $this->db->where($this->tableName . '.' . $this->primaryKeyName, $primaryData);
        return $this->db->get($this->tableName);
    }

    public function _apiDetail(&$json, $data)
    {

    }

    /**
     * 详情页面
     */
    public function detail()
    {
        $this->_setViewData();
        $viewData = $this->viewData;
        if (empty($viewData['detailKey'])) {
            foreach ($this->keyNameList as $k => $v) {
                $viewData['detailKey'][] = $k;
            }
        }
        $query = $this->_detailSql();
        $data = $query->row_array();
        if ($data == null) {
            if ($this->isApi) {
                $jsonArray = array(
                    'data' => '',
                    'keyName' => '',
                    'msg' => '没找到这条数据记录',
                    'status' => 'failed'
                );
                echo json_encode($jsonArray);
                die;
            }
            if ($this->input->post_get('detailAjaxPage') !== NULL) {
                die;
            } else {
                $this->msg->error('没找到这条数据记录');
                $this->msg->to($this->router->class . '/index');
            }
        }
        $viewData['data'] = $data;
        $this->_beforeDetail($viewData);

        if ($this->input->get('detailAjaxPage') == 1) {
            $this->detailPage = $this->detailAjaxPage;
        }
        if (!$this->isApi) {
            $html = $this->load->view($this->detailPage, $viewData, true);
            $this->LogData->saveData($this->actionName, $html);
            echo $html;
        } else {
            $dataInfo = array();
            if (count($viewData['data']) > 0) {
                foreach ($viewData['data'] as $key => $each) {
                    $tmp = array(
                        'key' => $key,
                        'title' => isset($viewData['keyNameList'][$key]) ? $viewData['keyNameList'][$key] : $key,
                        'content' => $each === NULL ? '' : $each
                    );
                    $dataInfo[] = $tmp;
                }
            }
            $jsonArray = array(
                'data' => $dataInfo,
                'msg' => '',
                'status' => 'success'
            );
            $this->_apiDetail($jsonArray, $viewData['data']);
            $html = json_encode($jsonArray);
            $this->LogData->saveData($this->actionName, $html);
            echo $html;
        }
    }

    public function _AddInput($kname, $name, $type, $selectData = array(), $verify = '', $sqltype = 'int', $default = 0)
    {
        $this->keyNameList[$kname] = $name;
        $this->keyAddDefault[$kname] = $default;
        $this->keyTypeList[$kname] = $type;
        $this->keyVerifyList[$kname] = $verify;
        $this->keySqlType[$kname] = $sqltype;
        $this->keySelectData[$kname] = $selectData;
    }

    /**
     * 添加页面需要动态获取添加字段的
     */
    public function _apiAdd(&$json)
    {

    }

    /**
     * 添加页面
     */
    public function add()
    {
        if (!$this->addOpen) {
            $this->msg->to($this->router->class . '/index', '新增功能已经关闭');
        }
        if ($this->input->post_get('clearAutoFill') !== NULL) {
            $_SESSION['tempInput'] = array();
        }

        if (isset($_SESSION['tempInput']) && count($_SESSION['tempInput']) > 0) {
            foreach ($_SESSION['tempInput'] as $k => $v) {
                $this->keyAddDefault[$k] = $v;
            }
        }

        $this->_setViewData();
        $viewData = $this->viewData;
        $this->_beforeAdd($viewData);
        if ($this->isApi) {
            $skipType = array('hrFirst', 'html', 'hr');
            $addKey = array();
            foreach ($this->addKey as $k => $key) {
                if (in_array($this->keyTypeList[$key], $skipType)) {
                    continue;
                }
                $tmp = array(
                    'key' => $key,
                    'type' => isset($this->keySqlType[$key]) ? $this->keySqlType[$key] : 'varchar',
                    'name' => isset($this->keyNameList[$key]) ? $this->keyNameList[$key] : '',
                    'value' => isset($this->keyAddDefault[$key]) ? $this->keyAddDefault[$key] : ''
                );
                $addKey[] = $tmp;
            }
            $json = array('status' => 'success', 'msg' => '操作成功', 'data' => $addKey);
            $this->_apiAdd($json);
            $html = json_encode($json);


        } else {
            $this->load->library('form_validation');
            if ($this->isAjaxPage) {
                $html = $this->load->view($this->addModalPage, $viewData, true);
            } else {
                $html = $this->load->view($this->addPage, $viewData, true);
            }
        }
        $this->LogData->saveData($this->actionName, $html);
        echo $html;
    }

    /**
     * 编辑页面
     */
    public function edit()
    {
        if (!$this->editOpen) {
            $this->msg->to($this->router->class . '/index', '编辑功能已经关闭');
        }
        $this->_setViewData();
        $viewData = $this->viewData;
        $id = $this->input->get_post($this->primaryKeyName);
        if (!is_numeric($id)) {
            $this->msg->to($this->router->class . '/index', '编辑操作必须使用整数的序号');
        }
        $this->db->where($this->primaryKeyName, $id);
        $this->db->limit(1);
        $query = $this->db->get($this->tableName);
        $row = $query->row_array();
        if ($row == null) {
            $this->msg->to($this->router->class . '/index', '没找到这条数据记录');
        }
        if (!isset($_SESSION[$this->router->class]['edit'][$this->primaryKeyName]) || $_SESSION[$this->router->class]['edit'][$this->primaryKeyName] != $id) {
            unset($_SESSION[$this->router->class]['edit']);
        }
        if (isset($_SESSION[$this->router->class]['edit']) && $_SESSION[$this->router->class]['edit'][$this->primaryKeyName] == $id) {
            $oldData = $_SESSION[$this->router->class]['edit'];
            foreach ($this->editKey as $key) {
                if (!isset($oldData[$key])) {
                    continue;
                }
                if (isset($oldData[$key])) {
                    $row[$key] = $oldData[$key];
                }
                if (is_array($row[$key])) {
                    $row[$key] = implode(',', $row[$key]);
                }
            }
        }
        $viewData['data'] = $row;
        $this->_beforeEdit($viewData);
        $this->load->library('form_validation');
        if ($this->isAjaxPage) {
            $html = $this->load->view($this->editModalPage, $viewData, true);
        } else {
            $html = $this->load->view($this->editPage, $viewData, true);
        }
        $this->LogData->saveData($this->actionName, $html);
        echo $html;
    }

    /**
     * 删除模态框
     */
    public function removeModal()
    {
        $this->_setViewData();
        $id = $this->input->post_get($this->primaryKeyName);
        if (!is_numeric($id)) {
            $this->msg->error('您提交的参数有误');
            $this->msg->to($this->router->class . '/index', '');
            return;
        }
        $this->db->where($this->primaryKeyName, $id);
        $this->db->limit(1);
        $query = $this->db->get($this->tableName);
        $data = $query->row_array();
        $viewData = $this->viewData;

        if (empty($viewData['detailKey'])) {
            foreach ($this->keyNameList as $k => $v) {
                $viewData['detailKey'][] = $k;
            }
        }
        if ($data) {
            $viewData['data'] = $data;
            $this->_beforeDetail($viewData);
            $this->load->view($this->removeModalPage, $viewData);
        }
    }

    /**
     * 删除后执行
     * @param int $id
     */
    public function _afterRemove($id)
    {

    }

    /**
     * 删除数据请求处理
     */
    public function remove()
    {
        $id = $this->input->get($this->primaryKeyName);
        if (!is_numeric($id)) {
            $this->msg->error('您提交的参数有误');
            $this->msg->to($this->router->class . '/index', '');
            return;
        }
        $this->db->where($this->primaryKeyName, $id);
        $this->db->limit(1);
        $status = $this->db->update($this->tableName, array($this->isDelete => 1));
        if ($status) {
            $this->_afterRemove($id);
            $this->LogData->saveData($this->actionName, '删除成功');
            $this->msg->success('操作成功！');
        } else {
            $this->LogData->saveData($this->actionName, '删除失败');
            $this->msg->error('未找到指定数据条目');
        }
        $link = $this->_lastLink();
        if (!empty($link)) {
            header('location:' . $link);
        } else {
            $this->msg->to($this->router->class . '/index', '');
        }
    }

    public $runAddSave = true;
    public $runAddSaveReason = '';

    /**
     * 添加页面POST
     */
    public function addSave()
    {
        $_SESSION['tempInput'] = array();

        $this->load->library('form_validation');
        if (!count($this->addKey) > 0) {
            $this->msg->error('添加操作未开启');
            $this->msg->to($this->router->class . '/add', '');
        }

        $hasVerify = 0;
        foreach ($this->addKey as $k => $key) {
            if (in_array($this->keyTypeList[$key], array('hr', 'hrFirst', 'settingChu', 'shopFloor'))) {
                unset($this->addKey[$k]);
            }
            $v = $this->input->post_get($key);
            if ($v !== NULL && !empty($v)) {

                if (is_array($v)) {
                    $v = array_filter($v);
                    if (count($v) > 0) {
                        $v = implode(',', $v);
                    }
                }
                if (!empty($v)) {
                    $_SESSION['tempInput'][$key] = $v;
                }
            }
        }

        foreach ($this->addKey as $key) {

            if (!empty($this->keyVerifyList[$key])) {
                $hasVerify++;
            }
            if (isset($this->keyTypeList[$key]) && $this->keyTypeList[$key] == 'extraInput') {
                continue;
            }
            if (in_array($this->keyTypeList[$key], array('checkbox'))) {
                $this->form_validation->set_rules($key . '[]', $this->keyNameList[$key], $this->keyVerifyList[$key]);
            } else {
                $this->form_validation->set_rules($key, $this->keyNameList[$key], $this->keyVerifyList[$key]);
            }
            //$this->form_validation->set_rules($key, $this->keyNameList[$key], $this->keyVerifyList[$key]);
        }
        if ($hasVerify > 0 && $this->form_validation->run() == FALSE) {
            if ($this->isApi) {
                $this->apiResponse['status'] = 'failed';
                $this->apiResponse['msg'] = strip_tags($this->form_validation->error_string());
                echo json_encode($this->apiResponse);
                die();
            } else {
                $this->msg->error($this->form_validation->error_string());
                $this->msg->to($this->router->class . '/add', '');
                return;
            }
        }
        $saveData = array();
        foreach ($this->addKey as $key) {
            if (isset($this->keyTypeList[$key]) && $this->keyTypeList[$key] == 'extraInput') {
                continue;
            }
            $saveData[$key] = $this->input->post($key);
            if ($saveData[$key] === NULL) {
                $saveData[$key] = '';
            }
            if (in_array($this->keyTypeList[$key], $this->needChangeType)) {
                if (in_array($this->keyTypeList[$key], array('checkbox', 'images', 'image', 'file', 'files'))) {
                    if (is_array($this->input->post($key))) {
                        $saveData[$key] = implode(',', array_filter($this->input->post($key)));
                    }
                }
            }

            if (isset($saveData[$key]) && is_array($saveData[$key])) {
                $saveData[$key] = implode(',', array_filter($saveData[$key]));
            }
        }
        $this->_setSaveFix($saveData);
        $this->_beforeAddSave($saveData);
        if (count($saveData) > 0) {
            foreach ($saveData as $k => $v) {
                if ($v === NULL) {
                    unset($saveData[$k]);
                }
                if (is_array($v)) {
                    $saveData[$k] = implode(',', $v);
                }
            }
        }
        if ($this->runAddSave) {
            $query = $this->db->insert($this->tableName, $saveData);
            $saveData[$this->primaryKeyName] = $this->db->insert_id();
            $this->_afterAddSave($saveData);
            $cleanAdd = '<script>if(localStorage){delete localStorage.' . $this->router->class . 'addSave;}</script>';
        } else {
            $query = false;
        }


        if ($query) {
            $this->LogData->saveData($this->actionName, '保存成功');
            $this->cache->clean();
            $_SESSION['tempInput'] = array();
            if ($this->isApi || $this->isAjaxPage) {
                $this->apiResponse['status'] = 'success';
                $this->apiResponse['msg'] = '操作成功！';
                echo json_encode($this->apiResponse);
                die();
            } else {
                $this->msg->success('操作成功！' . $cleanAdd);
            }
        } else {
            if ($this->isApi || $this->isAjaxPage) {
                if ($this->runAddSave === false && !empty($this->runAddSaveReason)) {
                    $errorMsg = $this->runAddSaveReason;
                } else {
                    $errorMsg = '发生异常，操作失败！';
                }
                $this->apiResponse['status'] = 'failed';
                $this->apiResponse['msg'] = $errorMsg;
                echo json_encode($this->apiResponse);
                die();
            } else {
                $this->msg->error('发生异常，操作失败！');
            }
        }
        $link = $this->_lastLink();

        if (!empty($link)) {
            header('location:' . $link);
        } else {
            $this->msg->to($this->router->class . '/add', '');
        }
    }

    /**
     * 执行编辑保存
     */
    public $runEditSave = true;

    /**
     * 如果 runEditSave 为 false
     * 触发了保存失败操作
     * 那么可以重置提示以说明原因
     */
    public $runEditSaveReason = '';

    /**
     * 编辑页面保存
     */
    public function editSave()
    {
        $this->load->library('form_validation');
        if (!count($this->editKey) > 0) {
            $this->msg->error('添加操作未开启');
            $this->msg->to($this->router->class . '/index', '');
        }

        $this->form_validation->set_rules($this->primaryKeyName, $this->keyNameList[$this->primaryKeyName], $this->keyVerifyList[$this->primaryKeyName]);
        foreach ($this->editKey as $k => $key) {
            if (in_array($this->keyTypeList[$key], array('hr', 'hrFirst', 'settingChu', 'shopFloor'))) {
                unset($this->editKey[$k]);
            }
        }
        $postData = array(
            $this->primaryKeyName => $this->input->post_get($this->primaryKeyName)
        );

        foreach ($this->editKey as $key) {
            if ($this->input->post_get($key) !== NULL) {
                $postData[$key] = $this->input->post_get($key);
            }
            if (isset($this->keyTypeList[$key]) && $this->keyTypeList[$key] == 'extraInput') {
                continue;
            }
            if (in_array($this->keyTypeList[$key], array('checkbox', 'yetai'))) {
                $this->form_validation->set_rules($key . '[]', $this->keyNameList[$key], $this->keyVerifyList[$key]);
            } else {
                $this->form_validation->set_rules($key, $this->keyNameList[$key], $this->keyVerifyList[$key]);
            }
        }
        $this->form_validation->set_rules($this->primaryKeyName, $this->keyNameList[$key], 'numeric|required');
        if ($this->form_validation->run() == FALSE && !$this->isApi) {
            $_SESSION[$this->router->class]['edit'] = $postData;
            $this->msg->error($this->form_validation->error_string());
            $this->msg->to($this->_lastLink(), '');
            return;
        }

        $saveData = array();
        foreach ($this->editKey as $key) {
            if ($this->input->post($key) === null) {
                continue;
            }
            if (isset($this->keyTypeList[$key]) && $this->keyTypeList[$key] == 'extraInput') {
                continue;
            }
            if (in_array($this->keyTypeList[$key], $this->needChangeType)) {
                if (in_array($this->keyTypeList[$key], array('checkbox', 'images', 'image', 'file', 'files'))) {
                    if (is_array($this->input->post($key))) {
                        $saveData[$key] = implode(',', array_filter($this->input->post($key)));
                    } else if ($this->input->post($key) !== NULL) {
                        $saveData[$key] = $this->input->post($key);
                    }
                    if (!isset($saveData[$key]) || $saveData[$key] === null) {
                        $saveData[$key] = '';
                    }
                } else {
                    $saveData[$key] = $this->input->post($key);
                }
            } else {

                $saveData[$key] = $this->input->post($key);
            }
            if (is_array($saveData[$key])) {

                $saveData[$key] = implode(',', array_filter($saveData[$key]));
            }
        }
        $this->_setSaveFix($saveData);
        $this->_beforeEditSave($saveData);
        if (count($saveData) > 0) {
            foreach ($saveData as $k => $v) {
                if ($v === NULL) {
                    unset($saveData[$k]);
                }
            }
        }

        $this->db->where($this->primaryKeyName, $this->input->post($this->primaryKeyName));
        $this->db->limit(1);
        if ($this->runEditSave) {
            $query = $this->db->update($this->tableName, $saveData);
        } else {
            $query = false;
        }

        if ($query) {
            if (isset($_SESSION[$this->router->class]['edit'])) {
                unset($_SESSION[$this->router->class]['edit']);
            }
            $this->cache->clean();
            $saveData[$this->primaryKeyName] = $this->input->post_get($this->primaryKeyName);
            $this->_afterEditSave($saveData);
            $this->msg->success('操作成功！');
            $this->LogData->saveData($this->actionName, '编辑成功');
            if ($this->isApi || $this->isAjaxPage) {
                $this->apiResponse['status'] = 'success';
                $this->apiResponse['msg'] = '操作成功！';
                echo json_encode($this->apiResponse);
                die();
            }
        } else {
            $errorMsg = '发生异常，操作失败！';
            if ($this->runEditSave === false && !empty($this->runEditSaveReason)) {
                $errorMsg = $this->runEditSaveReason;
            }

            if ($this->isApi || $this->isAjaxPage) {
                $this->apiResponse['status'] = 'failed';
                $this->apiResponse['msg'] = $errorMsg;
                $this->LogData->saveData($this->actionName, '编辑失败');
                echo json_encode($this->apiResponse);
                die();
            } else {
                $this->msg->error($errorMsg);
            }
        }

        $link = $this->_lastLink();
        if (!empty($link)) {
            header('location:' . $link);
        } else {
            $this->msg->to($this->router->class . '/index', '');
        }
    }

    public function _getServerAddPage($controllerName)
    {
        $html = '<script>' . "\n";
        $html .= '$(document).ready(function(){' . "\n";
        $html .= '$("body").loadModal("' . $controllerName . '","Add");' . "\n";
        $html .= '});';
        $html .= '</script>' . "\n";
        return $html;
    }

    /**
     * 给系统添加字段
     * @param string $key
     * @param string $listName
     * @param string $value
     * @param string $type
     * @param array $selectData
     * @param string $verify
     * @param string $sqlType
     * @return void
     */
    public function _addKeySet($key, $listName, $value = '', $type = "middleText", $selectData = array(), $verify = '', $sqlType = 'varchar')
    {
        $this->keyAddDefault[$key] = $value;
        $this->keyNameList[$key] = $listName;
        $this->keyTypeList[$key] = $type;
        $this->keySelectData[$key] = $selectData;
        $this->keyVerifyList[$key] = $verify;
        $this->keySqlType[$key] = $sqlType;
    }

    /**
     * 重置已经未进DATA字段里面的所有列表设定
     */
    public function _resetData(&$data)
    {
        $setArray = array('keyAddDefault', 'keyNameList', 'keyTypeList', 'keySelectData', 'keyVerifyList', 'keySqlType');
        foreach ($setArray as $item) {
            if (count($this->$item) > 0) {
                foreach ($this->$item as $k => $v) {
                    if (!isset($data[$item][$k])) {
                        $data[$item][$k] = $v;
                    }
                }
            }
        }

    }

    /**
     * 在某种特殊的需求下
     * 页面需要在某个段落载入一个指定的列表
     * 为了能够直接调用到指定的list 页面而不重写界面所用
     * 使用 ajax 载入目标页面获取内容
     * 自动填写URL 参数
     * @param string $controllerName 控制器名称
     * @param array $searchArray 需要查询的条件数组
     * @param array $listKey 列表需要显示的字段
     * @param string $operationHide hide|show
     * @return string $html  html with some javascript
     */
    public function _getServerListPage($controllerName = '', $searchArray = array(), $listKey = array(), $operationHide = '')
    {
        $baseParams = array(
            'dontsaveurl' => 1,
            'listAjaxPage' => 1,
            'operationHide' => $operationHide,
            'searchType' => 'searchPage'
        );
        $listArray = array();
        if (count($listKey) > 0) {
            foreach ($listKey as $key) {
                $listArray[] = urlencode('listKey[]') . '=' . urlencode($key);
            }
        }
        $paramsArray = array();
        $params = array_merge($baseParams, $searchArray);
        $rand = rand(10000, 99999);
        $params['randNum'] = $rand;
        foreach ($params as $key => $value) {
            $listArray[] = urlencode($key) . '=' . urlencode($value);

        }
        $paramsStr = implode('&', $listArray);
        $url = '/' . $controllerName . '/index?' . $paramsStr;

        $html = "<div id='divListTemp{$rand}'></div><script>";
        $html .= '
		     if(' . $controllerName . 'Functions === undefined){
				
		     var  ' . $controllerName . 'Functions = [];
	              }
		 ' . $controllerName . 'Functions.push( "load' . $controllerName . $rand . '");
                        function load' . $controllerName . $rand . '(){
				$.ajax({
					url:"' . $url . '",
					success:function(msg){$("#divListTemp' . $rand . '").html(msg)}
				});
                         }
						 
		function load' . $controllerName . ' (){
			for(var i in ' . $controllerName . 'Functions ){
				eval( ' . $controllerName . 'Functions[i]+"();");
			}
		}
                        $(document).ready(function(){
                                load' . $controllerName . $rand . '();
	               });';

        $html .= '</script>';
        return $html;
    }

    public function _beforeDetail(&$data)
    {

    }

    public function _beforeListQuery()
    {

    }

    public function _beforeList(&$data)
    {

    }

    public function _beforeAdd(&$data)
    {

    }

    public function _afterAddSave(&$data)
    {

    }

    public function _afterEditSave(&$data)
    {

    }

    public function _beforeEdit(&$data)
    {

    }

    public function _beforeAddSave(&$data)
    {

    }

    public function _beforeEditSave(&$data)
    {

    }

    public function _beforeRemove(&$data)
    {

    }

    /**
     * 关联权限
     */
    public $accessName = '';

    /**
     * 权限设定检查方法
     * @param string $accessName
     * @param bool $needReturn true|false
     * @return bool
     */
    public function _accessCheckStatus($accessName, $needReturn = true)
    {
        if ($this->usersystem->isSuperAdmin() === true) {
            return true;
        }
        $json = $this->usersystem->hasAccess($accessName, false, $needReturn);
        return $json === true;
    }

    /**
     * 权限设定检查
     */
    public function _accessCheck()
    {

        $accessName = $this->router->class;
        if (!empty($this->accessName)) {
            $accessName = $this->accessName;
        }
        $method = $this->router->method;
        if (in_array($method, array('index', 'detail'))) {
            $method = 'view';
        } else if (in_array($method, array('add', 'addSave', 'edit', 'editSave', 'excel', 'parseExcel'))) {
            $method = 'opt';
        } else if (in_array($method, array('remove'))) {
            $method = 'del';
        } else {
            $method = 'opt';
        }

        if ($this->usersystem->checkHasAccess($accessName . 'opt')) {
            $this->editAccess = true;
        }
        if ($this->usersystem->checkHasAccess($accessName . 'del')) {
            $this->deleteAccess = true;
        }
        $this->usersystem->hasAccess($accessName . $method, $this->isApi);
    }

    /**
     * 分页配置
     */
    public $pageConfig = array(
        'full_tag_open' => '<nav class="text-center"><ul class="pagination">',
        'full_tag_close' => '</ul></nav>',
        'num_tag_open' => '<li>',
        'num_tag_close' => '</li>',
        'cur_tag_open' => '<li class="active"><a href="#">',
        'cur_tag_close' => '</a></li>',
        'next_tag_open' => '<li>',
        'next_tag_close' => '</li>',
        'last_tag_open' => '<li>',
        'last_tag_close' => '</li>',
        'first_tag_open' => '<li>',
        'first_tag_close' => '</li>',
        'prev_tag_open' => '<li>',
        'prev_tag_close' => '</li>',
        'page_query_string' => TRUE,
        'first_link' => '首页',
        'prev_link' => '上一页',
        'last_link' => '尾页',
        'next_link' => '下一页',
        'num_links' => 3
    );

    /**
     * 模糊搜索分割关键词分割方法
     */
    public function _splitKeyword($string)
    {
        $split = array(',', ' ', "\t", "|");
        $tmp = array();
        foreach ($split as $s) {
            $tmp = array_merge($tmp, explode($s, $string));
        }
        return array_unique($tmp);
    }

    /**
     * Curl 请求
     * @param string $url 请求地址
     * @param string $token 当前token
     * @param array $params 请求参数
     * @param string 请求方式
     * @return string
     */
    public function _curl($url, $token, $params = array(), $type = 'GET')
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $params['token'] = $token;
        if ($type == 'GET') {
            $paramsStringArray = array();
            foreach ($params as $k => $v) {
                $paramsStringArray[] = urlencode($k) . '=' . urlencode($v);
            }
            $url .= '?' . implode('&', $paramsStringArray);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, 0);
        }
        if ($type == 'POST') {
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        }
        $output = curl_exec($ch);
        curl_close($ch);
        $output = @preg_replace("#\\\u([0-9a-f]+)#ie", "iconv('UCS-2', 'UTF-8', pack('H4', '\\1'))", $output);
        return $output;
    }

    /**
     * 用于查看数据库结构情况
     */
    public function dataTable()
    {
        if (ENVIRONMENT !== 'development') {
            $this->msg->success('数据库结构功能关闭');
        }
        $this->load->library('UserSystem');
        //获取 token
        $uid = $this->usersystem->get('id');
        $save = array(
            'uid' => $uid,
            'expire' => strtotime(date("Y-m-d") . ' 23:59:59'),
            'token' => md5($uid . date('Y-m-d'))
        );
        $this->db->replace('we_token', $save);
        $domain = 'http://' . $_SERVER['HTTP_HOST'] . '/';


        if (strstr('we_', $this->tableName) == -1) {
            $this->tableName = 'we_' . $this->tableName;
        }
        $this->_setViewData();
        $viewData = $this->viewData;
        $query = $this->db->query("desc " . $this->tableName);
        $tableInfo = $query->result_array();
        $keyType = array();
        if (count($tableInfo) > 0) {
            foreach ($tableInfo as $each) {
                $keyType[$each['Field']] = $each['Type'];
            }
        }

        $viewData['tableInfo'] = $keyType;
        $viewData['table'] = $tableInfo;
        $listUrl = $domain . $this->router->class . '/index';
        $viewData['listUrl'] = $listUrl;
        $viewData['listJson'] = $this->_curl($listUrl, $save['token']);
        $addUrl = $domain . $this->router->class . '/add';
        $viewData['addUrl'] = $addUrl;
        $viewData['addJson'] = $this->_curl($addUrl, $save['token']);
        $viewData['token'] = $save['token'];

        $path = APPPATH . '/views/api/' . strtolower($this->router->class) . '.php';
        if (!file_exists($path)) {
            $apiDocument = $this->load->view('default/apiDocument', $viewData, true);
            file_put_contents($path, $apiDocument);
        }
        $html = $this->load->view('default/dataTable', $viewData, true);
        $this->LogData->saveData($this->actionName, '编辑成功');
        echo $html;
    }

    /**
     * EXCEL 文件上传
     */
    public function excel()
    {
        $this->_setViewData();
        $viewData = $this->viewData;
        $this->load->view('default/excelUpload', $viewData);

    }

    /**
     * EXCEL 处理数据
     */
    public function _setFormatExcel(&$data)
    {

    }

    public $excelCheckKey = array();

    /**
     * EXCEL 解析
     */
    public function parseExcel()
    {
        ini_set('memory_limit', '512M');
        set_time_limit(0);
        $this->LogData->saveData($this->actionName, '数据导入');
        $this->cache->clean();
        $file = $this->input->post('excel');
        $tosql = $this->input->post('tosql');
        if (!empty($file)) {
            $_SESSION['sqlexportfile'] = $file;
        } else {
            if (isset($_SESSION['sqlexportfile'])) {
                $file = $_SESSION['sqlexportfile'];
                $tosql = 0;
            }
        }
        $file = APPPATH . '/..' . $file;
        if (!file_exists($file)) {
            $this->msg->error('找不到上传文件！');
            $this->msg->to($this->router->class . '/excel', '');
            return;
        }
        include_once APPPATH . '/third_party/PHPExcel/IOFactory.php';
        $objPHPExcel = PHPExcel_IOFactory::load($file);
        $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
        $sheetLine = count($sheetData);
        if (count($sheetData) <= 1) {
            $this->msg->error('空数据表格！');
            $this->msg->to($this->router->class . '/excel', '');
            return;
        }
        //默认第一行为字段行
        $lineFirst = $sheetData[1];
        unset($sheetData[1]);
        //格式化第一行
        $format = array();
        foreach ($lineFirst as $k => $v) {
            foreach ($this->keyNameList as $key => $name) {
                if ($v == $name || $v == $k) {
                    $format[$k] = $key;
                }
            }
        }
        //列名检查
        //echo "<pre>";
        //var_dump($format);
        //exit();
        //echo "</pre>";
        $saveData = array();
        $i = 0;
        //生成对应数据库的数据
        if (count($sheetData) > 0) {
            foreach ($sheetData as $eachLine) {

                if (empty($eachLine)) {
                    continue;
                }
                $i++;

                $tmp = array();
                foreach ($format as $k => $key) {
                    $eachLine[$k] = trim($eachLine[$k]);

                    $type = $this->keyTypeList[$key];
                    if (isset($this->keySelectData[$key]) && is_array($this->keySelectData[$key]) && !empty($this->keySelectData[$key])) {
                        foreach ($this->keySelectData[$key] as $search => $value) {
                            if ($eachLine[$k] == $value) {
                                $tmp[$key] = $search;
                            }
                        }
                        //continue;
                    }
                    if ($eachLine[$k] == 'NULL' || $eachLine[$k] == '--') {
                        $eachLine[$k] = '';
                    }
                    $tmp[$key] = $eachLine[$k];
                }

                $this->_setSaveFix($tmp);
                $saveData[] = $tmp;
            }
        }
        //二次检查
        $errorLine = array();
        if (count($saveData) > 0) {
            foreach ($saveData as $e => $eachLine) {
                foreach ($format as $k => $key) {
                    if (!isset($eachLine[$key])) {
                        $saveData[$e][$key] = '';
                    }
                }
                foreach ($this->listKey as $listKey) {
                    if (empty($eachLine[$listKey])) {
                        $errorLine[] = $saveData[$e];
                    }
                }
            }
        }
        $this->_setFormatExcel($saveData);
        $checkAllData = array();
        $needCheckKey = $this->excelCheckKey;


        if (count($needCheckKey) > 0) {
            foreach ($needCheckKey as $checkKey) {
                $checkAllData[$checkKey] = array();
            }
            foreach ($saveData as $e => $eachLine) {
                foreach ($needCheckKey as $checkKey) {
                    if (!isset($eachLine[$checkKey])) {
                        continue;
                    }
                    if (!is_numeric($eachLine[$checkKey]) && !empty($eachLine[$checkKey])) {
                        $checkAllData [$checkKey][] = $eachLine[$checkKey];
                    }
                }
            }
            foreach ($needCheckKey as $checkKey) {
                $checkAllData[$checkKey] = array_unique($checkAllData[$checkKey]);
                if (empty($checkAllData[$checkKey])) {
                    unset($checkAllData[$checkKey]);
                }
            }
        }


        $formatLine = count($saveData);
        if ($tosql == 1) {
            $count = 0;
            $err = 0;
            $errData = array();
            if (count($saveData) > 0) {
                foreach ($saveData as $each) {
                    try {
                        $query = $this->db->insert($this->tableName, $each);
                        if (!$query) {
                            throw new Exception('sql error');
                        }
                    } catch (Exception $e) {
                        $err++;
                        $errData[] = $each;
                    }
                    $count++;
                }
            }
            $content = "导入结果：总计{$count}条，失败{$err}条";
            $this->msg->success($content);
            if ($err == 0) {
                $this->msg->to($this->router->class . '/excel');
            } else {
                $this->_setViewData();
                $viewData = $this->viewData;
                $viewData['data'] = $errData;
                $viewData['format'] = $format;
                $this->load->view('default/excelView', $viewData);
            }
        } else {
            $this->_setViewData();
            $viewData = $this->viewData;
            $viewData['data'] = $saveData;
            $viewData['sheetLine'] = $sheetLine;
            $viewData['formatLine'] = $formatLine;
            $viewData['format'] = $format;
            $viewData['checkAllData'] = $checkAllData;
            $this->load->view('default/excelView', $viewData);
        }
    }

    /**
     * 导出EXCEL 功能开关
     */
    public $exportExcelOpen = false;

    public $exportKey = array();

    /**
     * 导出之前的重写
     */
    public function _beforeExport(&$data)
    {

    }

    /**
     * 导出EXCEL 功能
     */
    public function exportExcel()
    {
        if ($this->exportExcelOpen === false) {
            $this->msg->info('EXCEL 导出功能关闭');
            $this->msg->to($this->_lastLink());
            die();
        }
        $this->_setViewData();

        $viewData = $this->viewData;
        $this->db->from($this->tableName);
        $this->viewData = $this->_setViewData();
        $searchUrl = '';
        $this->_setListSearchKey($viewData, $searchUrl);
        $this->db->where($this->tableName.'.'.$this->isDelete, 0);

        $this->_setListSQL();
        $this->_beforeListQuery();
        $sql = $this->db->get_compiled_select();
        $query = $this->db->query($sql);
        $data = $query->result_array();
        if (empty($this->exportKey)) {
            $this->exportKey = $this->detailKey;
        }
        $filesType = array('image', 'images', 'file', 'files');


        foreach ($this->exportKey as $i => $key) {
            if (in_array($this->keyTypeList[$key], $filesType)) {
                unset($this->exportKey[$i]);
                continue;
            }
            if (!isset($this->keySelectData[$key])) {
                $this->keySelectData[$key] = array();
            }
        }

        if (count($data) > 0) {
            foreach ($data as $k => $line) {
                foreach ($this->exportKey as $i => $key) {
                    if (!isset($line[$key])) {
                        unset($this->exportKey[$i]);
                        continue;
                    }
                    $fname = $this->keyTypeList[$key] . 'Value';

                    if (in_array($this->keyTypeList[$key], $this->needChangeType)) {
                        $data[$k][$key] = TpForm::$fname($line[$key], $this->keySelectData[$key]);
                    }
                }
            }
        }

        $this->_beforeExport($data);
        $excelArray = array();
        $tmp = array();
        foreach ($this->exportKey as $key) {
            $tmp[$key] = $this->keyNameList[$key];
        }
        $excelArray[] = $tmp;
        if (count($data) > 0) {
            foreach ($data as $each) {
                $tmp = array();
                foreach ($this->exportKey as $key) {
                    $tmp[$key] = $each[$key];
                }
                $excelArray[] = $tmp;
            }
        }
        require 'vendor/autoload.php';
        $objPHPExcel = new \PHPExcel();
        $objSheet = $objPHPExcel->getActiveSheet();
        $objSheet->setTitle($this->controllerName);
        $objSheet->fromArray($excelArray);  //利用fromArray()直接一次性填充数据
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');   //设定写入excel的类型
        $path = './uploads/' . date('Y-m-d') . '/';

        if (!is_dir($path)) {
            mkdir($path);
        }
        $filename = $this->router->class . '-' . date('Y-m-d-h-i-s') . '.xlsx';
        $status = $objWriter->save($path . $filename);
        $file = $path . $filename;
        downFile($file, $filename);
    }


}

?>
