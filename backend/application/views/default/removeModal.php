<?php
$idName = $className . 'Remove';
$removeUrl = "/{$className}/remove?{$primaryKey}={$data[$primaryKey]}";
?>

<div class="modal fade" id="<?php echo $idName; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
                <div class="modal-content">
                        <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span
                                                aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                <h4 class="modal-title" id="myModalLabel">信息提示</h4>
                        </div>
                        <div class="modal-body">
                                <p>您真的要删除该信息吗？</p>
                                <?php
                                if (!in_array('hr', $keyTypeList) && !in_array('hrFirst', $keyTypeList)) {
                                        echo TpForm::hrFirstValue('<span>基本信息</span>', 'hr1', '', '', '');
                                }
                                if (count($detailKey) > 0) {
                                        foreach ($detailKey as $k) {
                                            if($keyTypeList[$k] == 'hr'||$keyTypeList[$k] == 'hrFirst'){
                                                $keyNameList[$k] = '<span>'.$keyNameList[$k].'</span>';
                                            }
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
                                if (isset($GLOBALS['hropen']) && $GLOBALS['hropen']) {
                                        echo "<div class='clearfix'></div></div>";
                                }
                                ?>
                        </div>
                        <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                                <button type="button" class="btn btn-danger" link="<?php echo $removeUrl; ?>" id="<?php echo $idName; ?>DeleteLink">删除</button>
                        </div>
                </div>
        </div>
        <script>
                $('#<?php echo $idName; ?>').on('show.bs.modal', function (e) {
                        if (self != parent) {
                                parent.showModal();
                                var top = $(parent).scrollTop();
                                $('#<?php echo $idName; ?>').find('.modal-dialog').css('top', top + 'px');
                        }
                });

                $('#<?php echo $idName; ?>').on('hidden.bs.modal', function (e) {
                        if (parent) {
                                parent.hideModal();
                        }
                        $('#<?php echo $idName; ?>').remove();
                });
                $("#<?php echo $idName ?>").modal('show');
                $("#<?php echo $idName; ?>DeleteLink").bind('click', function () {
                        $.ajax({
                                url: $(this).attr('link'),
                                success: function (msg) {
                                        $('#<?php echo $idName; ?>').modal('hide');
                                        if (typeof (load<?php echo $className ?>) == 'function') {
                                                load<?php echo $className ?>();
                                        }
                                        if (typeof(<?php echo $className ?>AfterEdit) == 'function') {
                                            <?php echo $className ?>AfterEdit();
                                        }
                                        if (parent) {
                                                parent.hideModal();
                                        }
                                        $('#<?php echo $idName; ?>').remove();
                                }
                        })
                });

        </script>
</div>