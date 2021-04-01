<?php
/*
 * @Author: Brightness 
 * @Date: 2021-03-05 14:15:53 
 * @Last Modified by: Brightness
 * @Last Modified time: 2021-03-05 16:27:20
 * @Description：JWT 实现
 */

 class APi_Jwt extends PhalApi_Api{
    public function getRules()
    {
        return array(
           
            'check'=>array(),
        );
    }     
    /**
     * 测试jwt
     *
     * @return void
     */
    public function check()
    {
        $payload=array('sub'=>'1234567890','name'=>'John Doe','iat'=>1516239022);
        $token =  Tool_Jwt::getToken($payload);
        return $getPayload = Tool_Jwt::verifyToken($token);
    
        return [
            'token'=>$token,
            'getPayload'=>$getPayload
        ];
    }
 }

?>