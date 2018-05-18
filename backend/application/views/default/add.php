<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
        <head>
                <?php $this->load->view('common/meta'); ?>
                <script>
                        var autofill = false;
                </script>
                <link rel="stylesheet" href="/static/css/jquery-ui.css">
                <script src="/static/js/jquery-ui.js"></script>
        </head>
        <body class="inframe">
                <div class="container-fluid inframe">
                        <?php $this->load->view('msg/info'); ?>
                        <a class="hrA" name="top" >&nbsp;</a>
                        <div class="page-header row">
                                <div class="col-lg-4">
                                        <h3 class="m-top-0">
                                                <?php echo $controllerName; ?>
                                                <small>新增</small>
                                        </h3>
                                </div>
                                <div class='col-lg-4 pull-right text-right mobile-hide' >
                                        <a href="<?php echo $referer; ?>" class='btn btn-default' >返回上一页</a>
                                </div>
                        </div>

                        <form class="form-horizontal addForm" node="add" role="form" method="post" action="/<?php echo $className ?>/addSave?dontsaveurl=1" id="data-form">
                                <?php
                                        if($this->input->post_get('lastLink')!==null){
                                                echo '<input type="hidden" name="lastLink" value="'.$this->input->post_get('lastLink').'"/>';
                                        }
                                ?>
                                
                                <?php echo TpCsrf::hidden(); ?>
                                <?php
                                if (!in_array('hr', $keyTypeList) && !in_array('hrFirst', $keyTypeList)) {
                                        echo TpForm::hrFirst('基本信息', 'hr1', '', '', '');
                                }
                                if (count($addKey) > 0) {
                                        foreach ($addKey as $eachKey) {
                                                echo "\n\n";
                                                $formInputName = 'TpForm::' . $keyTypeList[$eachKey];
                                                if (empty($keyAddDefault) || !isset($keyAddDefault[$eachKey])) {
                                                        $default = '';
                                                } else {
                                                        $default = $keyAddDefault[$eachKey];
                                                }

                                                if (empty($keySelectData) || !isset($keySelectData[$eachKey])) {
                                                        $selectData = '';
                                                } else {
                                                        $selectData = $keySelectData[$eachKey];
                                                }
                                                if (empty($keyNeed) || !isset($keyNeed[$eachKey])) {
                                                        $need = true;
                                                } else {
                                                        $need = $keyNeed[$eachKey];
                                                }
                                                if (is_callable('TpForm', $keyTypeList[$eachKey])) {
                                                        $labelName = $keyNameList[$eachKey];
                                                        if ($need) {
                                                                $labelName = "<span class='need'>*</span>" . $labelName;
                                                        }
                                                        echo TpForm::$keyTypeList[$eachKey]($labelName, $eachKey, $default, $selectData, $need);
                                                } else {
                                                        echo "<div class=\"form-group\"><p>{$formInputName} not exist</p></div>";
                                                }
                                        }
                                }
                                ?>
                                <?php
                                if (isset($GLOBALS['hropen']) && $GLOBALS['hropen']) {
                                        echo "<div class='clearfix'></div></div>";
                                }
                                if (isset($extraHtml)) {
                                        echo $extraHtml;
                                }
                                ?>
                                <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10 submitGroup">
                                                <button type="submit" class="btn btn-info"><span class="glyphicon glyphicon-ok"></span> 提交</button>
                                                <button type="reset" class="btn btn-warning"><span class="glyphicon glyphicon-remove"></span> 清除</button>
                                        </div>
                                </div>
                                <div class='mobile-only m-bottom-30'  >
                                        <a href="<?php echo $referer; ?>" class='btn btn-default btn-block' >返回上一页</a>
                                </div>
                        </form>
                </div>
                <?php $this->load->view('common/iframefooter'); ?>
               
        </body>
</html>

<script>
        var pageController = '<?php echo $className; ?>';
        $(document).ready(function () {
                if (self != top) {
                        parent.setNav('<?php echo empty($navName) ? $controllerName : $navName; ?>');
                }
                $("input[type=text]:first").focus();
                $('body').hrFloat();
                var str = $("#data-form").attr('action');
                var key = str.replace(/\//g, '');
                if (!autofill && localStorage) {
                        delete localStorage[key];
                }

                if (localStorage) {
                        $("#data-form").submit(function () {
                                var data = $(this).serializeArray();
                                localStorage[key] = JSON.stringify(data);
                                return true;
                        });
                }
                if (localStorage && autofill) {
                        return;
                        if (localStorage[key] !== undefined) {
                                var datastr = localStorage[key];
                                var data = JSON.parse(datastr);
                                for (var i in data) {

                                        var name = data[i].name;
                                        var value = data[i].value;
                                       // console.log(name + '=' + value);
                                        if (name == 'csrf_test_name') {
                                                continue;
                                        }
                                        var obj = $("#data-form").find("[name=" + name + "]");
                                        if (name.indexOf('temp-') != -1) {
                                                if (value == '') {
                                                        continue;
                                                }
                                        }

                                        if (obj.length == 0) {
                                                continue;
                                        }
                                        if (obj.val() == '' || obj.val() == 0) {
                                                if (obj.attr('selecttype') != undefined) {
                                                        if (obj.val() == '') {
                                                                name = 'temp-' + obj.attr('selecttype');
                                                                var newobj = $("#data-form").find("[name=" + name + "]");
                                                                if (newobj.length > 0) {
                                                                        newobj.val(value).keyup();
                                                                } else {
                                                                        obj.val(value)
                                                                }
                                                        }
                                                } else {
                                                        obj.val(value).keyup();
                                                }
                                        }
                                }

                        }
                }
                /*
                $("form[node=add]").submit(function () {
                        if ($(this).find('input[type=file]').length > 0) {
                                if ($(this).find('input[type=file]').val() != '') {
                                        alert('请先上传文件后提交.')
                                        return false;
                                }
                                $(this).find('input[type=file]').remove();
                        }
                });*/
                $("input[type=date]").attr('type','text').datepicker({changeYear:true,changeMonth:true});
        });
</script>