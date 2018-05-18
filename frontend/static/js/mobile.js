var mobileCheckStatus=false;
$(document).ready(function () {
        $("#mobileGetKey").bind('click', function () {
                var testKey = /^[0-9]{11}$/;
                var mobile = $('#mobile');
                if (!testKey.test(mobile.val())) {
                        mobile.focus();
                        $("#mobileCheckIcon").removeClass().addClass('tipsFailed').css('opacity','1');
                        $('#mobileError').show().html('您输入的手机号码有误，请重新输入');
                        return;
                }
                $("#mobileCheckIcon").removeClass().addClass('tipsSuccess').css('opacity','1');
                $('#mobileError').hide();
                $.ajax({
                        type: 'post',
                        url: 'index.php?r=sms',
                        data: {
                                mobile: mobile.val()
                        },
                        dataType: 'json',
                        success: function (msg) {

                                if (msg.status == '1' || msg.status == 1) {
                                        $('#mobileError').show().html(msg.msg);
                                        $("#mobileGetKey,#mobile").attr('disabled', 'disabled');
                                        $("#mobileGetKey").attr('countDown', '60');

                                        var runInterval = setInterval(function () {
                                                var obj = $("#mobileGetKey");
                                                var countDown = parseInt(obj.attr('countDown')) - 1;
                                                obj.attr('countDown', countDown)
                                                obj.attr("value",  countDown + "秒");
                                        }, 1000);
                                        setTimeout(function () {
                                                var obj = $("#mobileGetKey");
                                                obj.removeAttr('disabled').attr("value", "验证码");
                                                $("#mobile").removeAttr('disabled');
                                                clearInterval(runInterval);
                                        }, 60000);

                                } else {
                                        $('#mobileCheckError').html(msg.msg);
                                }
                        }
                })
        });
        $("#mobileCheck").bind('keyup',function(){
                var val =  $(this).val();
                if(val.length == 6){
                        $.ajax({
                                type:'post',
                                url:'index.php?r=sms/checkKey',
                                data:{
                                        key:val,
                                        mobile:$("#mobile").val()
                                },
                                dataType:'json',
                                success:function(msg){
                                        mobileCheckStatus = msg.status == 1;
                                        
                                        if(msg.status==1){
                                                 $("#mobileCheckError").removeClass().addClass('tipsSuccess').css('opacity','1');
                                                 $("#mobileCheckErrorMsg").hide();
                                        }else{
                                                $("#mobileCheckError").removeClass().addClass('tipsFailed').css('opacity','1');
                                                $("#mobileCheckErrorMsg").show().html(msg.msg);
                                        }
                                }
                        });
                }
        });
});