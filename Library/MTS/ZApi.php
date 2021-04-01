<?php
/*
 * @Author: Brightness
 * @Date: 2021-01-05 09:49:49
 * @LastEditors: Brightness
 * @LastEditTime: 2021-01-25 09:07:10
 * @Description: 基础接口类
 */
    class MTS_ZApi extends PhalApi_Api {

        protected $currUser; #当前登录用户
        
        public function __construct()
        {   
           
        }

        /**
         * 获取接口参数
         *
         * @param string $action
         * @return array
         * @desc 配合 getRules 使用
         * @example
         * @author Brightness
         * @since
         */
        protected function getApiParams($action){
            $data = $this->getRules();
            $result =[];
            foreach($data[$action] as $key => $param){
                $result[$key] = $this->$key;
            }
            return $result;
        }

        /**
         * 检查用户是否存在
         *
         * @param string $userId
         * @return void
         * @desc
         * @example
         * @author Brightness
         * @since
         */
        protected function checkUser($userId='',$return = false)
        {
            return __FUNCTION__;
            // $userId = $userId?$userId:DI()->request->get('userId');
            // if(!$userId) throw new MTS_ZException('缺少用户id，请先登录');
            // $id = DI()->encrypt->decodeId($userId);
            // $model = new Model_User();
            // $user =  $model->get($id);
            // if(!$user){
            //     throw new MTS_ZException('用户账号有误或登录已过期，请重新登录');
            // }
            // $this->loginUser = $user;
            // if($return) return $user;
        }

        /**
         * 检查用户接口权限
         *
         * @return void
         * @desc service 不区分大小写，全部转成小写
         * @example
         * @author Brightness
         * @since
         */
        protected function checkUserPermission()
        {
            return __FUNCTION__;
            // //判断是否传递用户ID
            // $userId = DI()->request->get('userId');#加密过的用户ID
            // if('' == $userId or null == $userId){
            //     throw new MTS_ZException('你没有该权限');
            // }
            // //获取请求的资源(即 方法)
            // $service =  DI()->request->getService();
            // $userId = DI()->encrypt->decodeId($userId);#解码用户ID

            // //根据用户ID service 获取资源
            // $user_domain = new Domain_User();
            // $res =  $user_domain->getApiModulePermission($userId,$service,'*');
         
            // if(!$res) throw new MTS_ZException('你没有该权限');
            // return $res;
        }
    }
?>
