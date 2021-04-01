<?php
/*
 * @Author: Brightness
 * @Date: 2020-10-21 16:49:49
 * @LastEditors: Brightness
 * @LastEditTime: 2020-10-21 18:21:15
 * @Description: 登录
 */
class Domain_Login{

    public function checkUserName($username)
    {
        $model = new Model_User;
        $user = $model->getByUserName($username);
        return $user;
    }

    public function checkPassword($loginPass,$realPass)
    {   
        $loginPass = $this->_encrypt($loginPass);
    
        return $loginPass === $realPass;
    }

    public function checkIsLogin()
    {
        return DI()->userLite->check();
    }
    protected function _encrypt($password)
    {
        return md5($password);
    }
}
?>