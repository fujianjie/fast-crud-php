/**
 * Javascript 表单验证函数集合
 * @version 0.1
 * @author jian-jie.fu 
 * @param string 
 * @return obj{ status: bool , msg :'error msg'}
 * */

/**
 *  验证内容非空
 * */
function verify_notempty(str){
	if(str=='' || str == undefined || str == NULL){
		return {status:false,msg:'该内容为必填项'};
	}else{
		return true;
	}
}

/**
 * 验证字符串长度
 * */
function verify_length(str,min,max){
	if(str.length<min){
		return {status:false,msg:'您输入的内容太短，必须大于'+min+'个字'};
	}
	if(str.length>max){
		return {status:false,msg:'您输入的内容太短，必须小于'+max+'个字'};
	}
	return true;
}

/**
 * 验证用户名
 * */
function verify_username(str){
	var reg = /[\w_\-\u4e00-\u9fa5]+/;
	if(!reg.test(str)){
		return {status:false,msg:'您输入的用户名有误，可使用英文、数字、中文'};
	}else{
		return {status:true,msg:''};
	}
}

/**
 * 验证密码
 * */
function verify_password(str){
	var reg = new RegExp('(?=.*[0-9])(?=.*[a-zA-Z])(?=.*[^a-zA-Z0-9]).{6,20}');
	if(!reg.test(str)){
		return {status:false,msg:'您输入的密码有误，请使用英文与数字，必须包含符号，6至20个字符'};
	}else{
		return {status:true,msg:''};
	}
}

/**
 * 验证手机号码
 * */
function verify_mobile(str){
	var reg = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/;
	if(!reg.test(str)){
		return {status:false,msg:'您输入的手机号码有误'};
	}else{
		return {status:true,msg:''};
	}
}

/**
 * 验证纯中文
 * 不包含全角符号
 * */
function verify_chinese(str){
	var reg = /^[\u4E00-\u9FA5]+$/; 
	if(!reg.test(str)){
		return {status:false,msg:'请输入中文'};
	}else{
		return {status:true,msg:''};
	}
}

/**
 * 验证英文
 * */
function verify_english(str){
	var reg = /^[\w]+$/; 
	if(!reg.test(str)){
		return {status:false,msg:'请输入英文'};
	}else{
		return {status:true,msg:''};
	}
}

/**
 * 验证邮箱
 * */
function verify_email(str){
	var reg = /\w[-\w.+]*@([A-Za-z0-9][-A-Za-z0-9]+\.)+[A-Za-z]{2,14}/;
	if(!reg.test(str)){
		return {status:false,msg:'请输入正确的Email邮箱'};
	}else{
		return {status:true,msg:''};
	}
}

/**
 * 验证数字
 * */
function verify_number(str){
	var reg = /^[\d]+$/; 
	if(!reg.test(str)){
		return {status:false,msg:'请输入数字'};
	}else{
		return {status:true,msg:''};
	}
}