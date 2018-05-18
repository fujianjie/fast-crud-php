<div class="modal  bs-example-modal-lg" tabindex="-1" role="dialog" id="<?php echo $className; ?>Add">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"> <?php echo $controllerName; ?>
                    <small>新增</small>
                </h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal addForm" node="add" role="form" method="post" action="/<?php echo $className ?>/addSave?dontsaveurl=1" id="data-form-<?php echo $className; ?>">
                    <input type="hidden" name="isAjaxPage" value="1" />
                    <?php echo TpCsrf::hidden(); ?>
                    <?php
                    if (!in_array('hr', $keyTypeList) && !in_array('hrFirst', $keyTypeList)) {
                        echo TpForm::hrFirst('<span>基本信息</span>', 'hr1', '', '', '');
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
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-info" node="formSave">保存</button>
            </div>
        </div>
    </div>

    <script>
        var modelSave = true;
        $('#<?php echo $className; ?>Add').on('show.bs.modal', function (e) {
            if (self != parent) {
                parent.showModal();
                var top = $(parent).scrollTop();
                $('#<?php echo $className; ?>Add').find('.modal-dialog').css('top', top + 'px');
            }
            if(typeof(<?php echo $className; ?>AddShowModal) == 'function'){
                    <?php echo $className; ?>AddShowModal();
            }
        });

        $('#<?php echo $className; ?>Add').on('hidden.bs.modal', function (e) {
            if (parent) {
                parent.hideModal();
            }
        });
        var <?php echo $className; ?>AddHtml = $('#<?php echo $className; ?>Add').html();
        $('#<?php echo $className; ?>Add').find('button[node=formSave]').unbind('click').bind('click', function () {
            $('#<?php echo $className; ?>Add').modal('hide');
            var form = $('#<?php echo $className; ?>Add').find('form');
            var data = form.serialize();


            var dataArray =  form.serializeArray();
            if (typeof(setData<?php echo $className?>) != 'undefined') {
                setData<?php echo $className?>(dataArray);
            }
            if(!modelSave){
                modelSave = true;

                return;
            }
            var url = form.attr('action');
            $.ajax({
                type: 'post',
                url: url,
                data: data,
                dataType:'json',
                success: function (msg) {
                    if(msg.status == 'failed'){
                        alert(msg.msg);
                        return;
                    }
                    if (typeof( load<?php echo $className?>) == 'function') {
                        load<?php echo $className?>();
                    }
                    $('#<?php echo $className; ?>Add').html(<?php echo $className; ?>AddHtml);
                    <?php
                        if(isset($extraHtml)){
                            echo "{$className}ExtraScript(msg,dataArray);\n";
                        }
                    ?>
                }
            });
        });
        $("#data-form-<?php echo $className; ?>").submit(function(){
            $('#<?php echo $className; ?>Add').modal('hide');
            var form = $('#<?php echo $className; ?>Add').find('form');
            var data = form.serialize();


            var dataArray =  form.serializeArray();
            if (typeof(setData<?php echo $className?>) != 'undefined') {
                setData<?php echo $className?>(dataArray);
            }
            if(!modelSave){
                modelSave = true;

                return;
            }
            var url = form.attr('action');
            $.ajax({
                type: 'post',
                url: url,
                data: data,
                dataType:'json',
                success: function (msg) {
                    $('#<?php echo $className; ?>Add').modal('hide');
                    if(msg.status == 'failed'){
                        alert(msg.msg);
                        return;
                    }
                    if (typeof( load<?php echo $className?>) == 'function') {
                        load<?php echo $className?>();
                    }
                    $('#<?php echo $className; ?>Add').html(<?php echo $className; ?>AddHtml);
                    <?php
                    if(isset($extraHtml)){
                        echo "{$className}ExtraScript(msg,dataArray);\n";
                    }
                    ?>
                }
            });
            return false;
        });
    </script>
</div>
<?php
if(isset($extraHtml)){
    echo $extraHtml;
}
?>