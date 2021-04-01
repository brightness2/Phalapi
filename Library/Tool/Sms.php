<?php
/*
 * @Author: Brightness
 * @Date: 2020-09-07 14:30:56
 * @LastEditors: Brightness
 * @LastEditTime: 2020-12-23 22:08:00
 * @Description: 认证短信发送, sendCloude
 * 
 */

class Tool_Sms
{
  public $cache_key_prefix = 'sendTo';#缓存key前缀
  public $sms_template = 'default';#app sms配置 短信模板

  public function __construct()
  {
    $key =  DI()->config->get('app.sms.'.$this->sms_template.'cache_key_prefix');
    if($key) $this->cache_key_prefix = $key;
  }

  /**
   * 发送监控询价提醒短信
   *
   * @param string $phone
   * @param string $fullname
   * @param string $tel
   * @return void
   * @desc
   * @example
   * @author Brightness
   * @since
   */
  public function sendMonitorInfo($phone,$fullname,$tel)
  {
   
    $url = DI()->config->get('app.sms.url');
    $smsUser = DI()->config->get('app.sms.'.$this->sms_template.'.smsUser');
    $templateId = DI()->config->get('app.sms.'.$this->sms_template.'.templateId');
    $msgType = DI()->config->get('app.sms.'.$this->sms_template.'.msgType');
    
    $key = DI()->config->get('app.sms.'.$this->sms_template.'.key');
    
     //发送短信
   
     $params['smsUser']    = $smsUser;
     $params['templateId'] = $templateId;
     $params['msgType']    = $msgType;
     $params['phone']      = $phone;
     $params['vars']       = json_encode(['fullname'=>$fullname,'tel'=>$tel], 1);
     ksort($params);
     
     $sParamStr = '';
     foreach($params as $sKey => $sValue) $sParamStr .= $sKey . '=' . $sValue . '&';
     $sParamStr  = trim($sParamStr, '&');
     $smsKey     =  $key;
     $sSignature = md5($smsKey . "&" . $sParamStr . "&" . $smsKey);
 
     $params['signature'] = $sSignature;
     $data = http_build_query($params);
 
     $options['http']['method']  = 'POST';
     $options['http']['header']  = 'Content-Type:application/x-www-form-urlencoded';
     $options['http']['content'] = $data;
 
     $context = stream_context_create($options);
     $result  = file_get_contents($url, FILE_TEXT, $context);
     
     $data =  json_decode($result,true);
     if($data['result'] != true) DI()->logger->info('Domain_Sms send warn:sms send error',json_encode($data));
     return $data;
    
  }

  /**
   * 发送手机验证码
   *
   * @param string $phone
   * @return void
   * @desc
   * @example
   * @author Brightness
   * @since
   */
  public function sendSMSCode($phone)
  {   
      //校验手机号码有效性
      $domain_validate = new Domain_Validate;
      $bool_valid = $domain_validate->check(['mobile'=>$phone],['mobile'=>'mobile'],['mobile'=>['mobile'=>'手机号格式错误']]);
      
      if($bool_valid !==true) throw new MTS_ZException($bool_valid);
      //生成验证码
      
      $code = $this->createCode();
      $bool_cache = $this->cacheMobileCode($this->cache_key_prefix.$phone,$code);
      if(!$bool_cache) throw new MTS_ZException('验证码获取失败');
      return $code;#
      
      $data = $this->send($phone,$code);
      $data['code'] = $code;
      return $data;
  }
  /**
   * 发送
   *
   * @param string $phone
   * @param string $code
   * @param string $url
   * @return void
   * @desc
   * @example
   * @author Brightness
   * @since
   */
  public function send($phone,$code)
  {
    $url = DI()->config->get('app.sms.url');
    $smsUser = DI()->config->get('app.sms.'.$this->sms_template.'.smsUser');
    $templateId = DI()->config->get('app.sms.'.$this->sms_template.'.templateId');
    $msgType = DI()->config->get('app.sms.'.$this->sms_template.'.msgType');
    $vars = DI()->config->get('app.sms.'.$this->sms_template.'.vars');
    $key = DI()->config->get('app.sms.'.$this->sms_template.'.key');
    //发送短信
   
    $params['smsUser']    = $smsUser;
    $params['templateId'] = $templateId;
    $params['msgType']    = $msgType;
    $params['phone']      = $phone;
    $params['vars']       = '{"%' . $vars. '%":"' . $code . '"}';
    ksort($params);
    
    $sParamStr = '';
    foreach($params as $sKey => $sValue) $sParamStr .= $sKey . '=' . $sValue . '&';
    $sParamStr  = trim($sParamStr, '&');
    $smsKey     =  $key;
    $sSignature = md5($smsKey . "&" . $sParamStr . "&" . $smsKey);

    $params['signature'] = $sSignature;
    $data = http_build_query($params);

    $options['http']['method']  = 'POST';
    $options['http']['header']  = 'Content-Type:application/x-www-form-urlencoded';
    $options['http']['content'] = $data;

    $context = stream_context_create($options);
    $result  = file_get_contents($url, FILE_TEXT, $context);
    
    $data =  json_decode($result,true);
    if($data['result'] != true) DI()->logger->info('Domain_Sms send warn:','sms send error');
    return $data;
  }

  /**
   * 生成验证码
   *
   * @return void
   * @desc
   * @example
   * @author Brightness
   * @since
   */
  protected function createCode()
  {
    $verifyCode = substr(mt_rand(1000000,10000000),-6,6);
    return $verifyCode;
  }
 /**
  * 缓存验证码
  *
  * @param string $key
  * @param string $code
  * @return void
  * @desc checkMobileCode 时检验
  * @example
  * @author Brightness
  * @since
  */
  protected function cacheMobileCode($key,$code,$time=180)
  {
    $domain_cache = new Tool_Cache(DI()->config->get('app.cache.default_dir').'mobileCode'.D_S);
    $res = $domain_cache->set($code,$key,$time);
    if(!$res){
      DI()->logger->debug('Domain_Sms cacheMobileCode error:','cache code error');
    }
    return $res;
  }
  /**
   * 检测验证吗是否存在
   *
   * @param string $key
   * @return void
   * @desc
   * @example
   * @author Brightness
   * @since
   */
  public function checkMobileCode($key)
  {
    $domain_cache = new Tool_Cache(DI()->config->get('app.cache.default_dir').'mobileCode'.D_S);
    $res = $domain_cache->get($key);
    return $res;
  }
}

 ?>
