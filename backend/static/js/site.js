/**
 * 网站通用JS 部分
 * @version  0.1
 */

/**
 * 包含全角字符的字符串长度,全角字符算2个字符
 * string.gblen();
 * */
var autoInput;
String.prototype.gblen = function () {
    var len = 0;
    for (var i = 0; i < this.length; i++) {
        if (this.charCodeAt(i) > 127 || this.charCodeAt(i) == 94) {
            len += 2;
        } else {
            len++;
        }
    }
    return len;
}

function showGallery(items, options) {
    var pswpElement = document.querySelectorAll('.pswp')[0];
    var gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, options);
    gallery.init();
}

function showModal() {
    $("#bgModal").modal('show');
    $("#topnav").css('zIndex', '1040');
    $("#iframe").css('border', "1px solid #000");
}

function hideModal() {
    $("#bgModal").modal('hide');
    $("#topnav").css('zIndex', '1042');
    $("#iframe").css('border', "1px solid #e6e9ed");
}

function setNavInit() {
    var sidebar = $(".sidebar");
    if (sidebar.length == 0) {
        return;
    }
    sidebar.find('.nav-sidebar').find('[node=caret]').each(function () {
        var a = $(this).parents('a');
        var _this = a.parents('li');

        var li = $(this).parents('ul').find('li.son');

        a.unbind('click').bind('click', function () {
            li.toggle(0, function () {
                if (li.css('display') != 'none') {
                    _this.addClass('libg');
                } else {
                    _this.removeClass('libg');
                }

            });
        });
    });
    $("#navbar").find('a').bind('click', function () {
        if ($(window).width() < 415) {
            $(".navbar-toggle").click();
        }
    });
    $("#sidebar-toggle").bind('click', function () {
        $("#sidebar").toggle();
        $("body").resetPageWH();
    })
    $("#sidebar").find("a").bind('click', function (event) {
        event.preventDefault();
        var href = $(this).attr('href');
        if (href != '#') {
            $("#iframe").attr('src', $(this).attr('href'));
        }
    });

}

function hideSidebar() {
    $("#sidebar").hide();
    $("body").resetPageWH();
}

function setNav(name) {
    var sidebar = $(".sidebar");
    if (sidebar.length == 0) {
        return;
    }
    sidebar.find('li.libg').removeClass('libg');
    sidebar.find('.son').hide().removeClass('active');
    sidebar.find('.son').each(function () {
        var a = $(this).find('a');
        if (a.length > 0) {
            var html = a.html();
            if (html.indexOf(name) > -1) {
                a.parents('li').addClass('active');
                a.parents('ul.nav-sidebar').find('.son').show();
                a.parents('ul.nav-sidebar').find('li:eq(0)').addClass('libg');
            }
        }

    });

}

/**
 * 用户登录表单
 * */
$.fn.extend({
    size: function () {
        return this.length;
    },
    loginForm: function (username, password) {
        var _this = this;
        if (username === undefined) {
            username = 'username';
        }
        if (password === undefined) {
            password = 'password';
        }
        var input_username = _this.find('input[name=' + username + ']');
        var input_username_group = input_username.parents('.form-group');
        var input_password = _this.find('input[name=' + password + ']');
        var input_password_group = input_password.parents('.form-group');

        function checkUserName(str) {
            var v = verify_mobile(str);
            input_username_group.removeClass('has-error');
            input_username_group.removeClass('has-success');
            if (!v.status) {
                input_username_group.addClass('has-error');
                input_username_group.find('p.error-msg').html(v.msg);
                return v.status;
            }
            input_username_group.find('p.error-msg').html('');
            input_username_group.addClass('has-success');
            return v.status;
        }

        input_username.bind('keyup', function () {
            var str = $(this).val();
            if (str.length > 10) {
                checkUserName(str);
            }
        });
        input_username.bind('change', function () {
            checkUserName($(this).val());
        });
        input_username.bind('blur', function () {
            checkUserName($(this).val());
        });

        function checkPassword(str) {
            var v = verify_password(str);
            input_password_group.removeClass('has-error');
            input_password_group.removeClass('has-success');
            if (!v.status) {
                input_password_group.addClass('has-error');
                input_password_group.find('p.error-msg').html(v.msg);
                return v.status;
            }
            input_password_group.find('p.error-msg').html('');
            input_password_group.addClass('has-success');
            return v.status;
        }

        input_password.bind('keyup', function () {
            var str = $(this).val();
            if (str.length > 5) {
                checkPassword(str);
            }
        });
        input_password.bind('change', function () {
            checkPassword($(this).val());
        });
        input_password.bind('blur', function () {
            checkPassword($(this).val());
        });

        _this.submit(function () {
            var v1 = checkUserName(input_username.val());
            var v2 = checkPassword(input_password.val());
            if (!v2 || !v1) {
                return false;
            }
            return true;
        });
    },
    resetPassword: function (newpassword, password) {
        var _this = this;
        if (newpassword === undefined) {
            newpassword = 'newpassword';
        }
        if (password === undefined) {
            password = 'password';
        }
        var input_newpassword = _this.find('input[name=' + newpassword + ']');
        var input_newpassword_group = input_newpassword.parents('.form-group');
        var input_password = _this.find('input[name=' + password + ']');
        var input_password_group = input_password.parents('.form-group');


        function checkPassword(str, group) {
            var v = verify_password(str);
            group.removeClass('has-error');
            input_password_group.removeClass('has-success');
            if (!v.status) {
                group.addClass('has-error');
                group.find('p.error-msg').html(v.msg);
                return v.status;
            }
            group.find('p.error-msg').html('');
            group.addClass('has-success');
            return v.status;
        }

        input_password.bind('keyup', function () {
            var str = $(this).val();
            if (str.length > 5) {
                checkPassword(str, input_password_group);
                checkSame();
            }
        });
        input_password.bind('change', function () {
            checkPassword($(this).val(), input_password_group);
            checkSame();
        });
        input_password.bind('blur', function () {
            checkPassword($(this).val(), input_password_group);
            checkSame();
        });
        input_newpassword.bind('keyup', function () {
            var str = $(this).val();
            if (str.length > 5) {
                checkPassword(str, input_newpassword_group);
            }
        });
        input_newpassword.bind('change', function () {
            checkPassword($(this).val(), input_newpassword_group);
        });
        input_newpassword.bind('blur', function () {
            checkPassword($(this).val(), input_newpassword_group);

        });

        function checkSame() {
            var passwordnotsame = '两次密码输入不一致';
            if (input_newpassword.val() != input_password.val()) {
                input_newpassword_group.removeClass('has-success').addClass('has-error');
                input_newpassword_group.find('p.error-msg').html(passwordnotsame);
                return false;
            } else {
                if (input_newpassword_group.find('p.error-msg').html() == passwordnotsame) {
                    input_newpassword_group.find('p.error-msg').html('');
                    input_newpassword_group.addClass('has-success').removeClass('has-error');
                }
            }
            return true;
        }

        _this.submit(function () {
            var v1 = checkPassword(input_newpassword.val(), input_password_group);
            var v2 = checkPassword(input_password.val(), input_newpassword_group);

            if (!v2 || !v1 || !checkSame()) {
                return false;
            }
            return true;
        });
    },
    oldPassword: function (oldpass, newpassword, password) {
        var _this = this;
        if (oldpass === undefined) {
            oldpass = 'oldpassword'
        }
        if (newpassword === undefined) {
            newpassword = 'newpassword';
        }
        if (password === undefined) {
            password = 'password';
        }
        var input_oldpassword = _this.find('input[name=' + oldpass + ']');
        var input_oldpassword_group = input_oldpassword.parents('.form-group');

        var input_newpassword = _this.find('input[name=' + newpassword + ']');
        var input_newpassword_group = input_newpassword.parents('.form-group');

        var input_password = _this.find('input[name=' + password + ']');
        var input_password_group = input_password.parents('.form-group');


        function checkPassword(str, group) {
            var v = verify_password(str);
            group.removeClass('has-error');
            input_password_group.removeClass('has-success');
            if (!v.status) {
                group.addClass('has-error');
                group.find('p.error-msg').html(v.msg);
                return v.status;
            }
            group.find('p.error-msg').html('');
            group.addClass('has-success');
            return v.status;
        }

        input_password.bind('keyup', function () {
            var str = $(this).val();
            if (str.length > 5) {
                checkPassword(str, input_password_group);
                checkSame();
            }
        });
        input_password.bind('change', function () {
            checkPassword($(this).val(), input_password_group);
            checkSame();
        });
        input_password.bind('blur', function () {
            checkPassword($(this).val(), input_password_group);
            checkSame();
        });
        input_newpassword.bind('keyup', function () {
            var str = $(this).val();
            if (str.length > 5) {
                checkPassword(str, input_newpassword_group);
            }
        });
        input_newpassword.bind('change', function () {
            checkPassword($(this).val(), input_newpassword_group);
        });
        input_newpassword.bind('blur', function () {
            checkPassword($(this).val(), input_newpassword_group);

        });

        input_oldpassword.bind('keyup', function () {
            var str = $(this).val();
            if (str.length > 5) {
                checkPassword(str, input_oldpassword_group);
            }
        });
        input_oldpassword.bind('change', function () {
            checkPassword($(this).val(), input_oldpassword_group);
        });
        input_oldpassword.bind('blur', function () {
            checkPassword($(this).val(), input_oldpassword_group);

        });

        function checkSame() {
            var passwordnotsame = '两次密码输入不一致';
            if (input_newpassword.val() != input_password.val()) {
                input_newpassword_group.removeClass('has-success').addClass('has-error');
                input_newpassword_group.find('p.error-msg').html(passwordnotsame);
                return false;
            } else {
                if (input_newpassword_group.find('p.error-msg').html() == passwordnotsame) {
                    input_newpassword_group.find('p.error-msg').html('');
                    input_newpassword_group.addClass('has-success').removeClass('has-error');
                }
            }
            return true;
        }

        _this.submit(function () {
            var v1 = checkPassword(input_newpassword.val(), input_password_group);
            var v2 = checkPassword(input_password.val(), input_newpassword_group);

            if (!v2 || !v1 || !checkSame()) {
                return false;
            }
            return true;
        });
    },
    listDelete: function (name) {
        if (name === undefined) {
            name = 'list-delete';
        }
        var modal = '#delModal';
        var scrollTop = 0;

        $(modal).on('hide.bs.modal', function (e) {
            parent.$('html,body').scrollTop(scrollTop);
            if (parent) {
                parent.hideModal();
            }
        });
        $("#deleteLink").click(function () {
            var link = $(this).attr('href');
            parent.$('html,body').scrollTop(scrollTop);
            if (parent) {
                parent.hideModal();
            }
            window.location.href = link;
        });
        $("a." + name).click(function (event) {
            event.preventDefault();
            scrollTop = parent.$('body').scrollTop();
            parent.$('html,body').scrollTop(0);
            var url = $(this).attr('href');
            var content = $(this).attr('contentname');
            $("#deleteConnent").html(content)
            $("#deleteLink").attr('href', url);
            $('#delModal').modal('show');
            if (parent) {
                parent.showModal();
            }
        });
    },
    /**
     * 全选  绑定在LABEL 上
     * */
    groupCheckbox: function () {
        $("[node=groupCheckbox]").unbind('click').bind('click', function (event) {
            event.preventDefault();
            var key = $(this).attr('key');
            var keyArray = key.split(',');
            if (keyArray.length > 0) {
                for (var i in keyArray) {
                    var checkbox = $('input[type=checkbox][value=' + keyArray[i] + ']');
                    if (checkbox.length > 0) {
                        if (checkbox.prop('checked')) {
                            checkbox.prop('checked', false);
                        } else {
                            checkbox.prop('checked', true);
                        }
                    }
                }
            }
        });
    },
    /**
     * 上传图片的下拉菜单
     * */
    setImageDeleteMenu: function (_img) {
        if (_img == undefined) {
            _img = $(".imageGallery").find('img');
        }
        _img.each(function () {
            var _this = $(this);
            _this.contextMenu('picMenu', {
                //菜单样式
                menuStyle: {
                    border: '1px solid #ccc'
                },
                //菜单项样式
                itemStyle: {
                    fontFamily: 'verdana',
                    color: '#333',
                    border: 'none',
                    padding: '1px',
                    fontSize: '12px',
                    textIndent: '4px'
                },
                //菜单项鼠标放在上面样式
                itemHoverStyle: {
                    color: '#333',
                    border: 'none'
                },
                //事件
                bindings: {
                    picDelete: function (t) {
                        _this.parents('li').remove();
                    },
                    picView: function (t) {
                        $('body').openGallery(_this.parents('.imageGallery'), _this.attr('src'));
                    }
                }
            });
        });
    },
    /**
     * 上传文件的下拉菜单
     * */
    setFileDeleteMenu: function (_file) {
        if (_file == undefined) {
            _file = $(".fileGallery").find('a');
        }
        _file.each(function () {
            var _this = $(this);
            _this.contextMenu('picMenu', {
                //菜单样式
                menuStyle: {
                    border: '1px solid #ccc'
                },
                //菜单项样式
                itemStyle: {
                    fontFamily: 'verdana',
                    color: '#333',
                    border: 'none',
                    padding: '1px',
                    fontSize: '12px',
                    textIndent: '4px'
                },
                //菜单项鼠标放在上面样式
                itemHoverStyle: {
                    color: '#333',
                    border: 'none'
                },
                //事件
                bindings: {
                    picDelete: function (t) {
                        _this.parents('li').remove();
                    },
                    picView: function (t) {
                        window.open(_this.attr('href'));
                    }
                }
            });
        });
    },
    /**
     * 单个文件上传工具
     * */
    uploadFile: function (kename) {
        var _file = $(".fileGallery[node=" + kename + "]").find('a');
        $("body").setFileDeleteMenu(_file);
        $("button[node=" + kename + "]").bind('click', function () {
            var fileName = kename;
            var errorBlock = $(".error-msg[error=" + kename + "]");
            errorBlock.html('');
            $.ajaxFileUpload({
                url: '/upload/file?dontsaveurl=1',
                secureuri: false,
                fileElementId: fileName,
                dataType: 'json',
                data: {
                    csrf_test_name: $("input[name=csrf_test_name]").val()
                },
                success: function (response, status) {
                    $("input[name=csrf_test_name]").val(response.csrf_test_name);
                    if (response.status) {
                        var html = "<li ><a href=\"" + response.data.name + "\" target=\"_blank\" class=\"fileLink\" sourcename=\"" + response.data.sourcename + "\"><span class=\"glyphicon glyphicon-file\"></span>" + response.data.sourcename + "</a><input type='hidden' name='" + kename + "' value='" + response.data.name + "'/></li>"
                        $(".fileGallery[node=" + kename + "]").html(html);
                        var _file = $(".fileGallery[node=" + kename + "]").find('a');
                        $("body").setFileDeleteMenu(_file);
                        $("#" + kename).val();
                    } else {
                        errorBlock.html(response.error);
                    }

                },
                error: function (data, status, e) {
                    console.log(data);
                }
            })
        });
    },
    /*
     * 多个文件上传工具
     * @param string kename
     * @returns NULL
     */
    uploadFilesArray: function (kename) {
        var _file = $(".fileGallery[node=" + kename + "]").find('a');
        $("body").setFileDeleteMenu(_file);
        $("ul.fileGallery[node=" + kename + "]").dragsort({
            dragSelector: "li",
            dragEnd: function () {
            },
            dragBetween: false,
            placeHolderTemplate: "<li></li>"
        });
        $("button[node=" + kename + "]").bind('click', function () {
            var fileName = kename;
            var errorBlock = $(".error-msg[error=" + kename + "]");
            errorBlock.html('');
            $.ajaxFileUpload({
                url: '/upload/files?dontsaveurl=1',
                secureuri: false,
                fileElementId: fileName,
                dataType: 'json',
                data: {
                    csrf_test_name: $("input[name=csrf_test_name]").val()
                },
                success: function (response, status) {
                    $("input[name=csrf_test_name]").val(response.csrf_test_name);

                    if (response.status) {
                        for (var i in response.data) {
                            var url = response.data[i].name;
                            var sourcename = response.data[i].sourcename;
                            var html = "<li><a href=\"" + url + "\" target=\"_blank\" class=\"fileLink\" sourcename=\"" + sourcename + "\"><span class=\"glyphicon glyphicon-file\"></span>" + sourcename + "</a><input type='hidden' name='" + kename + "[]' value='" + url + "'/></li>"
                            $(".fileGallery[node=" + kename + "]").append(html);
                        }
                        var _file = $(".fileGallery[node=" + kename + "]").find('a');
                        $("body").setFileDeleteMenu(_file);
                        $("#" + kename).val();
                    } else {
                        errorBlock.html(response.error);
                    }

                },
                error: function (data, status, e) {
                    console.log(data);
                }
            })
        });
    },
    /**
     * 单个图片上传工具
     * @param string kename
     * @returns NULL
     * */
    uploadImage: function (kename) {
        $("body").setImageDeleteMenu($(".imageGallery[node=" + kename + "]").find('img'));
        $("button[gallery=" + kename + "]").bind('click', function (event) {
            event.preventDefault();
            $("body").openGallery($('ul.imageGallery[node=' + kename + ']'));
        });
        $("button[node=" + kename + "]").bind('click', function () {
            var fileName = kename;
            var errorBlock = $(".error-msg[error=" + kename + "]");
            errorBlock.html('');
            $.ajaxFileUpload({
                url: '/upload/image?dontsaveurl=1',
                secureuri: false,
                fileElementId: fileName,
                dataType: 'json',
                data: {
                    csrf_test_name: $("input[name=csrf_test_name]").val()
                },
                success: function (response, status) {
                    $("input[name=csrf_test_name]").val(response.csrf_test_name);

                    if (response.status) {
                        var html = "<li ><img src=\"" + response.data.name + "\" sourcename=\"" + response.data.sourcename + "\"/><input type='hidden' name='" + kename + "' value='" + response.data.name + "'/>" + response.data.sourcename + "</li>"
                        $(".imageGallery[node=" + kename + "]").html(html);
                        var _img = $(".imageGallery[node=" + kename + "]").find('img');
                        $("body").setImageDeleteMenu(_img);
                        $("#" + kename).val();
                    } else {
                        errorBlock.html(response.error);
                    }
                },
                error: function (data, status, e) {
                    console.log(e);
                }
            })
        });

    },
    /**
     * 多个图片上传工具
     * @param string kename
     * @returns NULL
     * */
    uploadImagesArray: function (kename) {

        $("button[gallery=" + kename + "]").bind('click', function (event) {
            event.preventDefault();
            $("body").openGallery($('ul.imageGallery[node=' + kename + ']'));
        });

        $("button[node=" + kename + "]").bind('click', function (event) {
            var errorBlock = $(".error-msg[error=" + kename + "]");
            errorBlock.html('');
            var fileName = kename;

            $.ajaxFileUpload({
                url: '/upload/images?dontsaveurl=1',
                secureuri: false,
                fileElementId: fileName,
                dataType: 'json',
                data: {
                    csrf_test_name: $("input[name=csrf_test_name]").val()
                },
                success: function (response, status) {

                    $("input[name=csrf_test_name]").val(response.csrf_test_name);
                    if (response.status) {
                        for (var i in response.data) {
                            var imgstr = response.data[i].name;
                            var sourcename = response.data[i].sourcename;
                            var html = "<li style='cursor:pointer;'><img src=\"" + imgstr + "\" sourcename=\"" + sourcename + "\"/><input type='hidden' name='" + kename + "[]' value='" + imgstr + "'/>" + sourcename + "</li>"
                            $(".imageGallery[node=" + kename + "]").append(html);
                            $("#" + kename).val('');
                        }
                        var _img = $(".imageGallery[node=" + kename + "]").find('img');
                        $("body").setImageDeleteMenu(_img);
                    } else {
                        errorBlock.html(response.error);
                    }
                },
                error: function (data, status, e) {
                    console.log(e);
                    console.log(data);
                }
            })
        });
        $("ul.imageGallery[node=" + kename + "]").dragsort({
            dragSelector: "li",
            dragEnd: function () {
            },
            dragBetween: false,
            placeHolderTemplate: "<li></li>"
        });
        $("body").setImageDeleteMenu($("ul.imageGallery[node=" + kename + "]").find('img'));
    },
    /**
     * 打开图片游览器
     * */
    openGallery: function (galleryEle, src) {
        var items = [];
        var index = 0;
        var i = 0;
        galleryEle.find('img').each(function () {
            var image = new Image();
            image.src = $(this).attr('src');
            var tmp = {src: $(this).attr('src'), w: image.width, h: image.height};
            items.push(tmp);
            if (src !== undefined && $(this).attr('src') == src) {
                index = i;
            }
            if ($(this).attr('sourcename') !== undefined) {
                tmp['title'] = $(this).attr('sourcename');
            }
            i++;
        });
        if (items.length == 0) {
            return;
        }
        var options = {
            index: index,
            bgOpacity: 0.8
        };
        if (self != top) {
            parent.showGallery(items, options);
        } else {
            var pswpElement = document.querySelectorAll('.pswp')[0];
            var gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, options);
            gallery.init();
        }
    },
    /**
     * 看图工具
     * */
    bindViewGallery: function (galleryEle) {
        galleryEle.find('img').unbind('click').css('cursor', 'pointer').bind('click', function () {
            var g = $(this).parents('.imageGallery');
            $('body').openGallery(g, $(this).attr('src'));
        });
    },
    /**重设页面宽高*/
    resetPageWH: function () {
        var i = $("#iframe");
        var winW = $(window).width();
        if (winW > 768) {
            i.width(winW - 270);
        } else if (winW > 415) {
            i.width(winW - 20);
        } else if (winW < 415) {
            i.width(winW - 5);
        }
        var s = $('#sidebar');
        var sW = s.width();

        var topNav = $("#topnav");
        if(s.css('display') == 'none'){
            topNav.css('width',winW + 'px').css('position','relative');
            topNav.css('left','0px');
        }else{
            topNav.css('width',(winW - sW -40) + 'px').css('position','relative');
            topNav.css('left',(sW+40)+'px');
        }


        if (winW > 415) {
            if (s.css('display') == 'none') {
                i.width(winW - 40);
                i.css('left', '20px');
            } else {
                i.css('left', '250px');
            }
        }

    },
    pageJump: function () {
        var d = $("#pageJump");
        var focusStatus = false;
        $("input").bind('focus', function () {
            focusStatus = true;
        }).bind('blur', function () {
            focusStatus = false
        });
        $('body').bind('keydown', function (e) {
            if (focusStatus === false) {
                var prev = $(".pagination").find('a[rel=prev]');
                var next = $(".pagination").find('a[rel=next]');
                if (e.which == 37 && prev.length > 0) {
                    window.location.href = prev.attr('href');
                }
                if (e.which == 39 && next.length > 0) {
                    window.location.href = next.attr('href');
                }

            }

        });
        var btn = d.find('button');
        var totalPages = parseInt(btn.attr('total'));
        var perPage = parseInt(btn.attr('perpage'));
        var url = btn.attr('baseUrl');
        var ipt = d.find('input[type=text]');

        function jump() {
            var v = ipt.val();
            if (v != '') {
                v = parseInt(v);
                if (v < 1) {
                    return;
                }
                if (v > totalPages) {
                    return;
                }
                window.location.href = url + ((v - 1) * perPage);
            }
        }

        btn.bind('click', function () {
            jump();
        });
        ipt.bind('keydown', function (e) {
            if (e.which == 13) {
                jump();
            }
        });
    },

    userSearch: function () {
        var input = $('input[selectType=userSearch]');
        var select = input.parents('.form-group').find('select[selectType=userSearch]');
        var request = null;

        function search(val) {
            if ($.trim(val) == '') {
                return;
            }
            request = $.ajax({
                type: 'get',
                url: '/basic/userSearch',
                data: {shopSearch: val},
                dataType: 'json',
                beforeSend: function () {
                    if (request !== null) {
                        request.abort();
                    }
                },
                success: function (msg) {
                    if (msg.length == 0) {
                        return true;
                    }
                    var options = "<option value=\"\">请选择</option>";
                    var selected = '';
                    var length = 0;
                    for (var i in msg) {
                        length++;
                    }
                    if (length == 1) {
                        selected = 'selected = "selected"';
                    }
                    for (var i in msg) {
                        if (i == val) {
                            selected = 'selected = "selected"';
                        }
                        options += "<option value=\"" + i + "\" " + selected + ">" + msg[i] + "</option>";
                    }
                    select.html(options);
                }
            });
        }

        input.unbind('change').bind('change', function () {
            search($(this).val());
        }).unbind('keyup').bind('keyup', function () {
            search($(this).val());
        });


    },

    webUserSearch: function () {
        var input = $('input[selectType=webUserSearch]');
        var select = input.parents('.form-group').find('select[selectType=webUserSearch]');

        function search(val) {
            if ($.trim(val) == '') {
                return;
            }
            $.ajax({
                type: 'get',
                url: '/basic/webUserSearch',
                data: {shopSearch: val},
                dataType: 'json',
                success: function (msg) {
                    var options = "<option value=\"\">请选择</option>";
                    var selected = '';
                    var length = 0;
                    for (var i in msg) {
                        length++;
                    }
                    if (length == 1) {
                        selected = 'selected = "selected"';
                    }

                    for (var i in msg) {
                        if (i == val) {
                            selected = 'selected = "selected"';
                        }
                        options += "<option value=\"" + i + "\" " + selected + ">" + msg[i] + "</option>";
                    }
                    select.html(options);
                }
            });
        }

        input.unbind('change').bind('change', function () {
            search($(this).val());
        }).unbind('keyup').bind('keyup', function () {
            search($(this).val());
        });
    },
    dataLink: function (data, f) {
        for (var i  in data) {
            var input = $("input[name=" + i + "]");
            if (input.length > 0) {
                if (input.val != '') {
                    input.val(data[i]);
                    input.change();
                }
            }
            var select = $("select[name=" + i + "]");
            if (select.length > 0) {
                select.val(data[i]);
                if (select.attr('selecttype') == 'street' || select.attr('selecttype') == 'area' || select.attr('selecttype') == 'road') {

                } else {
                    select.change();
                }

            }
            var p = $("div.extraInput[name=" + i + "]");
            if (p.length > 0) {
                p.html(data[i]);
            }
        }
        if (f !== undefined && typeof f == 'function') {
            f(data);
        }
    },
    autoInput: function (select, f) {
        var selectType = select.attr('selectType');

        var val = select.val();
        var url = '/basic/dataLink';
        if (val == '') {
            return;
        }
        var data = {
            page: pageController,
            sn: val,
            type: selectType
        };
        $.ajax({
            type: 'get',
            url: url,
            data: data,
            dataType: 'json',
            success: function (msg) {
                $('body').dataLink(msg, f);
            }
        });
    },
    listResetWidth: function (type) {
        if (type == 'scroll') {
            function resetTableWidth() {
                var p = $("#page-header").width();
                var t = $("#listTable").width();
                if (t > p) {
                    $("#listTableDiv").css('overflow-x', 'scroll');
                } else {
                    $("#listTableDiv").css('overflow-x', 'hidden');
                }
            }

            resetTableWidth();
            $(window).resize(function () {
                resetTableWidth();
            });
        }
        if (type == 'hidecol') {

            function hideLast() {
                var total = $("#listTable").find('th').length;
                var num = total - 2;
                for (var i = num; i > 0; i--) {
                    var th = $("#listTable").find('th:eq(' + i + ')');
                    if (th.css('display') == 'table-cell') {
                        num = i;
                        break;
                    }
                }

                var w = th.width();
                $("#listTable tr").find('td:eq(' + num + '),th:eq(' + num + ')').hide();
                return w;
            }

            function resetCol() {
                if ($(window).width() < 415) {
                    return;
                }
                var p = $("#page-header").width();

                var t = $("#listTable").width();
                if (t > p) {

                    while (t > p) {
                        var hasShow = 0;
                        $("#listTable").find('th').each(function () {
                            if ($(this).css('display') == 'table-cell') {
                                hasShow++;
                            }
                        });
                        t = t - hideLast();
                        if (hasShow <= 2) {
                            break;
                        }
                    }

                }
            }

            $(window).resize(function () {
                $("#listTable").find('th,td').show();
                resetCol();
            });
            $("#listTable").find('th,td').show();
            resetCol();
        }
    },

    hrFloat: function () {
        if ($('body').find('.hrInfo').length > 0) {
            var height = 25 * ($('body').find('.hrInfo').length + 1);
            var html = '<div class="hrFloat"  id="hrFloat"><ul class="path" style="display:none;"><li class="li-none" node="first"></li><li class="li-none" node="last"></li><div class="li-left" style="height:' + height + 'px;"></div></ul><button class="pathToggle"></button><a class="toTop" href="#top"></a></div>';
            var bodyPadding = 140 + height;
            $('body').append(html);
            $('body').find('.container-fluid.inframe').css('padding-bottom', bodyPadding + 'px');
            var i = 0;
            $('body').find('.hrInfo').each(function () {
                $(this).addClass('hr' + i % 9);
                i++;
                var h5 = $(this).find('h5');
                var name = h5.attr('name');
                h5.html('<span>' + name + '</span>');
                var a = "<a class='hrA' name='" + name + "'>&nbsp;</a>";
                $(this).before(a);
                a = "<li><a href='#" + name + "'>" + name + "</a></li>";
                $("#hrFloat").find('li[node=last]').before(a);

            });
            $('.pathToggle').bind('click', function () {
                $("#hrFloat").find('ul').toggle();
            });
        }
    },

    loadModal: function (name, action) {
        var url = '/' + name + '/' + action + '?dontsaveurl=1';
        var id = name + action;
        if ($('#' + id).length == 0) {
            $.ajax({
                type: 'post',
                url: url,
                data: {
                    isAjaxPage: 1,
                    dontsaveurl: 1
                },
                success: function (msg) {
                    $('body').append(msg);
                }
            })
        }
    },
    editModal: function (name, action, id) {
        var url = '/' + name + '/' + action + '?dontsaveurl=1';
        var obj = name + action;
        $("#" + obj).remove();
        $.ajax({
            type: 'post',
            url: url,
            data: {
                isAjaxPage: 1,
                dontsaveurl: 1,
                id: id
            },
            success: function (msg) {
                $('body').append(msg);
            }
        });
    },
    removeModal: function (name, action, id) {
        var url = '/' + name + '/removeModal' + '?dontsaveurl=1';
        var obj = name + 'Remove';
        $("#" + obj).remove();
        $.ajax({
            type: 'post',
            url: url,
            data: {
                isAjaxPage: 1,
                dontsaveurl: 1,
                id: id
            },
            success: function (msg) {
                $('body').append(msg);
            }
        })
    }
});
