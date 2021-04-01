<?php
/*
 * @Author: Brightness
 * @Date: 2020-12-11 16:52:00
 * @LastEditors: Brightness
 * @LastEditTime: 2020-12-15 16:50:04
 * @Description: 微信接口功能测试
 */

class Api_Wechat extends PhalApi_Api {

    public function getRules()
    {
        // $tokenRules = DI()->config->get('app.apiCommonRules.token');
        // $tokenRules['require'] = false;
        return array(
            // '*'=>array(
            //     'token'=>$tokenRules,
            // ),
            'h5GetCode'=>array(
                'code'=>['name'=>'code','desc'=>'微信用户code'],
                'state'=>['name'=>'state','default'=>'1','desc'=>'微信用户code'],

            ),
        );
    }

    /**
     * h5获取用户code
     *
     * @return void
     * @desc
     * @example
     * @author Brightness
     * @since
     */
    public function h5GetCode()
    {  
       
        $appid = 'wxb5d1241c10b353ae';
        $secret = '9f0a77e208ab36032100ccb37ff8d036';
        // $scope = 'snsapi_userinfo';
        $scope = 'snsapi_base';
        $state = $this->state;
        if($this->code){
            $code = $this->code;
            $url2 = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appid."&secret=".$secret."&code=".$code."&grant_type=authorization_code";
            $data = $this->http_request($url2);
            $data = json_decode($data,true);
            $url3 = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$data['access_token'].'&openid='.$data['openid'].'&lang=zh_CN';
            $userInfo = $this->http_request($url3);
            $userInfo = json_decode($userInfo,true);
            return $userInfo;
            // var_dump($_GET);
        }else{
            $redirect = 'http://gzhaolang.gicp.net:38081/piRelease/public/index.php?service=Wechat.h5GetCode';
            $redirect = urlencode($redirect);
            $url ="https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$appid."&redirect_uri=".$redirect."&response_type=code&scope=".$scope."&state=".$state."#wechat_redirect";
            Header("Location:$url");
        }
    }

      //curl请求
   public function http_request($url,$data = null,$headers=array())
   {
 
       $curl = curl_init();
       if( count($headers) >= 1 ){
           curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
       }
       curl_setopt($curl, CURLOPT_URL, $url);
 
 
       curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
       curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
 
 
       if (!empty($data)){
           curl_setopt($curl, CURLOPT_POST, 1);
           curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
       }
       curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
       $output = curl_exec($curl);
       curl_close($curl);
       return $output;
   }
}
?>
