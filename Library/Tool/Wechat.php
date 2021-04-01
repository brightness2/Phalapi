<?php
/*
 * @Author: Brightness
 * @Date: 2020-12-15 14:26:53
 * @LastEditors: Brightness
 * @LastEditTime: 2020-12-15 16:39:35
 * @Description: 测试h5 获取openid
 */
$appid = 'wxb5d1241c10b353ae';
$secret = '9f0a77e208ab36032100ccb37ff8d036';
// $scope = 'snsapi_userinfo';
$scope = 'snsapi_base';

if($_GET['code']){
    $code = $_GET['code'];
    $state = $_GET['state'];
    $url2 = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appid."&secret=".$secret."&code=".$code."&grant_type=authorization_code";
    $data = http_request($url2);
    $data = json_decode($data,true);
    $url3 = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$data['access_token'].'&openid='.$data['openid'].'&lang=zh_CN';
    $userInfo = http_request($url3);
    $userInfo = json_decode($userInfo,true);
    var_dump($userInfo);
    // var_dump($_GET);
}else{
    $redirect = 'https://www.beebuy168.com/test/test.php';
    $redirect = urlencode($redirect);
    $url ="https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$appid."&redirect_uri=".$redirect."&response_type=code&scope=".$scope."&state=1#wechat_redirect";
    Header("Location:$url");
}
 

  //curl请求
   function http_request($url,$data = null,$headers=array())
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
        
?>