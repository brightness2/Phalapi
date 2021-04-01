<?php
/*
 * @Author: Brightness
 * @Date: 2020-12-11 14:35:47
 * @LastEditors: Brightness
 * @LastEditTime: 2020-12-23 22:14:17
 * @Description: 图形验证码业务类
 */

 class Tool_VerifyCode
 {

    public function __construct()
    {
        $this->captcha = new Tool_Captcha_Captcha;
        $this->cache = new Tool_Cache(DI()->config->get('app.cache.default_dir').'verifyCode'.D_S);
       
    }
    /**
     * 输出图片
     *
     * @return void
     * @desc
     * @example
     * @author Brightness
     * @since
     */
    public function createImage()
    {
        $this->captcha->createImage();
        $this->cacheverifyCode();
    }

    /**
     * 检测验证码
     *
     * @return void
     * @desc
     * @example
     * @author Brightness
     * @since
     */
    public function checkVerifyCode($vertifyCode)
    {
        $res = $this->cache->get($vertifyCode);
        if(!$res) throw new MTS_ZException('验证码错误,请重新输入验证码');
        $this->cache->delete($vertifyCode);
        return true;
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
    private function cacheverifyCode()
    {
        $code = $this->captcha->getCode();
        $res = $this->cache->set($code,$code,180);
        if(!$res){
        DI()->logger->debug('Domain_VertifyCode cacheverifyCode error:','cache verify code error');
        }

    }

 }
?>