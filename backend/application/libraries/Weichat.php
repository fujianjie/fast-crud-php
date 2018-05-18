<?php

/**
 * 微信服务器对接API
 *
 */
class Weichat
{
    public $appId;
    public $appSecret;

    public $CI;

    public function __construct()
    {
        $this->CI = & get_instance();
        $this->CI->config->load('weichat',TRUE);
        $config = $this->CI->config->item('weichat');
        if(empty($appId)){
            $appId = $config['weichatAppId'];
        }
        if(empty($appSecret)){
            $appSecret = $config['weichatAppSecret'];
        }
        $this->appId = $appId;
        $this->appSecret = $appSecret;
    }

    public function getSignPackage()
    {
        $jsapiTicket = $this->getJsApiTicket();

        // 注意 URL 一定要动态获取，不能 hardcode.
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        $timestamp = time();
        $nonceStr = $this->createNonceStr();

        // 这里参数的顺序要按照 key 值 ASCII 码升序排序
        $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";

        $signature = sha1($string);

        $signPackage = array(
            "appId" => $this->appId,
            "nonceStr" => $nonceStr,
            "timestamp" => $timestamp,
            "url" => $url,
            "signature" => $signature,
            "rawString" => $string
        );
        return $signPackage;
    }

    private function createNonceStr($length = 16)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    private function getJsApiTicket()
    {
        // jsapi_ticket 应该全局存储与更新，以下代码以写入到文件中做示例
        $data = json_decode(file_get_contents("jsapi_ticket.json"));
        if ($data->expire_time < time()) {
            $accessToken = $this->getAccessToken();
            // 如果是企业号用以下 URL 获取 ticket
            // $url = "https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket?access_token=$accessToken";
            $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
            $res = json_decode($this->httpGet($url));
            $ticket = $res->ticket;
            if ($ticket) {
                $data->expire_time = time() + 7000;
                $data->jsapi_ticket = $ticket;
                $fp = fopen("jsapi_ticket.json", "w");
                fwrite($fp, json_encode($data));
                fclose($fp);
            }
        } else {
            $ticket = $data->jsapi_ticket;
        }

        return $ticket;
    }

    public $tokenPath = 'access_token.json';

    public function getAccessToken()
    {
        // access_token 应该全局存储与更新，以下代码以写入到文件中做示例
        $data = json_decode(file_get_contents($this->tokenPath));
        if ($data->expire_time < time()) {
            // 如果是企业号用以下URL获取access_token
            // $url = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=$this->appId&corpsecret=$this->appSecret";
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appId&secret=$this->appSecret";
            $res = json_decode($this->httpGet($url));
            $access_token = $res->access_token;
            if ($access_token) {
                $data->expire_time = time() + 7000;
                $data->access_token = $access_token;
                $fp = fopen("access_token.json", "w");
                fwrite($fp, json_encode($data));
                fclose($fp);
            }
        } else {
            $access_token = $data->access_token;
        }
        return $access_token;
    }

    /*
    *获取code 做为 换取access_token 的票据
    */
    public function getUserInfo($code)
    {

        $data = json_decode(file_get_contents("access_token.json"));

        // 如果是企业号用以下URL获取access_token
        // $url = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=$this->appId&corpsecret=$this->appSecret";
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$this->appId&secret=$this->appSecret&code=$code&grant_type=authorization_code";
        $res = json_decode($this->httpGet($url));
        $access_token = $res->access_token;
        $openid = $res->openid;
        if ($access_token) {
            $data->expire_time = time() + 7000;
            $data->access_token = $access_token;
            $data->openid = $openid;
            //$fp = fopen("access_token.json", "w");
            //fwrite($fp, json_encode($data));
            //fclose($fp);
        }


        $url = "https://api.weixin.qq.com/sns/userinfo?access_token=$access_token&openid=$openid&lang=zh_CN";
        $userInfo = json_decode($this->httpGet($url));

        return $userInfo;
    }

    /*
    *获取code 做为 换取access_token 的票据 含是否关注
    */
    public function getUserInfoByOpenid($openid)
    {

        $access_token = $this->getAccessToken();

        $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token&openid=$openid&lang=zh_CN";
        $userInfo = json_decode($this->httpGet($url));

        return $userInfo;
    }


    /*
    * 获取用户 openid 根据snsapi_base
    * code 为参数
    */
    public function getOpenid($code)
    {
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$this->appId&secret=$this->appSecret&code=$code&grant_type=authorization_code";
        $res = json_decode($this->httpGet($url));
        $access_token = $res->access_token;
        $openid = $res->openid;

        return $openid;
    }


    /*
    * 发送模板通知 根据access_token
    * access_token 为参数
    */
    public function sendNotification($access_token, $data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=' . $access_token;

        $res = $this->httpPost($url, $data);
        return $res;
    }


    public function httpGet($url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_URL, $url);

        $res = curl_exec($curl);
        curl_close($curl);

        return $res;
    }

    public function httpPost($url, $data = null)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_URL, $url);
        if (!empty($data)) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }

        $res = curl_exec($curl);
        curl_close($curl);

        return $res;
    }

    /**
     * 发送模版信息
     * 返回请求结果
     * @param string $user  openid
     * @param string $templateId templateid
     * @param array $data
     * @param string $url
     * @paran string $topcolor
     * @return string
    */
    public function sendTemplate($user,$templateId,$data,$url='',$topcolor='#ffffff'){
        $accessToken =  $this->getAccessToken();
        $sendData = array(
            'touser' => $user,
            'template_id' => $templateId,
            'url' => $url,
            'topcolor' => $topcolor,
            'data' => $data

        );
        $res = $this->sendNotification($accessToken, urldecode(json_encode($sendData)));
        $this->CI->load->model('LogData');
        $logData = $this->CI->LogData;
        $logData->saveData('sendTemplate',$res);
        return $res;
    }
}

?>