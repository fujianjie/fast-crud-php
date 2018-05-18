<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
        <head>
                <?php $this->load->view('common/meta'); ?>
        </head>
        <body style="background: #fff;">
                <div class="container-fluid">
                        <?php $this->load->view('msg/info'); ?>
                        <h2>修改密码</h2>
 
                        <p class="error-msg"></p>
                        <form class="form-horizontal" role="form" method="post" action="/UserSetting/doChangePass" id="changepass-form">
                                <?php echo TpCsrf::hidden(); ?>
                                <div class="form-group">
                                        <label class="col-sm-2 control-label" for="form-oldpassword">旧密码：</label>
                                        <div class="col-sm-10">
                                                <div class="col-sm-2">
                                                        <input type="password" name="oldpassword" placeholder="请输入6-20位字符密码" class="form-password form-control" id="form-oldpassword" value=""/>
                                                </div>
                                                <p class=" col-sm-12 error-msg"></p>
                                        </div>

                                </div>
                                <div class="form-group">
                                        <label class="col-sm-2 control-label" for="form-newpassword">新密码：</label>
                                        <div class="col-sm-10">
                                                <div class="col-sm-2">
                                                        <input type="password" name="newpassword" placeholder="请输入6-20位字符密码" class="form-password form-control" id="form-newpassword" value=""/>
                                                </div>
                                                <p class=" col-sm-12 error-msg"></p>
                                        </div>

                                </div>
                                <div class="form-group">
                                        <label class="col-sm-2 control-label" for="form-password">再次输入：</label>
                                        <div class="col-sm-10">
                                                <div class="col-sm-2">
                                                        <input type="password" name="password" placeholder="请输入6-20位字符密码" class="form-password form-control" id="form-password" value="">
                                                        <p class="col-sm-12 error-msg"> </p>
                                                </div>

                                        </div>
                                </div>
                                <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                                <button type="submit" class="btn btn-info">提交</button>
                                        </div>
                                </div>
                        </form>
                </div>
        </body>
</html>
<?php $this->load->view('common/iframefooter'); ?>
<script>
        $(document).ready(function() {
                $("#changepass-form").oldPassword();
        });
</script>