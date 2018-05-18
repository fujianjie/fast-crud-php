<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php $this->load->view('common/meta'); ?>
    <link rel="stylesheet" href="/static/css/jquery-ui.css">
    <script src="/static/js/jquery-ui.js"></script>
</head>
<body class="inframe">
<div class="container-fluid inframe">
    <?php $this->load->view('msg/info'); ?>
    <div class="page-header row">
        <div class="col-lg-4">
            <h3 class="m-top-0">
                <?php echo $controllerName; ?>
                <small>编辑</small>
            </h3>
        </div>
        <div class='col-lg-4 pull-right text-right mobile-hide'>
            <a href="<?php echo $referer; ?>" class='btn btn-default'>返回上一页</a>
        </div>
    </div>

    <form class="form-horizontal editForm" node="edit" role="form" method="post" action="/<?php echo $className ?>/editSave?dontsaveurl=1" id="data-form">
        
        <?php
        if ($this->input->post_get('lastLink') !== null) {
            echo '<input type="hidden" name="lastLink" value="' . $this->input->post_get('lastLink') . '"/>';
        }
        ?>
        <input type="hidden" name="<?php echo $primaryKey; ?>" value="<?php echo $data[$primaryKey]; ?>"/>
        <?php echo TpCsrf::hidden(); ?>
        <?php
        if (!in_array('hr', $keyTypeList) && !in_array('hrFirst', $keyTypeList)) {
            echo TpForm::hrFirst('基本信息', 'hr1', '', '', '');
        }
        if (count($editKey) > 0) {
            $keyAddDefault = $data;
            foreach ($editKey as $eachKey) {

                echo "\n";
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
                echo "\n";
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
                <button type="reset" class="btn btn-warning"><span class="glyphicon glyphicon-remove"></span> 清除
                </button>
            </div>
        </div>
    </form>
    <div class='mobile-only m-bottom-30'>
        <a href="<?php echo $referer; ?>" class='btn btn-default btn-block'>返回上一页</a>
    </div>
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
        $('body').hrFloat();

        $("input[type=date]").attr('type', 'text').datepicker({changeYear: true, changeMonth: true});
    });
</script>