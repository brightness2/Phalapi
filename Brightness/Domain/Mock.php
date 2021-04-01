<?php
/*
 * @Author: Brightness
 * @Date: 2020-12-29 15:28:53
 * @LastEditors: Brightness
 * @LastEditTime: 2020-12-31 09:49:34
 * @Description: Mock接口业务，处理业务相关的逻辑
 */

class Domain_Mock{


    public function getById($id)
    {
        if(!$id) return false;
        try {
            $user_dbobj = new Model_MyUser();
            $user_dbobj->addParams(['id'=>$id]);
            $res = $user_dbobj->getByParams();
        } catch (Exception $e) {
            DI()->logger->debug('Domain_Mock getById error not find user ,id:'.$id,print_r($e->getMessage()));
            throw new MTS_ZException('数据获取失败');
        }
        
        return $res;
    }

   public function test()
   {
       $user_dbobj = new Model_MyUser();
    //    $user_dbobj->insert(['username'=>'Brightness','password'=>md5('123456')]);
       $user_dbobj->addParams(['id'=>1]);
       $res = $user_dbobj->setQuery();

       return $res;
   }

    public function getUserById( $userId )
    {
        $user_dbobj = new Model_MyUser;#数据库操作
        $res =  $user_dbobj->get($userId);

        if( false == $res ){
            DI()->logger->debug('Domain_Mock->getUserById error:not find row,id is'.$userId);
            throw new MTS_ZException(T('user not exists'));
        }
        return $res;
    }

    //数据库操作例子

    
}
?>