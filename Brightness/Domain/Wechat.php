<?php
/*
 * @Author: Brightness
 * @Date: 2020-12-07 10:14:14
 * @LastEditors: Brightness
 * @LastEditTime: 2020-12-07 13:49:15
 * @Description:   h5 获取微信用户信息
 */
class Domain_Wechat{

  
    // public function  do()
    // {
    //     // 设置微信公众号的appid （建议保存到数据库直接获取）
    //     // $appid = '********';
        
    //     // $redirect_uri = urlencode ( 'http://XXX你的路径XX/文件2.php' );
    //     // $url ="https://open.weixin.qq.com/connect/oauth2/authorize?appid=$appid&redirect_uri=$redirect_uri&response_type=code&scope=snsapi_base&state=1#wechat_redirect";
    //     // header("Location:".$url);
    // }

    public function do()
    {
        
    }
    public function curlRequest($url)
    {
        $curl = new PhalApi_CUrl;
        return $curl->get($url);
    }

    // function getJson($url){
    //     $ch = curl_init();
    //     curl_setopt($ch, CURLOPT_URL, $url);
    //     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    //     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    //     $output = curl_exec($ch);
    //     curl_close($ch);
    //     return json_decode($output, true);
    // }
}
?>