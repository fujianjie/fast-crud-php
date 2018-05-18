<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
        <head>
                <?php $this->load->view('common/meta'); ?>
                <?php
                $staticUrl = TpSystem::getParam('staticurl');
                ?>
                <link rel="stylesheet" href="<?php echo $staticUrl; ?>/static/css/form-element.css"/>
                <link rel="stylesheet" href="<?php echo $staticUrl; ?>/static/css/login.css"/>
        </head>
        <body>
                <div class="top-content">
                        <div class="inner-bg">
                                <div class="container">
                                        <div class="row">
                                                <div class="col-sm-8 col-sm-offset-2 text">
                                                        <h1><strong><?php echo TpSystem::getParam('sitename'); ?></strong></h1>
                                                        <div class="description">
                                                                <p><?php echo TpSystem::getParam('sitedesc'); ?></p>
                                                        </div>
                                                </div>
                                        </div>
                                        <div class="row">
                                                <div class="col-sm-6 col-sm-offset-3 form-box">
                                                        <div class="form-top">
                                                                <div class="form-top-left">
                                                                        <h3>首次登录</h3>
                                                                        <p><strong>第一次登陆需要重置密码</strong></p>
                                                                </div>
                                                                <div class="form-top-right">
                                                                        <i class="fa fa-key"></i>
                                                                </div>
                                                        </div>


                                                        <div class="form-bottom">
                                                                <p class="error-msg"><?php echo TpFlash::getError(); ?></p>
                                                                <form role="form" action="/login/doResetPassword" method="post" class="login-form" id="reset-form">
                                                                        <?php echo TpCsrf::hidden(); ?>
                                                                        <div class="form-group">
                                                                                <label class="sr-only" for="form-newpassword">新密码：</label>
                                                                                <input type="password" name="newpassword" placeholder="请输入6-20位字符密码" class="form-password form-control" id="form-newpassword" value=""/>
                                                                                <p class="error-msg"></p>
                                                                        </div>
                                                                        <div class="form-group">
                                                                                <label class="sr-only" for="password">再次输入：</label>
                                                                                <input type="password" name="password" placeholder="请输入6-20位字符密码" class="form-password form-control" id="form-password" value="">
                                                                                <p class="error-msg"> </p>
                                                                        </div>
                                                                        <button type="submit" class="btn">提交</button>
                                                                </form>
                                                        </div>
                                                </div>
                                        </div>
                                </div>
                        </div>
                </div>
                <div class="backstretch" >
                        <img src="/static/images/login-bg.jpg" />
                </div>
        </body>
</html>
<script>
        function setBackground() {
                var w = $(window).width();
                var h = $(window).height();
                $(".backstretch,.backstretch img").width(w).height(h);
        }
        $(document).ready(function() {
                setBackground();
                $(window).resize(function() {
                        setBackground();
                });
                $("#reset-form").resetPassword();
        });
</script>