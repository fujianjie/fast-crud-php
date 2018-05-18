<?php
        $idName = $className.'Edit';
?>
<div class="modal  bs-example-modal-lg" tabindex="-1" role="dialog" id="<?php echo $idName;?>">
        <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                        <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title"> <?php echo $controllerName; ?><small>编辑</small></h4>
                        </div>
                        <div class="modal-body">
                                <form class="form-horizontal addForm" node="add" role="form" method="post" action="/<?php echo $className ?>/editSave?dontsaveurl=1" id="data-form-<?php echo $className;?>">
                                        <input type="hidden" name="isAjaxPage" value="1"/>
                                        <input type="hidden" name="<?php echo $primaryKey; ?>" value="<?php echo $data[$primaryKey]; ?>" />
                                        <?php echo TpCsrf::hidden(); ?>
                                        <?php
                                        if (!in_array('hr', $keyTypeList) && !in_array('hrFirst', $keyTypeList)) {
                                                echo TpForm::hrFirst('<span>基本信息</span>', 'hr1', '', '', '');
                                        }
                                        if (count($editKey) > 0) {
                                                $keyEditDefault = $data;
                                                foreach ($editKey as $eachKey) {

                                                        echo "\n";
                                                        $formInputName = 'TpForm::' . $keyTypeList[$eachKey];
                                                        if (empty($keyEditDefault) || !isset($keyEditDefault[$eachKey])) {
                                                                $default = '';
                                                        } else {
                                                                $default = $keyEditDefault[$eachKey];
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
                                </form>
                        </div>
                        <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                                <button type="button" class="btn btn-info" node="formSave">保存</button>
                        </div>
                </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->

        <script>
                $('#<?php echo $idName;?>').on('show.bs.modal', function (e) {
                        if (self != parent) {
                                parent.showModal();
                                var top = $(parent).scrollTop();
                                $('#<?php echo $idName;?>').find('.modal-dialog').css('top', top + 'px');
                        }
                });

                $('#<?php echo $idName;?>').on('hidden.bs.modal', function (e) {
                        if (parent) {
                                parent.hideModal();
                        }
                        $('#<?php echo $idName;?>').remove();
                });
                $('#<?php echo $idName;?>').find('button[node=formSave]').bind('click', function () {
                        var form = $('#<?php echo $idName;?>').find('form');
                        var data = form.serialize();
                        var url = form.attr('action');
                        $.ajax({
                                type: 'post',
                                url: url,
                                data: data,
                                dataType:'json',
                                success: function (msg) {
                                    if(msg.status == 'failed'){
                                        alert(msg.msg);
                                    }else{
                                        $('#<?php echo $idName;?>').modal('hide');
                                        if (typeof( load<?php echo $className?>) == 'function') {
                        load<?php echo $className?>();
                    }
                                        if (typeof(<?php echo $className ?>AfterEdit) == 'function') {
                                            <?php echo $className ?>AfterEdit();
                                        }
                                        if (parent) {
                                            parent.hideModal();
                                        }
                                        $('#<?php echo $idName;?>').remove();

                                    }

                                }
                        });
                });
                $('#<?php echo $idName;?>').modal('show');
                $("#data-form-<?php echo $className;?>").submit(function(){
                    var form = $('#<?php echo $idName;?>').find('form');
                    var data = form.serialize();
                    var url = form.attr('action');
                    $.ajax({
                        type: 'post',
                        url: url,
                        data: data,
                        dataType:'json',
                        success: function (msg) {
                            if(msg.status == 'failed'){
                                alert(msg.msg);
                            }else{
                                $('#<?php echo $idName;?>').modal('hide');
                                if (typeof( load<?php echo $className?>) == 'function') {
                                    load<?php echo $className?>();
                                }
                                if (typeof(<?php echo $className ?>AfterEdit) == 'function') {
                                    <?php echo $className ?>AfterEdit();
                                }

                                $('#<?php echo $idName;?>').remove();

                            }

                        }
                    });
                    return false;
                });
        </script>
</div>