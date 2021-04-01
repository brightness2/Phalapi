<?php
/*
 * @Author: Brightness 
 * @Date: 2021-03-05 15:06:49 
 * @Last Modified by: Brightness
 * @Last Modified time: 2021-03-05 17:55:59
 * JWT 实现
 */

class Tool_Jwt
{   
    //头部
    private static $header = [
        'alg'=>'HS256',//生成signature的算法
        'typ'=>'JWT',//类型
    ];

    //使用HMAC生成信息摘要时使用的秘钥
    private static $key = 'Brightness';

    /**
     * 获取jwt token
     * @param array $payload jwt载荷   格式如下非必须
     * [
     *  'iss'=>'jwt_admin',  //该JWT的签发者
     *  'iat'=>time(),  //签发时间
     *  'exp'=>time()+7200,  //过期时间
     *  'nbf'=>time()+60,  //该时间之前不接收处理该Token
     *  'sub'=>'www.admin.com',  //面向的用户
     *  'jti'=>md5(uniqid('JWT').time())  //该Token唯一标识
     * ]
     * @return bool|string
     */
    public static function getToken($payload)
    {
        if(is_array($payload))
        {
            $base64_header = self::encode(json_encode(self::$header,JSON_UNESCAPED_UNICODE));
            $base64_payload = self::encode(json_encode($payload,JSON_UNESCAPED_UNICODE));
            $token = $base64_header.'.'.$base64_payload.'.'.self::signature($base64_header.'.'.$base64_payload,self::$key,self::$header['alg']);
            return $token;
        }else{
            return false;
        }
    }

     /**
     * 验证token是否有效,默认验证exp,nbf,iat时间
     * @param string $Token 需要验证的token
     * @return bool|string
     */
    public static function verifyToken($token)
    {
     
        $tokens = explode('.',$token);
        if(count($tokens) != 3)
            return false;
        
  
        $base64_header = $tokens[0];
        $base64_payload = $tokens[1];
        $sign = $tokens[2];
        
        //获取jwt算法
        $base64_decode_header = json_decode(self::decode($base64_header),JSON_OBJECT_AS_ARRAY);
       
        if(empty($base64_decode_header['alg']))
            return false;
        
        //签名验证
        if(self::signature($base64_header.'.'.$base64_payload,self::$key,$base64_decode_header['alg']) !== $sign)
            return false;

        //获取$payload jwt载荷
        $payload = json_decode(self::decode($base64_payload),JSON_OBJECT_AS_ARRAY);
     
        
         //签发时间大于当前服务器时间验证失败
         if(isset($payload['iat']) AND $payload['iat'] > time())
            return false;

        //过期时间小于当前服务器时间验证失败
        if(isset($payload['exp']) AND $payload['exp'] < time())
            return false;
    
        
        //该nbf时间之前不接收处理该Token
        if(isset($payload['nbf']) AND $payload['nbf'] > time())
            return false;

        return $payload;

    }

    /**
     * encode   https://jwt.io/  中base64_encode编码实现
     * @param string $string 需要编码的字符串
     * @return string
     */
    private static function encode($string)
    {
        return str_replace('=','',strtr(base64_encode($string),'+/','-_'));
    }
    
     /**
     * encode  https://jwt.io/  中base64_encode解码实现
     * @param string $string 需要解码的字符串
     * @return bool|string
     */
    private static function decode($string)
    {
       $remainder = strlen($string) % 4;
       if($remainder)
       {
           $addlen = 4 - $remainder;
           $string .= str_repeat('=',$addlen);
       }
       return base64_decode(strtr($string,'-_','+/'));
    }

    /**
     * HMACSHA256签名   https://jwt.io/  中HMACSHA256签名实现
     * @param string $string 为encode(header).".".encode(payload)
     * @param string $key
     * @param string $alg   算法方式
     * @return mixed
     */
    private static function signature($string,$key,$alg = 'HS256')
    {
        $alg_config = ['HS256' => 'sha256'];
        return self::encode(hash_hmac($alg_config[$alg],$string,$key,true));
    }

}

?>