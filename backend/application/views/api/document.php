<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
        <head>
                <meta charset="utf-8"/>
                <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
                <meta name="viewport" content="width=device-width, initial-scale=1"/>
                <?php
                $staticUrl = TpSystem::getParam('staticurl');
                ?>
                <link rel="stylesheet" href="<?php echo $staticUrl; ?>/static/css/bootstrap.min.css"/>
                <link rel="stylesheet" href="<?php echo $staticUrl; ?>/static/css/bootstrap-theme.min.css"/>
                <link rel="stylesheet" href="<?php echo $staticUrl; ?>/static/css/font-awesome.min.css">
                <script src="<?php echo $staticUrl; ?>/static/js/jquery-3.1.1.min.js"></script>
                <script src="<?php echo $staticUrl; ?>/static/js/bootstrap.min.js"></script>
                <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
                <!--[if lt IE 9]>
                <script src="<?php echo $staticUrl; ?>/static/js/html5shiv.js"></script>
                <script src="<?php echo $staticUrl; ?>/static/js/respond.min.js"></script>
                <![endif]-->
                <title><?php echo TpSystem::getParam('sitename'); ?></title>
                <meta name="description" content="<?php echo TpSystem::getParam('sitekeywords'); ?>"/>
                <meta name="keywords" content="<?php echo TpSystem::getParam('sitedesc'); ?>"/>

        </head>
        <body >
                <div class="container">
                        <div class="page-header row">
                                <div class="col-lg-4">
                                        <h3 class="m-top-0">API 接口说明</h3>
                                </div>
                        </div>
                        <div class="over-main">
                                <div class="nav-block">
                                        <ul class="nav nav-pills" role="tablist" id="nav">
                                        </ul>
                                </div>

                                <div class="main">
                                        <div class="alert alert-info" role="alert">
                                                <strong>请求方式：</strong>POST数据格式 application/x-www-form-urlencoded<br/>
                                                <strong>返回方式：</strong>JSON
                                        </div>
                                        <hr/>
                                        <h4  id="1F">用户登录获取TOKEN</h4>
                                        <pre>请求地址：<?php echo $staticUrl; ?>/login/apiLogin</pre>
                                        <p>参数说明</p>
                                        <table class="table table-hover">
                                                <thead>
                                                        <tr>
                                                                <th width="150">参数</th>
                                                                <th>说明</th>
                                                        </tr>
                                                </thead>
                                                <tbody >
                                                        <tr>
                                                                <td>username</td>
                                                                <td>用户名必须是11位手机号码</td>
                                                        </tr>
                                                        <tr>
                                                                <td>password</td>
                                                                <td>密码需要包含符号，英文大小写字母，6-20位字符</td>
                                                        </tr>
                                                </tbody>
                                        </table>
                                        <p>返回说明</p>
                                        <pre>{"status":"success","msg":"","data":{"token":"bb3f166b2524f78f29e921376cdda6e9","expire":1484089199}}</pre>
                                        <table class="table table-hover">
                                                <thead>
                                                        <tr>
                                                                <th width="150">参数</th>
                                                                <th>说明</th>
                                                        </tr>
                                                </thead>
                                                <tbody >
                                                        <tr>
                                                                <td>status</td>
                                                                <td>请求结果  success|failed</td>
                                                        </tr>
                                                        <tr>
                                                                <td>msg</td>
                                                                <td>出错时显示错误内容</td>
                                                        </tr>
                                                        <tr>
                                                                <td>data</td>
                                                                <td>成功时返回的数据内容</td>
                                                        </tr>

                                                        <tr>
                                                                <td>token</td>
                                                                <td>会话秘钥 有效期为expire  超过请重新申请会话</td>
                                                        </tr>

                                                        <tr>
                                                                <td>expire</td>
                                                                <td>有效期  时间戳</td>
                                                        </tr>
                                                </tbody>
                                        </table>
                                        <div class="alert alert-danger" role="alert">
                                                请注意，之后的所有接口都需要将登陆所获得的TOKEN作为参数之一做POST<br>
                                                返回结果内status 默认为请求状态,data 默认为请求数据内容,msg为错误提示，<strong>下文不再重复</strong><br/>
                                                如果某个字段是经过系统处理的，字段显示为字段关联的内容，添加字段键 加上_id   为字段原文
                                        </div>
                                </div>
                        </div>
                </div>
        </body>
</html>
<style>
        body{background: #fff;}
        table td,table th{text-align: left;}
        .string { color: green; }
        .number { color: darkorange; }
        .boolean { color: blue; }
        .null { color: magenta; }
        .key { color: red; }
        pre{outline: 1px solid #ccc; padding: 5px; margin: 5px;}
        .nav>li>a{color:#428bca;}
        .nav>li>a:hover{color:#fff;}
        .nav-block{width: 20%; float:left; }
        h4{padding-top: 50px;}
        #nav{top:initial; position:inherit;  }
        #nav li{display: block;width: 100%;}
        .main{float:left;width:80%;}
</style>
<script>
        function formatter(string) {
                var result = '', pos = 0, prevChar = '', outOfQuotes = true;
                for (var i = 0; i < string.length; i++) {
                        var char = string.substring(i, i + 1);
                        if (char == '"' && prevChar != '\\') {
                                outOfQuotes = !outOfQuotes;
                        } else if ((char == '}' || char == ']') && outOfQuotes) {
                                result += "\n";
                                pos--;
                                for (var j = 0; j < pos; j++)
                                        result += '  ';
                        }
                        result += char;
                        if ((char == ',' || char == '{' || char == '[') && outOfQuotes) {
                                result += "\n";
                                if (char == '{' || char == '[')
                                        pos++;
                                for (var j = 0; j < pos; j++)
                                        result += '  ';
                        }
                        prevChar = char;
                }
                return result;
        }

        function syntaxHighlight(json) {
                if (typeof json != 'string') {
                        json = JSON.stringify(json, undefined, 2);
                }
                json = json.replace(/&/g, '&').replace(/</g, '<').replace(/>/g, '>');
                return json.replace(/("(\\u[a-zA-Z0-9]{4}|\\[^u]|[^\\"])*"(\s*:)?|\b(true|false|null)\b|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?)/g, function (match) {
                        var cls = 'number';
                        if (/^"/.test(match)) {
                                if (/:$/.test(match)) {
                                        cls = 'key';
                                } else {
                                        cls = 'string';
                                }
                        } else if (/true|false/.test(match)) {
                                cls = 'boolean';
                        } else if (/null/.test(match)) {
                                cls = 'null';
                        }
                        if (cls == 'string') {
                                var j = '{"str":' + match + '}';
                                //console.log(JSON.parse(j));
                                var p = JSON.parse(j);
                                match = '"' + p.str + '"';
                        }
                        return '<span class="' + cls + '">' + match + '</span>';
                });
        }
        $(document).ready(function () {
                $("pre").each(function () {
                        $(this).html(syntaxHighlight(formatter($(this).html())));
                })
                $("h4").each(function () {
                        var title = $(this).html();
                        var html = '<li role="presentation"><a href="#' + $(this).attr('id') + '">' + $(this).html() + '</a></li>';
                        $("#nav").append(html);
                })
                //$("h4").css('padding-top', $("#nav").height() + "px")
        });
</script>
