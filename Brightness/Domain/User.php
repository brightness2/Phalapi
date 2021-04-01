<?php
/*
 * @Author: Brightness
 * @Date: 2020-10-20 15:50:31
 * @LastEditors: Brightness
 * @LastEditTime: 2020-12-02 11:19:19
 * @Description: 领域层 业务逻辑
 */
class Domain_User{

    public function getUserById( $userId )
    {
        $USER_OBJECT = new Model_User;#数据库操作
        $res =  $USER_OBJECT->get($userId);
        // $res =  $USER_OBJECT->getByUserId($userId);

        if( false == $res ) throw new MTS_ZException(T('user not exists'));
        return $res;
    }

    //数据库操作例子

    
}
?>