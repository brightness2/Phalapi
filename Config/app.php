<?php
/*
 * @Author: Brightness
 * @Date: 2020-10-19 14:47:20
 * @LastEditors: Brightness
 * @LastEditTime: 2021-01-21 18:12:13
 * @Description: file content
 */
/**
 * 请在下面放置任何您需要的应用配置
 */

return array(

    /**
     * 应用接口层的统一参数
     */
    'apiCommonRules' => array(
        //'sign' => array('name' => 'sign', 'require' => true),
         //登录信息
        // 'userId' => array(
        //     'name' => 'user_id', 'type' => 'int', 'default' => 0, 'require' => false,
        // ),
        // 'otherUserId' => array(
        //     'name' => 'other_user_id', 'type' => 'int', 'default' => 1, 'require' => false,
        // ),
        // 'token' => array(
        //     'name' => 'token', 'type' => 'string', 'default' => '', 'require' => true,
        // ),
    ),

    /**
     * 接口服务白名单，格式：接口服务类名.接口服务方法名
     *
     * 示例：
     * - *.*            通配，全部接口服务，慎用！
     * - Default.*      Api_Default接口类的全部方法
     * - *.Index        全部接口类的Index方法
     * - Default.Index  指定某个接口服务，即Api_Default::Index()
     */
    'service_whitelist' => array(
        // 'Default.Index',
    ),

    /**
     * CRM 配置
     */
    'CRM'=>array(
        //初始菜单配置
        'menu'=> array(
            "homeInfo" => ["title"=>"首页","href"=>"page/CRM/welcome.html?t=1"],#主页
            "logoInfo"=> ["title"=> "CRM后台","image"=> "images/logo.png","href"=> ""],#logo信息
            "menuInfo"=>[
              [
                "title"=> "常规管理",
                "icon"=> "fa fa-address-book",
                "href"=> "",
                "target"=> "_self",
                'child'=>[],#侧边栏菜单从数据库读取，根据用户的权限获取对应的菜单
              ]
                  
            ],
        ),
        'superUser'=>['id'=>1,'user_name'=>'admin'],//超级管理员数据记录
    ),
    
    
);
