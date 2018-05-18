jQuery.extend({
        createUploadIframe: function(id, uri)
        {
                //create frame
                var frameId = 'jUploadFrame' + id;

                if (window.ActiveXObject) {
                        var io = document.createElement('<iframe id="' + frameId + '" name="' + frameId + '" />');
                        if (typeof uri == 'boolean') {
                                io.src = 'javascript:false';
                        }
                        else if (typeof uri == 'string') {
                                io.src = uri;
                        }
                }
                else {
                        var io = document.createElement('iframe');
                        io.id = frameId;
                        io.name = frameId;
                }
                io.style.position = 'absolute';
                io.style.top = '-1000px';
                io.style.left = '-1000px';

                document.body.appendChild(io);

                return io
        },
        createUploadForm: function(id, fileElementId)
        {
                //create form
                var formId = 'jUploadForm' + id;
                var fileId = 'jUploadFile' + id;
                var form = $('<form  action="" method="POST" name="' + formId + '" id="' + formId + '" enctype="multipart/form-data"></form>');
                var oldElement = $('#' + fileElementId);
                var newElement = $(oldElement).clone();
                $(oldElement).attr('id', fileId);
                $(oldElement).before(newElement);
                $(oldElement).appendTo(form);
                //set attributes
                $(form).css('position', 'absolute');
                $(form).css('top', '-1200px');
                $(form).css('left', '-1200px');
                $(form).appendTo('body');
                return form;
        },
        addOtherRequestsToForm: function(form, data)
        {
                // add extra parameter
                var originalElement = $('<input type="hidden" name="" value="">');
                for (var key in data) {
                        name = key;
                        value = data[key];
                        var cloneElement = originalElement.clone();
                        cloneElement.attr({'name': name, 'value': value});
                        $(cloneElement).appendTo(form);
                }
                return form;
        },
        ajaxFileUpload: function(s) {
                // TODO introduce global settings, allowing the client to modify them for all requests, not only timeout
                s = jQuery.extend({}, jQuery.ajaxSettings, s);
                var id = new Date().getTime()
                var form = jQuery.createUploadForm(id, s.fileElementId);
                if (s.data) {
                        form = jQuery.addOtherRequestsToForm(form, s.data);
                }
                var io = jQuery.createUploadIframe(id, s.secureuri);
                var frameId = 'jUploadFrame' + id;
                var formId = 'jUploadForm' + id;
                // Watch for a new set of requests
                if (s.global && !jQuery.active++)
                {
                        jQuery.event.trigger("ajaxStart");
                }
                var requestDone = false;
                // Create the request object
                var xml = {}
                if (s.global)
                        jQuery.event.trigger("ajaxSend", [xml, s]);
                // Wait for a response to come back
                var uploadCallback = function(isTimeout)
                {
                        var io = document.getElementById(frameId);
                        try
                        {
                                if (io.contentWindow)
                                {
                                        xml.responseText = io.contentWindow.document.body ? io.contentWindow.document.body.innerHTML : null;
                                        xml.responseXML = io.contentWindow.document.XMLDocument ? io.contentWindow.document.XMLDocument : io.contentWindow.document;

                                } else if (io.contentDocument)
                                {
                                        xml.responseText = io.contentDocument.document.body ? io.contentDocument.document.body.innerHTML : null;
                                        xml.responseXML = io.contentDocument.document.XMLDocument ? io.contentDocument.document.XMLDocument : io.contentDocument.document;
                                }
                        } catch (e)
                        {

                                jQuery.handleError(s, xml, null, e);
                        }
                        if (xml || isTimeout == "timeout")
                        {
                                requestDone = true;
                                var status;
                                try {
                                        status = isTimeout != "timeout" ? "success" : "error";
                                        // Make sure that the request was successful or notmodified
                                        if (status != "error")
                                        {
                                                // process the data (runs the xml through httpData regardless of callback)
                                                var data = jQuery.uploadHttpData(xml, s.dataType);
                                                // If a local callback was specified, fire it and pass it the data
                                                if (s.success)
                                                        s.success(data, status);

                                                // Fire the global callback
                                                if (s.global)
                                                        jQuery.event.trigger("ajaxSuccess", [xml, s]);
                                        } else
                                                jQuery.handleError(s, xml, status);
                                } catch (e)
                                {
                                        status = "error";
                                        jQuery.handleError(s, xml, status, e);
                                }

                                // The request was completed
                                if (s.global)
                                        jQuery.event.trigger("ajaxComplete", [xml, s]);

                                // Handle the global AJAX counter
                                if (s.global && !--jQuery.active)
                                        jQuery.event.trigger("ajaxStop");

                                // Process result
                                if (s.complete)
                                        s.complete(xml, status);

                                jQuery(io).unbind()

                                setTimeout(function()
                                {
                                        try
                                        {
                                                $(io).remove();
                                                $(form).remove();

                                        } catch (e)
                                        {
                                                jQuery.handleError(s, xml, null, e);
                                        }

                                }, 100)

                                xml = null

                        }
                }
                // Timeout checker
                if (s.timeout > 0)
                {
                        setTimeout(function() {
                                // Check to see if the request is still happening
                                if (!requestDone)
                                        uploadCallback("timeout");
                        }, s.timeout);
                }
                try
                {
                        // var io = $('#' + frameId);
                        var form = $('#' + formId);
                        $(form).attr('action', s.url);
                        $(form).attr('method', 'POST');
                        $(form).attr('target', frameId);
                        if (form.encoding)
                        {
                                form.encoding = 'multipart/form-data';
                        }
                        else
                        {
                                form.enctype = 'multipart/form-data';
                        }
                        $(form).submit();

                } catch (e)
                {
                        jQuery.handleError(s, xml, null, e);
                }
                if (window.attachEvent) {
                        document.getElementById(frameId).attachEvent('onload', uploadCallback);
                }
                else {
                        document.getElementById(frameId).addEventListener('load', uploadCallback, false);
                }
                return {abort: function() {
                        }};

        },
        handleError: function(s, xhr, status, e) {
                // If a local callback was specified, fire it  
                if (s.error) {
                        s.error.call(s.context || s, xhr, status, e);
                }

                // Fire the global callback  
                if (s.global) {
                        (s.context ? jQuery(s.context) : jQuery.event).trigger("ajaxError", [xhr, s, e]);
                }
        },
        uploadHttpData: function(r, type) {
                var data = !type;
                data = type == "xml" || data ? r.responseXML : r.responseText;
                // If the type is "script", eval it in global context
                if (type == "script")
                        jQuery.globalEval(data);
                // Get the JavaScript object, if JSON is used.
                if (type == "json")
                {
                        // If you add mimetype in your response,
                        // you have to delete the '<pre></pre>' tag.
                        // The pre tag in Chrome has attribute, so have to use regex to remove
                        var data = r.responseText;
                        //var rx = new RegExp("<pre.*?>(.*?)</pre>", "i");
                        //var am = rx.exec(data);
                        //this is the desired data extracted
                        //var data = (am) ? am[1] : "";    //the only submatch or empty
                        eval("data = " + data);
                }
                // evaluate scripts within html
                if (type == "html")
                        jQuery("<div>").html(data).evalScripts();
                //alert($('param', data).each(function(){alert($(this).attr('value'));}));
                return data;
        }
});

/**
 * content menu 
 * */
(function($) {
        var menu, shadow, trigger, content, hash, currentTarget;
        var defaults = {
                menuStyle: {
                        listStyle: 'none',
                        padding: '1px',
                        margin: '0px',
                        backgroundColor: '#fff',
                        border: '1px solid #999',
                        width: '100px'
                },
                itemStyle: {
                        margin: '0px',
                        color: '#000',
                        display: 'block',
                        cursor: 'default',
                        padding: '3px',
                        border: '1px solid #fff',
                        backgroundColor: 'transparent'
                },
                itemHoverStyle: {
                        border: '1px solid #0a246a',
                        backgroundColor: '#b6bdd2'
                },
                eventPosX: 'pageX',
                eventPosY: 'pageY',
                shadow: true,
                onContextMenu: null,
                onShowMenu: null
        };

        $.fn.contextMenu = function(id, options) {
                if (!menu) {
                        menu = $('<div id="jqContextMenu"></div>').hide().css({
                                position: 'absolute',
                                zIndex: '500'
                        }).appendTo('body').bind('click', function(e) {
                                e.stopPropagation()
                        })
                }
                if (!shadow) {
                        shadow = $('<div></div>').css({
                                backgroundColor: '#000',
                                position: 'absolute',
                                opacity: 0.2,
                                zIndex: 499
                        }).appendTo('body').hide()
                }
                hash = hash || [];
                hash.push({
                        id: id,
                        menuStyle: $.extend({}, defaults.menuStyle, options.menuStyle || {}),
                        itemStyle: $.extend({}, defaults.itemStyle, options.itemStyle || {}),
                        itemHoverStyle: $.extend({}, defaults.itemHoverStyle, options.itemHoverStyle || {}),
                        bindings: options.bindings || {},
                        shadow: options.shadow || options.shadow === false ? options.shadow : defaults.shadow,
                        onContextMenu: options.onContextMenu || defaults.onContextMenu,
                        onShowMenu: options.onShowMenu || defaults.onShowMenu,
                        eventPosX: options.eventPosX || defaults.eventPosX,
                        eventPosY: options.eventPosY || defaults.eventPosY
                });
                var index = hash.length - 1;
                $(this).unbind('contextmenu').bind('contextmenu', function(e) {
                        var bShowContext = (!!hash[index].onContextMenu) ? hash[index].onContextMenu(e) : true;
                        if (bShowContext)
                                display(index, this, e, options);
                        return false
                });
                return this
        };

        function display(index, trigger, e, options) {
                var cur = hash[index];
                content = $('#' + cur.id).find('ul:first').clone(true);
                content.css(cur.menuStyle).find('li').css(cur.itemStyle).hover(function() {
                        $(this).css(cur.itemHoverStyle)
                }, function() {
                        $(this).css(cur.itemStyle)
                }).find('img').css({
                        verticalAlign: 'middle',
                        paddingRight: '2px'
                });
                menu.html(content);
                if (!!cur.onShowMenu)
                        menu = cur.onShowMenu(e, menu);
                $.each(cur.bindings, function(id, func) {
                        $('#' + id, menu).bind('click', function(e) {
                                hide();
                                func(trigger, currentTarget)
                        })
                });
                menu.css({
                        'left': e[cur.eventPosX],
                        'top': e[cur.eventPosY]
                }).show();
                if (cur.shadow)
                        shadow.css({
                                width: menu.width(),
                                height: menu.height(),
                                left: e.pageX + 2,
                                top: e.pageY + 2
                        }).show();
                $(document).one('click', hide)
        }
        function hide() {
                menu.hide();
                shadow.hide()
        }
        $.contextMenu = {
                /**
                 * <div class="contextMenu" id="picMenu"><ul><li id="picDelete">删除</li></ul></div>
                 * */
                defaults: function(userDefaults) {
                        $.each(userDefaults, function(i, val) {
                                if (typeof val == 'object' && defaults[i]) {
                                        $.extend(defaults[i], val)
                                } else
                                        defaults[i] = val
                        })
                }
        }
})(jQuery);
$(function() {
        $("body").append('<div class="contextMenu" id="picMenu"><ul><li id="picView">查看</li><li id="picDelete">删除</li></ul></div>');
        $('div.contextMenu').hide()
});