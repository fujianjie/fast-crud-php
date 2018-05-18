<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
        <head>
                <?php $this->load->view('common/meta'); ?>
        </head>
        <body class="inframe">
                <div class="container-fluid inframe">
                        <?php $this->load->view('msg/info'); ?>
                        <div class="page-header row">
                                <div class="col-lg-4">
                                        <h3 class="m-top-0">
                                                <?php echo $controllerName; ?>
                                                <small>查看</small>
                                        </h3>

                                </div>
                                <div class='col-lg-4 pull-right text-right mobile-hide'>
                                        <a href="<?php echo $referer; ?>" class='btn btn-default'>返回上一页</a>
                                </div>
                        </div>
                        <form class="form-horizontal detailPage" role="form" id="data-form">
                                <?php
                                if (!in_array('hr', $keyTypeList) && !in_array('hrFirst', $keyTypeList)) {
                                        echo TpForm::hrFirstValue('基本信息', 'hr1', '', '', '');
                                }
                                if (count($detailKey) > 0) {
                                        foreach ($detailKey as $k) {
                                                $fname = $keyTypeList[$k] . 'Value';
                                                if ($keyTypeList[$k] == 'html') {
                                                        echo $data[$k];
                                                        continue;
                                                }
                                                $filesType = array('image', 'images', 'file', 'files');
                                                if (in_array($keyTypeList[$k], $filesType)) {
                                                        echo '<div class="form-group imageInput">';
                                                        echo '<label class="col-sm-3 text-right ' . $fname . '">';
                                                        echo $keyNameList[$k];
                                                        echo '：</label><div class="col-sm-9">';
                                                        echo TpForm::$fname($data[$k], $keySelectData[$k]);
                                                        echo '</div></div><div></div>';
                                                        continue;
                                                }
                                                if ($keyTypeList[$k] == 'textarea') {
                                                        echo '<div class="form-group imageInput">';
                                                        echo '<label class="col-sm-3 text-right ' . $fname . '">';
                                                        echo $keyNameList[$k];
                                                        echo '：</label><div class="col-sm-9">';
                                                        echo $data[$k];
                                                        echo '</div></div><div></div>';
                                                        continue;
                                                }
                                                if ($keyTypeList[$k] == 'shopTrans') {
                                                        echo TpForm::shopTransValue($data[$k], $keySelectData[$k]);
                                                        continue;
                                                }
                                                if ($keyTypeList[$k] == 'floorInfo') {
                                                        echo $data[$k];
                                                        continue;
                                                }
                                                if ($keyTypeList[$k] == 'shopFloor') {
                                                        echo TpForm::shopFloorValue($data[$k], $keySelectData[$k]);
                                                        continue;
                                                }
                                                if ($keyTypeList[$k] == 'question') {
                                                        echo TpForm::questionValue($data[$k], $keySelectData[$k], $keyNameList[$k]);
                                                        continue;
                                                }
                                                if ($keyTypeList[$k] == 'hr' || $keyTypeList[$k] == 'hrFirst') {
                                                        // $fname = $keyTypeList[$k] . 'Value';
                                                        echo TpForm::$fname($keyNameList[$k], $keySelectData[$k]);
                                                        continue;
                                                }
                                                ?>
                                                <div class="form-group">
                                                        <label class="col-sm-3 text-right <?php echo $fname; ?>"><?php echo $keyNameList[$k]; ?>：</label>

                                                        <div class="col-sm-9">
                                                                <?php
                                                                if (in_array($keyTypeList[$k], $needChangeType)) {
                                                                        // $fname = $keyTypeList[$k] . 'Value';
                                                                        echo "<div class=' text-left'>" . TpForm::$fname($data[$k], $keySelectData[$k]) . "</div>";
                                                                } else {
                                                                        echo "<div class=' text-left'>{$data[$k]}</div>";
                                                                }
                                                                ?>
                                                        </div>
                                                </div>
                                                <?php
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

                        </form>
                        <div class='mobile-only'>
                                <a href="<?php echo $referer; ?>" class='btn btn-default btn-block'>返回上一页</a>
                        </div>
                </div>
                <?php $this->load->view('common/delModal'); ?>
                <?php $this->load->view('common/iframefooter'); ?>
        </body>
</html>

<script>
        $(document).ready(function () {
                if (self != top) {
                        parent.setNav('<?php echo empty($navName) ? $controllerName : $navName; ?>');
                }
                $('body').hrFloat();
        });
</script>